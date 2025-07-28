<?php

namespace App\Http\Controllers;

abstract class Controller
{

//    public function getPath():array
//    {
//        $paths = '\\\\192.168.2.37\share\ProgramRep\\';
//        $unwanted = ['joybox-mobile-server-framework','$RECYCLE.BIN', "found.000","task.zip" ,"found.001", "System Volume Information", 'bg-projects-manager', 'joybox-user-permission', 'sukker d','ai-kitchen','Win'];
//        //
//        $path = [];
//        $repoPath = [];
//        $items = scandir($paths, 0);
//        foreach ($items as $keys => $item)
//        {
//            if (in_array($item, $unwanted)) {// Match value, not variable name
//                unset($items[$keys]);
//            }
//        }
////dd($items);
//
//        $items = array_values($items); // Reindex the array
//        foreach ($items as $item) {
//            $paths = '\\\192.168.2.11\ProgramRep\\' . $item . '\4-Coding\\';
//            $paths = scandir($paths);
//            unset($paths[0], $paths[1]) ;
//            $path[$item] = $paths ;
//        }
////dd($path);
//        foreach ($path as $key => $repos) {
//            foreach ($repos as $repo) {
//                $repoPath[$repo] = '\\\192.168.2.11\ProgramRep\\' . $key . '\4-Coding\\' . $repo;
//            }
//        }
//        return $repoPath;
//    }

