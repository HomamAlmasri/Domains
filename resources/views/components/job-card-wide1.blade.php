@props(['domain'])
<x-panal class="flex flex-col text-center bg-red-700">
    <section>
        <div class="self-start text-sm font-bold text-blue-300 text-center" >{{ $domain->url }} </div>
        <div class="py-8">
            <h3 class="font-bold group-hover:text-blue-800 text-sm transition-color duration-300">{{ $domain->name }}</h3>
            <div class="self-start">
                <x-forms.form method="POST" action="/domains/{{ $domain->id }}">
                    @method('DELETE')
                    <x-forms.button class="bg-red-700 text-xs" onclick="return confirmDelete()">Delete</x-forms.button>
                </x-forms.form>
            </div>
        </div>
    </section>
</x-panal>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this domain?');
    }
</script>
