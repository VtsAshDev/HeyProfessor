<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, put};

it('should be able to update a question', closure: function () {
    $user = User::factory()->create();

    $question = Question::factory()->for($user, 'createdBy')->create([
        'draft' => true,
    ]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'Updated Question?',
    ])->assertRedirect();

    $question->refresh();

    expect($question)->question->toBe('Updated Question?');
});

it('souhld mae sure only question with status "DRAFT" can be edited ', function () {
    $user = User::factory()->create();

    $questionNotDraft = Question::factory()->for($user, 'createdBy')
        ->create([
            'draft' => false,
        ]);
    $draftQuestion = Question::factory()->for($user, 'createdBy')
        ->create([
            'draft' => true,
        ]);

    actingAs($user);

    put(route('question.update', $questionNotDraft), [
        'question' => 'Updated Question?',
    ])->assertForbidden();
    put(route('question.update', $draftQuestion), [
        'question' => 'Updated Question?',
    ])->assertRedirect();
});

it('should mae sure that only the person who has created the question can update it', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create([
        'draft'      => true,
        'created_by' => $rightUser->id,
    ]);

    actingAs($wrongUser);
    put(route('question.update', $question), [
        'question' => 'Updated Question?',
    ])->assertForbidden();

    actingAs($rightUser);
    put(route('question.update', $question), [
        'question' => 'Updated Question?',
    ])->assertRedirect();
});

it('should be able to update a question bigger than 255 characters', function () {

    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')
        ->create([
            'draft' => true,
        ]);

    actingAs($user);

    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    $request->assertRedirect();
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', [
        'question' => str_repeat('*', 260) . '?']);

});

it('should check if ends with question mark ? ', function () {
    // Arrange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')
        ->create([
            'draft' => true,
        ]);

    actingAs($user);

    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 10),
    ]);

    $request->assertSessionHasErrors([
        'question' => 'Are you sure is a question? It is missing a question mark in the end.',
    ]);

    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});

it('should have at least 10 characters', function () {
    // Arrange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create([
        'draft' => true,
    ]);

    actingAs($user);

    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});
