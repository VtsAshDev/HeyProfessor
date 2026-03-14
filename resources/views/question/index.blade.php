<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('My Questions') }}
        </x-header>
    </x-slot>



    <x-container>
        <x-form post :action="route('question.store')">
            <x-text-area label="Question" name="question"/>

            <x-btn.primary>Save</x-btn.primary>
            <x-btn.reset>Cancel</x-btn.reset>
        </x-form>

        <hr class=" p-2 border-gray-700 border-dashed my-4"/>
        {{--        Listagem    --}}
        <div class="dark:text-gray-400 uppercase font-bold pl-6 mb-1">
            My Questions
        </div>
        <div class="dark:text-gray-400 p-6">

            <x-table>
                <x-table.head>
                    <tr>
                        <x-table.th> Question</x-table.th>
                        <x-table.th> Actions</x-table.th>
                    </tr>
                </x-table.head>
                <tbody>
                @foreach($questions->where('draft', true) as $question)
                    <x-table.tr>
                        <x-table.td> {{ $question->question }}</x-table.td>
                        <x-table.td>
                            <x-form :action="route('question.publish', $question)" put>
                                <x-btn.primary type="submit">Publish</x-btn.primary>
                            </x-form>
                            <x-form :action="route('question.destroy', $question)" delete onsubmit="return confirm('Tem certeza ?')">
                                <x-btn.cancel type="submit">Delete</x-btn.cancel>
                            </x-form>

                            <a href="{{ route('question.edit', $question) }}">
                              <x-secondary-button>
                               Editar
                              </x-secondary-button>
                            </a>

                        </x-table.td>
                    </x-table.tr>
                @endforeach
                </tbody>
            </x-table>
        </div>
        <hr class=" p-2 border-gray-700 border-dashed my-4"/>
        <div class="dark:text-gray-400 uppercase font-bold pl-6 mb-1">
            Drafts
        </div>
        <div class="dark:text-gray-400 p-6">

            <x-table>
                <x-table.head>
                    <tr>
                        <x-table.th> Question</x-table.th>
                        <x-table.th> Actions</x-table.th>
                    </tr>
                </x-table.head>
                <tbody>
                @foreach($questions->where('draft', false) as $question)
                    <x-table.tr>
                        <x-table.td> {{ $question->question }}</x-table.td>
                        <x-table.td>
                            <div class="flex items-center justify-start">
                                <x-form :action="route('question.archive', $question)" patch>
                                    <x-btn.edit>Archive</x-btn.edit>
                                </x-form>
                                <x-form :action="route('question.destroy', $question)" delete>
                                    <x-btn.cancel>Delete</x-btn.cancel>
                                </x-form>
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
                </tbody>
            </x-table>
        </div>
        <div class="dark:text-gray-400 uppercase font-bold pl-6 mb-1">
            Archived Questions
        </div>
        <div class="dark:text-gray-400 p-6">

            <x-table>
                <x-table.head>
                    <tr>
                        <x-table.th> Question</x-table.th>
                        <x-table.th> Actions</x-table.th>
                    </tr>
                </x-table.head>
                <tbody>
                @foreach($archivedQuestions as $question)
                    <x-table.tr>
                        <x-table.td> {{ $question->question }}</x-table.td>
                        <x-table.td>
                            <div class="flex items-center justify-start">
                                <x-form :action="route('question.restore', $question)" patch>
                                    <x-btn.primary>Restore</x-btn.primary>
                                </x-form>
                                <x-form :action="route('question.destroy', $question)" delete onsubmit="return confirm('Tem certeza ? ')">
                                    <x-btn.cancel>Delete</x-btn.cancel>
                                </x-form>
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
                </tbody>
            </x-table>
        </div>
    </x-container>
</x-app-layout>
