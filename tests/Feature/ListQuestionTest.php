<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {
    //Arrange
    //criar algumas perguntas
    $user = User::factory()->create();

    actingAs($user);

    $questions = Question::factory(5)->create();

    //Act
    //Acessar a rota
    $response = get(route('dashboard'));

    //Assert
    /**
     * @var Question $q
     */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }

});
