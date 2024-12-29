<x-layout>
    <div class="container">
        @php
            $lastSegment = \Illuminate\Support\Str::afterLast($repoPath, '\\');
        @endphp

        <x-heading>Repository Status For : <span class="text-cyan-300">{{ $lastSegment }}</span></x-heading>

        @if (session('error'))
            <p class="error">{{ session('error') }}</p>
        @elseif (!empty($gitLog))
            <div class="flex flex-wrap gap-4 mt-5">
                @foreach($gitLog as $branch => $details)
{{--                    @dd($repoPath,$details)--}}
{{--                    @if() @endif--}}
                    <div class="p-4     basis-1/2 max-w-[48%] box-border border rounded-lg bg-gray-800">
                        <div class="flex justify-between">
                            <h2 class="text-red-300 mb-3">Branch: <span class="text-yellow-300">{{ $branch }}</span></h2>
                            @if ($loop->first)
                                <div>
                                <p class="bg-green-900 rounded-lg p-2 flex items-center text-white">NEWEST</p>
                                </div>
                            @endif
                        </div>

                        @if (is_array($details) && isset($details['message']))
                            <ul>
                                <li class="text-blue-300">
                                    <strong>Name:</strong> {{ $details['name'] }}
                                    <br>
                                    <strong>Email:</strong> {{ $details['email'] }}
                                    <br>
                                    <strong>Date:</strong> {{ $details['date'] }}
                                    <br>
                                    <strong>Commit Message:</strong> {{ $details['message'] }}
                                </li>
                            </ul>
                        @else
                            <p class="text-red-500">No log details available for this branch.</p>
                        @endif
                    </div>
                @endforeach

            </div>
        @else
            <p>No commits found in this repository.</p>
        @endif
    </div>
</x-layout>
