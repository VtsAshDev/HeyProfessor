<?php

namespace App\Http\Controllers;

use App\Rules\EndWithQuestionMarkRule;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {
        $attributes = request()->validate([
            'question' => [
                'required',
                'min:10',
                new EndWithQuestionMarkRule(),
            ],
        ]);

        user()->questions()->create([
            'question' => $attributes['question'],
            'draft'    => true,
        ]);

        return redirect(route('dashboard'));
    }
}
