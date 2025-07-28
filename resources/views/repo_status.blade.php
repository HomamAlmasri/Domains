<x-layout>
    <div class="container">
        @php
            $lastSegment = \Illuminate\Support\Str::afterLast($repoPath, '\\');
        @endphp

        <x-heading>
            Repository Status For: <span class="text-cyan-300 font-semibold">{{ $lastSegment }}</span>
        </x-heading>

        @if (session('error'))
            <p class="error">{{ session('error') }}</p>
        @elseif (!empty($gitLog))
            <div class="flex flex-wrap gap-4 mt-6">
                @foreach($gitLog as $branch => $details)
                    <div class="p-5 basis-1/2 max-w-[48%] box-border border border-gray-700 rounded-lg bg-gray-900 text-white shadow-md">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="text-red-300 font-bold">
                                Branch: <span class="text-yellow-300">{{ $branch }}</span>
                            </h2>
                            @if ($loop->first)
                                <span class="bg-green-700 text-white text-sm font-semibold px-3 py-1 rounded">NEWEST</span>
                            @endif
                        </div>

                        @if (is_array($details) && isset($details['message']))
                            <ul class="text-blue-200 text-sm leading-relaxed">
                                <li><strong>Name:</strong> {{ $details['name'] }}</li>
                                <li><strong>Email:</strong> {{ $details['email'] }}</li>
                                <li><strong>Date:</strong> {{ $details['date'] }}</li>
                                <li><strong>Commit Message:</strong> {{ $details['message'] }}</li>
                            </ul>

                            @if (!empty($details['files']))
                                <div class="mt-4">
                                    <h3 class="text-green-400 font-semibold mb-2 text-sm">Changed Files:</h3>
                                    <ul class="space-y-2 text-sm">
                                        @foreach ($details['files'] as $file)
                                            <li class="bg-gray-800 p-3 rounded flex justify-between items-center">
                                                <div class="flex flex-col flex-1 mr-4">
                                                    <span class="text-blue-100 break-all">{{ $file['file'] }}</span>
                                                    <form action="{{ route('downloadChangedFile') }}" method="POST" class="mt-1">
                                                        @csrf
                                                        <input type="hidden" name="repo_path" value="{{ $repoPath }}">
                                                        <input type="hidden" name="branch" value="{{ $branch }}">
                                                        <input type="hidden" name="file" value="{{ $file['file'] }}">
                                                        <button type="submit" class="bg-cyan-500 text-white px-2 py-1 text-xs rounded hover:bg-indigo-700">
                                                            Download
                                                        </button>
                                                    </form>
                                                </div>
                                                @php
                                                    $statusColor = match($file['status']) {
                                                        'A' => 'bg-green-700',
                                                        'M' => 'bg-yellow-500 text-black',
                                                        'D' => 'bg-red-600',
                                                        default => 'bg-gray-500',
                                                    };
                                                @endphp
                                                <span class="px-2 py-1 text-xs rounded font-bold {{ $statusColor }}">
                                                    {{ $file['status'] }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p class="text-gray-400 mt-2 text-sm italic">No file changes recorded.</p>
                            @endif
                        @else
                            <p class="text-red-500 text-sm">No log details available for this branch.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-300 mt-5">No commits found in this repository.</p>
        @endif
    </div>
</x-layout>
