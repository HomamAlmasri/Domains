<x-layout>

        <x-heading>Domains</x-heading>
        <div class="grid lg:grid-cols-3 gap-6 mt-2 mb-5">
            @foreach ($domains as $domain)
                <a href="/domains/edit/{{ $domain->id }}">
                <x-job-card-wide1 :domain="$domain"/>
                </a>
            @endforeach
        </div>
        {{ $domains->links() }}
</x-layout>

