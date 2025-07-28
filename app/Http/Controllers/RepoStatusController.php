<?php

namespace App\Http\Controllers;

use App\Services\GitServices;
use DirectoryIterator;
use Illuminate\Http\RedirectResponse;
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

    public function checkRepoStatus(Request $request):View|RedirectResponse
    {
        return  GitServices::CheckPaths($request);
    }
    public function downloadChangedFile(Request $request): RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response
    {
        return GitServices::DownloadFileFromBranch($request);
    }


}
