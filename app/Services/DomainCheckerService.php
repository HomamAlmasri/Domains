<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;

class DomainCheckerService{
public function checkDomains($domains)
{
    $results = [];

    foreach($domains as $entry)
    {

        $domain = $entry['url'];
        $name = $entry['name'];

        try {
            $response = Http::get($domain);
            if ($response->successful()) {
                $results[] = [
                    'domain' => $domain,
                    'name' => $name,
                    'status' => 'up',
                    'code' => 200
                ];
            } else {
                $results[] = [
                    'domain' => $domain,
                    'name' => $name,
                    'status' => 'down',
                    'code' => $response->status(),
                    'error_message' => "Error" . $response->serverError() // Optional: show the actual response body for details
                ];
            }
        } catch (\Exception $e) {
            $results[] = [
                'domain' => $domain,
                'name' => $name,
                'status' => 'error',
                'code' => 'Error',
                'error_message' => $e->getMessage()
            ];
        }
    }
    $t=usort($results, function ($a, $b) {
        $statusOrder = ['error' => 0, 'down' => 1, 'up' => 2];
        return $statusOrder[$a['status']] <=> $statusOrder[$b['status']];
    });
        return $results;
}
}
