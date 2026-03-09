<x-app-layout>
    <x-header>
        <x-slot name="header">
            {{ __('Dashboard') }}
        </x-slot>
    </x-header>


    <x-container>
        <x-form post :action="route('question.store')">
            <x-text-area label="Question" name="question"/>

            <x-btn.primary>Save</x-btn.primary>
            <x-btn.reset>Cancel</x-btn.reset>
        </x-form>

    <hr class=" p-2 border-gray-700 border-dashed my-4"/>
{{--        Listagem    --}}
        <div class="dark:text-gray-400 uppercase font-bold pl-6 mb-1">List of Questions</div>
            <div class="dark:text-gray-400 p-6">

            @foreach($questions as $item)
                <x-question :question="$item"/>
            @endforeach
            </div>

    </x-container>
</x-app-layout>
