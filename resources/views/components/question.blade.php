@props([
    'question'
])

<div class="rounded-md dark:bg-gray shadow shadow-blue-500/50 p-4 mb-2 dark:text-gray-400 flex justify-between items-center ">
    <div class="dark:text-gray-400 space-y-4">
        {{ $question->question }}
    </div>
    <div>
        <x-form :action="route('question.like', $question)" class="">
        <button  class="flex items-center justify-center space-x-2 text-green-500 hover:text-green-300">
            <x-icons.thumbs-up class="w-5 h-5  cursor-pointer"/>
            <span>
                {{ $question->likes }}
            </span>
        </button>
        </x-form>
        <a href="{{ route('question.like', $question) }} " class="flex items-center justify-center space-x-2 text-red-500 hover:text-red-300">
            <x-icons.thumbs-down class="w-5 h-5 cursor-pointer"/>
            <span>
                {{ $question->unlikes }}
            </span>
        </a>
    </div>
</div>
