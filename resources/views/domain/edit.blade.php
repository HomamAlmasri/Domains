<x-layout>
    <x-forms.form method="post" action="{{ route('domain.update', $domain->id) }}">

        @method('PATCH') <!-- Spoof the PATCH method -->

        <x-forms.input label="URL" name="url" value="{{ $domain->url }}"></x-forms.input>
        @error('url')
        <div class="bg-red-500 rounded-xl px-3 py-1">{{ $message }}</div>
        @enderror

        <x-forms.input label="Name" name="name" value="{{ $domain->name }}"></x-forms.input>
        @error('name')
        <div class="bg-red-500 rounded-xl px-3 py-1">{{ $message }}</div>
        @enderror

        <x-forms.button>Publish</x-forms.button>
    </x-forms.form>
</x-layout>
