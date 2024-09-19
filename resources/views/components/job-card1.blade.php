@props(['task'])
<x-panal class="flex flex-col text-center">
    <a href="/task/{{ $task->id }}">
        <div class="self-start text-xl font-bold text-blue-300">{{ $task->employer_name }} </div>

        <div class="py-8 ">
            <h3 class="font-bold group-hover:text-blue-800 text-xl transition-color duration-300">{{ $task->title }}
            </h3>
            <p class="mt-4 text-sm">Expected {{ $task->time_expected }} Hour</p>
        </div>
    </a>

    <div class="flex justify-between items-center mt-auto">
        <div>

            <x-tags :$task size="small"></x-tags>

        </div>
        <x-employer-logo :width='42' />
    </div>
</x-panal>
