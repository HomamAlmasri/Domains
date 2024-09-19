@props(['job'])
<x-panal class="flex gap-x-6">
    <div>
        <x-employer-logo />
    </div>

    <div class="flex-1 flex flex-col">
        <a href="#" class="self-start text-gray-400 text-sm ">{{ $job->employer->name }}</a>

        <h3 class="font-bold text-xl mt-2 group-hover:text-blue-800 transition-color duration-300"> {{ $job->title }}
        </h3>
        <p class="text-sm text-gray-400 mt-auto">{{ $job->salary }} </p>
    </div>
    <div>
        @foreach ($job->tags as $tag)
            <x-tags :$tag>Backend</x-tags>
        @endforeach
    </div>
</x-panal>
