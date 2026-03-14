<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

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

it('should paginate result', function () {
    $user = User::factory()->create();

    actingAs($user);

    Question::factory(20)->create();

    get(route('dashboard'))
    ->assertViewHas('questions', function ($value) {
        return $value instanceof LengthAwarePaginator;
    });

});

it('should ordery by like and unlike, most liked question should be at the top, must unliked questions should be in the bottom', function () {

    $user       = User::factory()->create();
    $secondUser = User::factory()->create();
    Question::factory(5)->create();

    $mostLikedQuestion   = Question::find(3);
    $mostUnlikedQuestion = Question::find(1);

    $user->like($mostLikedQuestion);
    $secondUser->unlike($mostUnlikedQuestion);

    actingAs($user);

    get(route('dashboard'))
        ->assertViewHas('questions', function ($questions) {

            expect($questions)
                ->first()->id->toBe(3)
                ->and($questions)
                ->last()->id->toBe(1);

            return true;
        });
});
