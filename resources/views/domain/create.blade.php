<x-layout>
    <section class="text-center">
        <p class="font-bold text-4xl hover:text-blue-500 transition-color duration-300">Create The Domain</p>
    </section>
    <section class="">
        <x-forms.form method='POST' action="{{route('domain.store')}}" class="space-y-9">
            <x-forms.input label="URl" name="url" placeholder="https://...." />
            <x-forms.input label="Name" name="name" placeholder="Zahi" />
            <x-forms.button>Publish</x-forms.button>
        </x-forms.form>
    </section>
</x-layout>

