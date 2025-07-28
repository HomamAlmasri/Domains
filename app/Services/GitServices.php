<?php

namespace App\Services;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

Class GitServices{

    public static function CheckPaths(Request $request){

        $repoPath = $request->input('repo_path');

        $ip = explode('\\', $repoPath);
        if ($ip[2] != '192.168.2.37') {
            return back()->with('error', 'The path must start with 192.168.2.11 or studio-pc as the third segment.');
        }

        if (!is_dir($repoPath)) {
            return back()->with('error', "Repository path not found: {$repoPath}");
        }

        try {
            // Step 1: Get all branches
            $branchProcess = new Process([
                'C:\\Program Files\\Git\\bin\\git.exe',
                '--git-dir=' . $repoPath,
                'branch',
            ]);
            $branchProcess->run();

            if (!$branchProcess->isSuccessful()) {
                throw new ProcessFailedException($branchProcess);
            }

            $branches = explode("\n", trim($branchProcess->getOutput()));
            $branches = array_map(function ($branch) {
                return trim(ltrim($branch, '* '));
            }, $branches);

            if ($branches[0] == '') {
                return back()->with('error', \Illuminate\Support\Str::afterLast($repoPath, '\\') . ' الرجاء الرفع , لم يتم الرفع من قبل الى ');
            }

            $results = [];

            // Step 2: Fetch latest commit and changed files per branch
            foreach ($branches as $branch) {
                $logProcess = new Process([
                    'C:\\Program Files\\Git\\bin\\git.exe',
                    '--git-dir=' . $repoPath,
                    '--no-pager',
                    'log',
                    '--pretty=format:%an/(%ae)/%ad/%s',
                    '--date=format-local:%Y-%m-%d %H:%M:%S',
                    '-n', '1',
                    '--name-status',
                    $branch,
                ]);

                $logProcess->run();

                if (!$logProcess->isSuccessful()) {
                    throw new ProcessFailedException($logProcess);
                }

                $logLines = explode("\n", trim($logProcess->getOutput()));
                $commitMeta = array_shift($logLines);
                $exploded = explode("/", $commitMeta);
//                dd($logLines,$commitMeta,$exploded);
//                dd($exploded);

                $name = $exploded[0] ?? 'Unknown';
                $email = $exploded[1] ?? 'Unknown';
                $date = $exploded[2] ?? 'Unknown';
                $message = $exploded[3] ?? 'No message';
                $timestamp = strtotime($date) ?: null;

                $fileChanges = [];

                foreach ($logLines as $line) {
                    if (trim($line) === '') continue;
                    $parts = preg_split('/\s+/', trim($line), 2);
                    if (count($parts) === 2) {
                        $fileChanges[] = [
                            'status' => $parts[0],
                            'file' => $parts[1],
                        ];
//                        dd($fileChanges);
                    }
                }

                if ($timestamp !== null) {
                    $results[$branch] = [
                        'name' => $name,
                        'email' => $email,
                        'date' => $date,
                        'message' => $message,
                        'timestamp' => $timestamp,
                        'files' => $fileChanges,
                    ];
                }
            }

            // Step 3: Sort by latest commit
            uasort($results, function ($a, $b) {
                return $b['timestamp'] <=> $a['timestamp'];
            });

            return view('repo_status', [
                'repoPath' => $repoPath,
                'gitLog' => $results,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', "Error retrieving repository data: " . $e->getMessage());
        }
    }

}
