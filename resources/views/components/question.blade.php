@props([
    'question'
])

<div class="rounded-md dark:bg-gray shadow shadow-blue-500/50 p-4 mb-2 dark:text-gray-400 ">
    <div class="dark:text-gray-400 space-y-4">
        {{ $question->question }}
    </div>
</div>
