<x-layout>
    <section>
        <x-heading>Domains</x-heading>
        <div class="mt-6 space-y-6">
            @foreach ($results as $result)
                <a href="{{$result['domain']}}">
                <x-job-card-wide2 :result="$result"/>
                </a>
            @endforeach
        </div>
    </section>
</x-layout>