    public function getPath(): array
    {
        $sourceServerPath = '\\\\192.168.2.37\\ProgramRep\\'; // Discovery source
        $targetServerBase = '\\\\192.168.2.37\\ProgramRep\\';       // Repo location
        $unwanted = [
            'joybox-mobile-server-framework', '$RECYCLE.BIN', 'found.000', 'task.zip',
            'found.001', 'System Volume Information', 'bg-projects-manager',
            'joybox-user-permission', 'sukker d', 'ai-kitchen', 'Win'
        ];

        $path = [];
        $repoPath = [];

        // Step 1: Discover valid project folders from source server
        $items = scandir($sourceServerPath, SCANDIR_SORT_NONE);
        $items = array_filter($items, function ($item) use ($unwanted) {
            return !in_array($item, $unwanted) && !in_array($item, ['.', '..']);
        });

        // Step 2: Scan 4-Coding folders on target server
        foreach ($items as $projectFolder) {
            $projectCodingPath = $targetServerBase . $projectFolder . '\\4-Coding\\';

            if (!is_dir($projectCodingPath)) {
                continue; // Skip if 4-Coding folder doesn't exist
            }

            $repos = scandir($projectCodingPath, SCANDIR_SORT_NONE);
            $repos = array_filter($repos, fn($r) => !in_array($r, ['.', '..']));
            $path[$projectFolder] = $repos;

            foreach ($repos as $repoName) {
                $repoPath[$repoName] = $projectCodingPath . $repoName;
            }
        }

        return $repoPath;
    }
    protected array $pathss = [
        'aalamy-backend'              =>   '\\\192.168.2.37\ProgramRep\aalamy\4-Coding\aalamy-backend',
        'aalamy-dashboard'            =>   '\\\192.168.2.37\ProgramRep\aalamy\4-Coding\aalamy-dashboard',
        'aalamy-mobile'               =>   '\\\192.168.2.37\ProgramRep\aalamy\4-Coding\aalamy-mobile',
        'aalamy-web'                  =>   '\\\192.168.2.37\ProgramRep\aalamy\4-Coding\aalamy-web',
        'central-test-backend'        =>   '\\\192.168.2.37\ProgramRep\central-test\4-Coding\central-test-backend',
        'central-test-dashboard'      =>   '\\\192.168.2.37\ProgramRep\central-test\4-Coding\central-test-dashboard',
        'central-test-mobile'         =>   '\\\192.168.2.37\ProgramRep\central-test\4-Coding\central-test-mobile',
        'central-test-web'            =>   '\\\192.168.2.37\ProgramRep\central-test\4-Coding\central-test-web',
        'central-test-mobile-student'    =>   '\\\192.168.2.37\ProgramRep\central-test\4-Coding\central-test-mobile-student',
        'central-test-mobile-supervisor' =>   '\\\192.168.2.37\ProgramRep\central-test\4-Coding\central-test-mobile-supervisor',
        'classkit-backend' =>   '\\\192.168.2.37\ProgramRep\classkit\4-Coding\classkit-backend',
        'classkit-dashboard' =>   '\\\192.168.2.37\ProgramRep\classkit\4-Coding\classkit-dashboard',
        'classkit-mobile' =>   '\\\192.168.2.37\ProgramRep\classkit\4-Coding\classkit-mobile',
        'classkit-web' =>   '\\\192.168.2.37\ProgramRep\classkit\4-Coding\classkit-web',
        'drivergy-backend' =>   '\\\192.168.2.37\ProgramRep\drivergy\4-Coding\drivergy-backend',
        'drivergy-dashboard' =>   '\\\192.168.2.37\ProgramRep\drivergy\4-Coding\drivergy-dashboard',
        'drivergy-mobile' =>   '\\\192.168.2.37\ProgramRep\drivergy\4-Coding\drivergy-mobile',
        'drivergy-web' =>   '\\\192.168.2.37\ProgramRep\drivergy\4-Coding\drivergy-web',
        'happy-cappy-backend' =>   '\\\192.168.2.37\ProgramRep\happy-cappy\4-Coding\happy-cappy-backend',
        'happy-cappy-dashboard' =>   '\\\192.168.2.37\ProgramRep\happy-cappy\4-Coding\happy-cappy-dashboard',
        'happy-cappy-mobile' =>   '\\\192.168.2.37\ProgramRep\happy-cappy\4-Coding\happy-cappy-mobile',
        'happy-cappy-web' =>   '\\\192.168.2.37\ProgramRep\happy-cappy\4-Coding\happy-cappy-web',
        'sama-oman-backend' =>   '\\\192.168.2.37\ProgramRep\sama-oman\4-Coding\sama-oman-backend',
        'sama-oman-business-clinic' =>   '\\\192.168.2.37\ProgramRep\sama-oman\4-Coding\sama-oman-business-clinic',
        'sama-oman-dashboard' =>   '\\\192.168.2.37\ProgramRep\sama-oman\4-Coding\sama-oman-dashboard',
        'sama-oman-mobile' =>   '\\\192.168.2.37\ProgramRep\sama-oman\4-Coding\sama-oman-mobile',
        'sama-oman-web' =>   '\\\192.168.2.37\ProgramRep\sama-oman\4-Coding\sama-oman-web',
        'sama-oman-academy' =>   '\\\192.168.2.37\ProgramRep\sama-oman\4-Coding\sama-omar-academy',
        'sama-oman-investment-opportunities' =>   '\\\192.168.2.37\ProgramRep\sama-oman\4-Coding\sama-omar-investment-opportunities',
        'joybox-backend' =>   '\\\192.168.2.37\ProgramRep\joybox\4-Coding\joybox-backend',
        'joybox-dashboard' =>   '\\\192.168.2.37\ProgramRep\joybox\4-Coding\joybox-dashboard',
        'joybox-mobile' =>   '\\\192.168.2.37\ProgramRep\joybox\4-Coding\joybox-mobile',
        'joybox-web' =>   '\\\192.168.2.37\ProgramRep\joybox\4-Coding\joybox-web',
        'lamset-shefaa-backend' =>   '\\\192.168.2.37\ProgramRep\lamset-shefaa\4-Coding\lamset-shefaa-backend',
        'lamset-shefaa-dashboard' =>   '\\\192.168.2.37\ProgramRep\lamset-shefaa\4-Coding\lamset-shefaa-dashboard',
        'lamset-shefaa-mobile' =>   '\\\192.168.2.37\ProgramRep\lamset-shefaa\4-Coding\lamset-shefaa-mobile',
        'lamset-shefaa-web' =>   '\\\192.168.2.37\ProgramRep\lamset-shefaa\4-Coding\lamset-shefaa-web',
        'medicine-reader-backend' =>   '\\\192.168.2.37\ProgramRep\medicine-reader\4-Coding\medicine-reader-backend',
        'medicine-reader-dashboard' =>   '\\\192.168.2.37\ProgramRep\medicine-reader\4-Coding\medicine-reader-dashboard',
        'medicine-reader-mobile' =>   '\\\192.168.2.37\ProgramRep\medicine-reader\4-Coding\medicine-reader-mobile',
        'medicine-reader-web' =>   '\\\192.168.2.37\ProgramRep\medicine-reader\4-Coding\medicine-reader-web',
        'shefaa-pharmacist-backend' =>   '\\\192.168.2.37\ProgramRep\pos\9-sub-projects\shefaa-pharmacist\4-Coding\shefaa-pharmacist-backend',
        'shefaa-pharmacist-dashboard' =>   '\\\192.168.2.37\ProgramRep\pos\9-sub-projects\shefaa-pharmacist\4-Coding\shefaa-pharmacist-dashboard',
        'shefaa-pharmacist-local-server' =>   '\\\192.168.2.37\ProgramRep\pos\9-sub-projects\shefaa-pharmacist\4-Coding\shefaa-pharmacist-local-server',
        'shefaa-pharmacist-mobile' =>   '\\\192.168.2.37\ProgramRep\pos\9-sub-projects\shefaa-pharmacist\4-Coding\shefaa-pharmacist-mobile',
        'shefaa-pharmacist-web' =>   '\\\192.168.2.37\ProgramRep\pos\9-sub-projects\shefaa-pharmacist\4-Coding\shefaa-pharmacist-web',
        'shefaa-backend' =>   '\\\192.168.2.37\ProgramRep\shefaa\4-Coding\shefaa-backend',
        'shefaa-dashboard' =>   '\\\192.168.2.37\ProgramRep\shefaa\4-Coding\shefaa-dashboard',
        'shefaa-mobile' =>   '\\\192.168.2.37\ProgramRep\shefaa\4-Coding\shefaa-mobile',
        'shefaa-web' =>   '\\\192.168.2.37\ProgramRep\shefaa\4-Coding\shefaa-web',
        'shefaa-accounting-backend' =>   '\\\192.168.2.37\ProgramRep\shefaa-accounting\4-Coding\shefaa-accounting-backend',
        'shefaa-accounting-dashboard' =>   '\\\192.168.2.37\ProgramRep\shefaa-accounting\4-Coding\shefaa-accounting-dashboard',
        'shefaa-accounting-mobile' =>   '\\\192.168.2.37\ProgramRep\shefaa-accounting\4-Coding\shefaa-accounting-mobile',
        'shefaa-accounting-web' =>   '\\\192.168.2.37\ProgramRep\shefaa-accounting\4-Coding\shefaa-accounting-web',
        'zahi-backend' =>   '\\\192.168.2.37\ProgramRep\zahi\4-Coding\zahi-backend',
        'zahi-dashboard' =>   '\\\192.168.2.37\ProgramRep\zahi\4-Coding\zahi-dashboard',
        'zahi-mobile' =>   '\\\192.168.2.37\ProgramRep\zahi\4-Coding\zahi-mobile',
        'zahi-web' =>   '\\\192.168.2.37\ProgramRep\zahi\4-Coding\zahi-web',
    ];
}
