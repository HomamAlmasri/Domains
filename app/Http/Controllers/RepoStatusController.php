<?php

namespace App\Http\Controllers;

use App\Services\GitServices;
use DirectoryIterator;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class RepoStatusController extends Controller
{
    public function showInputForm(): View
    {
//        dd($this->getPath());
        return view('repo_input',['paths'=>$this->getPath()]);
    }

    public function checkRepoStatus(Request $request)
    {
        dd(GitServices::CheckPaths());
        return  GitServices::CheckPaths();
    }
}
//$repoPath = $request->input('repo_path');
//
//
//$ip = explode('\\', $repoPath);
//if ($ip[2] != '192.168.2.18' && $ip[2] != 'studio-pc') {
//    return back()->with('error', 'The path must start with 192.168.2.18 or studio-pc as the third segment.');
//}
//
//// Validate repository path
//if (!is_dir($repoPath)) {
//    return back()->with('error', "Repository path not found: {$repoPath}");
//}
//
//try {
//    // Step 1: Get all branches
//    $branchProcess = new Process([
//        'C:\\Program Files\\Git\\bin\\git.exe',
//        '--git-dir=' . $repoPath,
//        'branch',
//    ]);
//    $branchProcess->run();
//
//    if (!$branchProcess->isSuccessful()) {
//        throw new ProcessFailedException($branchProcess);
//    }
//    // Parse branches into an array
//    $branches = explode("\n", trim($branchProcess->getOutput()));
//    $branches = array_map(function ($branch) {
//        return trim(ltrim($branch, '* ')); // Remove the "*" for the current branch
//    }, $branches);
//
//    if($branches[0] == ''){
////                    dd(1);
//        return back()->with('error',  \Illuminate\Support\Str::afterLast($repoPath, '\\') . ' الرجاء الرفع , لم يتم الرفع من قبل الى '  );
//    }
//    $results = [];
//
//    // Step 2: Loop through branches and fetch the latest log
//    foreach ($branches as $branch) {
//        $logProcess = new Process([
//            'C:\\Program Files\\Git\\bin\\git.exe',
//            '--git-dir=' . $repoPath,
//            '--no-pager',
//            'log',
//            '--pretty=format:%an/(%ae)/%ad/%s', // Adjusted format to include only the commit message
//            '--date=format-local:%Y-%m-%d %H:%M:%S',
//            '-n', '1', // Fetch only the latest commit
//            $branch, // Specify the branch explicitly
//        ]);
//
//        $logProcess->run();
//
//        if (!$logProcess->isSuccessful()) {
//            throw new ProcessFailedException($logProcess);
//        }
//        // Parse the latest log output
//        $logEntry = trim($logProcess->getOutput());
//        // Remove merge details from commit message
//        $logEntry = preg_replace('/^Merge .*/', '', $logEntry);
//
//        $exploded = explode("/", $logEntry);
//        $name = isset($exploded[0]) ? $exploded[0] : 'Unknown'; // Extract name
//        $email = isset($exploded[1]) ? $exploded[1] : 'Unknown'; // Extract email
//        $date = isset($exploded[2]) ? $exploded[2] : 'Unknown'; // Extract date
//        $message = isset($exploded[3]) ? $exploded[3] : 'No message'; // Commit message
//
//        if ($date) {
//            $timestamp = strtotime($date); // Convert date to timestamp
//            if ($timestamp !== false) {
//                // Store log with timestamp for sorting
//                $results[$branch] = [
//                    'name' => $name,
//                    'email' => $email,
//                    'date' => $date,
//                    'message' => $message,
//                    'timestamp' => $timestamp,
//                ];
//            }
//        }
//    }
//
//    // Step 3: Sort branches by their latest commit timestamp
//    uasort($results, function ($a, $b) {
//        return $b['timestamp'] <=> $a['timestamp']; // Descending order by timestamp
//    });
//
//    // Return the sorted results to the view
//    return view('repo_status', [
//        'repoPath' => $repoPath,
//        'gitLog' => $results,
//    ]);
//} catch (\Exception $e) {
//    return back()->with('error', "Error retrieving repository data: " . $e->getMessage());
//}
