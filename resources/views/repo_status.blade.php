<x-layout>
    <div class="container">
        @php
            $lastSegment = \Illuminate\Support\Str::afterLast($repoPath, '\\');
        @endphp

        <x-heading>
            Repository Status For:
            <span class="text-cyan-300 font-semibold">{{ $lastSegment }}</span>
        </x-heading>

        @if (session('error'))
            <p class="error">{{ session('error') }}</p>
        @elseif (!empty($gitLog))
            <div class="flex flex-wrap gap-4 mt-6">
                @foreach($gitLog as $branch => $commits)
                    <div class="p-5 basis-1/2 max-w-[48%] border border-gray-700 rounded-lg bg-gray-900 text-white shadow-md">
                        <h2 class="text-red-300 font-bold mb-2">
                            Branch: <span class="text-yellow-300">{{ $branch }}</span>
                        </h2>

                        @foreach ($commits as $commit)
                            <div class="mb-4 bg-gray-800 p-4 rounded">
                                <ul class="text-blue-200 text-sm leading-relaxed">
                                    <li><strong>Name:</strong> {{ $commit['name'] }}</li>
                                    <li><strong>Email:</strong> {{ $commit['email'] }}</li>
                                    <li><strong>Date:</strong> {{ $commit['date'] }}</li>
                                    <li><strong>Commit Message:</strong> {{ $commit['message'] }}</li>
                                </ul>

                                @if (!empty($commit['files']))
                                    <form action="{{ route('downloadFilesZip') }}" method="POST" class="mt-4 commit-form">
                                        @csrf
                                        <input type="hidden" name="repo_path" value="{{ $repoPath }}">
                                        <input type="hidden" name="branch" value="{{ $branch }}">

                                        <h3 class="text-green-400 font-semibold mb-2 text-sm flex justify-between items-center">
                                            Select files to bundle:
                                            <button type="button" class="text-xs text-cyan-400 underline hover:text-white select-toggle">
                                                Select All
                                            </button>
                                        </h3>

                                        <ul class="space-y-2 text-sm">
                                            @foreach ($commit['files'] as $file)
                                                <li class="bg-gray-700 p-3 rounded flex justify-between items-center">
                                                    <label class="flex items-center space-x-2 flex-1">
                                                        <input type="checkbox" name="files[]" value="{{ $file['file'] }}" class="form-checkbox text-blue-500">
                                                        <span class="text-blue-100 break-all">{{ $file['file'] }}</span>
                                                    </label>
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

                                        <button type="submit" class="mt-3 bg-green-600 text-white px-4 py-2 text-sm rounded hover:bg-green-800">
                                            Download Selected Files as ZIP
                                        </button>
                                    </form>
                                @else
                                    <p class="text-gray-400 mt-2 text-sm italic">No file changes recorded.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-300 mt-5">No commits found in this repository.</p>
        @endif
    </div>

    <script>
        // Select All Toggle Logic
        document.querySelectorAll('.select-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const form = button.closest('.commit-form');
                const boxes = form.querySelectorAll('input[type="checkbox"][name="files[]"]');
                const allChecked = Array.from(boxes).every(cb => cb.checked);

                boxes.forEach(cb => cb.checked = !allChecked);
                button.textContent = allChecked ? 'Select All' : 'Unselect All';
            });
        });
    </script>
</x-layout>
