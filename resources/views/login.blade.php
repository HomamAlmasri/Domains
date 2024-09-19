<x-layout>
    <h1 class="font-bold text-center text-4xl mb-8">LOG IN</h1>
    <x-forms.form method="POST" action="/login">
        <x-forms.input label="Email" name="email" type="email" />
        @error('email')
        <div class="bg-red-500 rounded-xl px-3 py-1">{{ $message }}</div>
        @enderror
        <x-forms.input label="Password" name="password" type="Password" />
        @error('password')
        <div class="bg-red-500 rounded-xl px-3 py-1">{{ $message }}</div>
        @enderror
        <x-forms.divider />
        <x-forms.button class="hover:bg-blue-900">Log in</x-forms.button>
    </x-forms.form>
</x-layout>
