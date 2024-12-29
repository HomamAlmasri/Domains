<x-layout>
    <section>
        <x-heading>Domains</x-heading>
        <div class="mt-6 space-y-6 ">
            @foreach ($results as $result)
                <a class="my-5" href="{{$result['domain']}}">
                <x-job-card-wide2 :result="$result"/>
                </a>
            @endforeach
        </div>
        {{-- {{ $domains->links() }} --}}
    </section>
</x-layout>

