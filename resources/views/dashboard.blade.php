<x-app-layout>
    <x-header>
        <x-slot name="header">
            {{ __('Vote for a question') }}
        </x-slot>
    </x-header>


    <x-container>
        <div class="dark:text-gray-400 uppercase font-bold pl-6 mb-1">List of Questions</div>
            <div class="dark:text-gray-400 p-6">

            @foreach($questions as $item)
                <x-question :question="$item"/>
            @endforeach
            </div>

    </x-container>
</x-app-layout>
