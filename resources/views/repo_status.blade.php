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
            @php
                $sortedBranches = collect($gitLog)->sortByDesc(function ($commits) {
                    return optional($commits[0])['date'];
                });
            @endphp
            <div class="space-y-6 mt-6">
                @foreach($sortedBranches  as $branch => $commits)
                    <div class="border border-gray-700 rounded-lg bg-gray-900 text-white shadow">
                        <button
                            type="button"
                            class="w-full text-left px-5 py-4 flex justify-between items-center bg-gray-800 hover:bg-gray-700 transition"
                            data-toggle="#branch-{{ \Illuminate\Support\Str::slug($branch) }}"
                        >
                            <span class="text-lg font-semibold text-yellow-300">Branch: {{ $branch }}</span>
                            <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div id="branch-{{ \Illuminate\Support\Str::slug($branch) }}" class="hidden px-5 py-4 border-t border-gray-700 bg-gray-900">
                            @foreach ($commits as $commit)
                                <div class="mb-6 bg-gray-800 p-4 rounded">
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
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-300 mt-5">No commits found in this repository.</p>
        @endif
    </div>

    <script>
        // Toggle branch accordion
        document.querySelectorAll('[data-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.querySelector(button.dataset.toggle);
                const icon = button.querySelector('svg');

                if (target.classList.contains('hidden')) {
                    target.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                } else {
                    target.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                }
            });
        });

        // Select/Unselect All checkboxes
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
