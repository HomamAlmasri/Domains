@props(['job'])
<x-panal class="flex flex-col text-center">
    <a href="/jobs/{{ $job->id }}">
        <div class="self-start text-sm">{{ $job->employer->name }} </div>

        <div class="py-8 ">
            <h3 class="font-bold group-hover:text-blue-800 text-xl transition-color duration-300">{{ $job->title }}
            </h3>
            <p class="mt-4 text-sm">{{ $job->salary }} </p>
        </div>
    </a>

    <div class="flex justify-between items-center mt-auto">
        <div>
            @foreach ($job->tags as $tag)
                <x-tags :$tag size="small"></x-tags>
            @endforeach
        </div>
        <x-employer-logo :width='42' />
    </div>
</x-panal>
