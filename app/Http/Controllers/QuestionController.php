<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\EndWithQuestionMarkRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {

        return view('question.index', [
            'questions' => user()->questions,
        ]);
    }

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

        return back();
    }

    public function destroy(Question $question): RedirectResponse
    {
        Gate::authorize('destroy', $question);

        $question->delete();

        return back();
    }

}
