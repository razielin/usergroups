<?php
namespace App\Api;

class BaseApi
{
    const SERVER_URL = 'http://user_groups_api:80';
    protected function getServerResponse(string $url, $body = [])
    {
        $opts = array('http' =>
            array(
                'header'  => 'Content-Type: application/json',
                'content' => json_encode($body)
            )
        );
        $context  = stream_context_create($opts);

        $res = json_decode(file_get_contents($url, false, $context), true);
        if ($res['status'] !== 'ok') {
            $errorMessage = implode(',', $res['errors']) ?? 'Invalid API request';
            throw new \RuntimeException($errorMessage);
        }
        return $res['data'];
    }
}
