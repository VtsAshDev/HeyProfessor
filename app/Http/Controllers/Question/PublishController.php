<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class PublishController extends Controller
{
    public function __invoke(Question $question): RedirectResponse
    {
        //        abort_unless(user()->can('publish', $question), Response::HTTP_FORBIDDEN);
        Gate::authorize('publish', $question);

        $question->update([
            'draft' => false,
        ]);

        return back();
    }
}
