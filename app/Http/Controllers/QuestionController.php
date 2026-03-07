<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {

        Question::query()->create(
            request()->validate([
                'question' => [
                    'required', 'min:10',
                    function (string $atribute, mixed $value, Closure $fail) {
                        if ($value[strlen($value) - 1] != '?') {
                            $fail('Are you sure is a question? It is missing a question mark in the end.');
                        }
                    },
                ],
            ])
        );

        return redirect(route('dashboard'));
    }
}
