<x-layout>
    <div class="container">

        <x-heading>Check Repository Status</x-heading>

        <!-- Error message display -->
{{--        @if (session('error'))--}}
{{--            <p class="error">{{ session('error') }}</p>--}}
{{--        @endif--}}

        <!-- Input form -->
        <section class="">
        <x-forms.form method="POST" action="{{ route('repo.status') }}"  class="space-y-9">

            <x-forms.select label='Repo Name' type="text" name='repo_path' class="px-3">
                @foreach ($paths as $key => $path)

                    <option value="{{ $path }}" class="bg-black text-blue-300 text-sm">{{ $key }}</option>
                @endforeach
            </x-forms.select>

            @if (session('error'))
                <div class="border-2 flex justify-center gap-2 items-center w-fit p-2 m-auto border-solid border-yellow-300 rounded-xl px-3 py-1 animate-bounce">
                    <img class="w-5 aspect-square" src="{{ asset('storage/images/warning.png') }}" alt="warning" />
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div>
                <div class="bg-blue-500/20 my-2 h-px w-full"></div>
            </div>
            <x-forms.button class="hover:bg-blue-900 -mt-8">Check</x-forms.button>
        </x-forms.form>
        </section>
    </div>
</x-layout>
