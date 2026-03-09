@props([
    'action',
    'post' => null,
    'put' => null,
    'delete' => null
])
<div class="p-6 text-gray-900 dark:text-gray-100">
    <form action = "{{route('question.store')}}" method="post">
        @csrf

        @if($put)
            @method('PUT')
        @endif

        @if($delete)
            @method('DELETE')
        @endif

        {{ $slot }}
    </form>
</div>
