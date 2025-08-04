<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use ZipArchive;
use Illuminate\Support\Facades\File;

Class GitServices{

    public static function CheckPaths(Request $request)
    {
        $repoPath = $request->input('repo_path');

        $ip = explode('\\', $repoPath);
//        dd($ip);
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
            $branches = array_map(fn($branch) => trim(ltrim($branch, '* ')), $branches);

            if ($branches[0] == '') {
                return back()->with('error', \Illuminate\Support\Str::afterLast($repoPath, '\\') . ' الرجاء الرفع , لم يتم الرفع من قبل الى ');
            }

            $results = [];

            // Step 2: Parse commit logs per branch
            foreach ($branches as $branch) {
                $logProcess = new Process([
                    'C:\\Program Files\\Git\\bin\\git.exe',
                    '--git-dir=' . $repoPath,
                    '--no-pager',
                    'log',
                    '--pretty=format:|||%an|%ae|%ad|%s',
                    '--date=format-local:%Y-%m-%d %H:%M:%S',
                    '-n', '20',
                    '--name-status',
                    $branch,
                ]);
                $logProcess->run();

                if (!$logProcess->isSuccessful()) {
                    throw new ProcessFailedException($logProcess);
                }

                $lines = explode("\n", trim($logProcess->getOutput()));
                $results[$branch] = [];
                $currentIndex = -1;

                foreach ($lines as $line) {
                    if (Str::startsWith($line, '|||')) {
                        $parts = explode('|', substr($line, 3));
                        $results[$branch][] = [
                            'name' => $parts[0] ?? 'Unknown',
                            'email' => $parts[1] ?? 'Unknown',
                            'date' => $parts[2] ?? 'Unknown',
                            'message' => $parts[3] ?? 'No message',
                            'timestamp' => strtotime($parts[2] ?? '') ?: time(),
                            'files' => [],
                        ];
                        $currentIndex++;
                    } elseif ($currentIndex >= 0 && preg_match('/^(A|M|D)\s+(.+)/', $line, $matches)) {
                        $results[$branch][$currentIndex]['files'][] = [
                            'status' => $matches[1],
                            'file' => $matches[2],
                        ];
                    }
                }
            }

            return view('repo_status', [
                'repoPath' => $repoPath,
                'gitLog' => $results,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', "Error retrieving repository data: " . $e->getMessage());
        }
    }

    public static function DownloadFileFromBranch(Request $request)
    {
        $repoPath = $request->input('repo_path');
        $branch = $request->input('branch');
        $file = $request->input('file');

        try {
            $commitProcess = new Process([
                'C:\\Program Files\\Git\\bin\\git.exe',
                '--git-dir=' . $repoPath,
                'rev-parse',
                $branch,
            ]);
            $commitProcess->run();

            if (!$commitProcess->isSuccessful()) {
                throw new ProcessFailedException($commitProcess);
            }

            $commitHash = trim($commitProcess->getOutput());

            $showProcess = new Process([
                'C:\\Program Files\\Git\\bin\\git.exe',
                '--git-dir=' . $repoPath,
                'show',
                $commitHash . ':' . $file,
            ]);
            $showProcess->run();

            if (!$showProcess->isSuccessful()) {
                throw new ProcessFailedException($showProcess);
            }

            $fileContent = $showProcess->getOutput();
            $fileName = basename($file);

            return response($fileContent, 200)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', "attachment; filename=\"{$fileName}\"");
        } catch (\Exception $e) {
            return back()->with('error', "Download error: " . $e->getMessage());
        }
    }
    public static function downloadFilesAsZip(Request $request)
    {
        $repoPath = $request->input('repo_path');
        $branch = $request->input('branch');
        $files = $request->input('files');

        $folderName = 'selected_files_' . time();
        $folderPath = storage_path("app/temp/{$folderName}");
        File::ensureDirectoryExists($folderPath);

        foreach ($files as $filePath) {
            $process = new Process([
                'C:\\Program Files\\Git\\bin\\git.exe',
                '--git-dir=' . $repoPath,
                'show',
                "{$branch}:{$filePath}",
            ]);
            $process->run();

            if ($process->isSuccessful()) {
                $fileContent = $process->getOutput();
                $fullFilePath = $folderPath . '/' . $filePath;

                File::ensureDirectoryExists(dirname($fullFilePath));
                File::put($fullFilePath, $fileContent);
            }
        }

        $zipName = "{$folderName}.zip";
        $zipPath = storage_path("app/public/{$zipName}");
        $zip = new \ZipArchive;

        if ($zip->open($zipPath, \ZipArchive::CREATE)) {
            foreach (File::allFiles($folderPath) as $file) {
                $relativePath = str_replace($folderPath . '/', '', $file->getRealPath());
                $zip->addFile($file->getRealPath(), basename($file->getRealPath()));

            }
            $zip->close();
        }

        File::deleteDirectory($folderPath); // clean temp

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

}
