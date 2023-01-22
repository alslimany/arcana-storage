<?php

namespace Arcana\CloudStorage;

use GuzzleHttp\Client;

class CloudStorage
{
    public static function upload($images)
    {
        $files_to_upload = [];

        $index = 0;

        foreach ($images as $image) {
            $files_to_upload[] = [
                "name"      => "file[$index]",
                "contents"  => $image,
                "filename"  => "image_{$index}.jpg",
            ];

            $index++;
        }

        $client = new Client();

        $response = $client->request(
            'POST',
            // config('config.url') . '/file',
            // config('url') . 'api/file',
            'http://archive.arcana.ly/api/file',
            [
                'form_params' => [
                'files' => $files_to_upload,
                ],
                ]
        );

        $body = json_decode($response->getBody()->getContents());

        return response()->json(
            [
            'status'        => $response->getStatusCode(),
            'content-type'  => $response->getHeader('content-type')[0],
            'files'          => $body->uploads,
            ],
            $response->getStatusCode()
        );
    }

    public static function url($uuid)
    {
        $client = new Client();

        // $response = $client->request('get', 'http://arcana-archive-tenancy.test/api/get-file', [ 'query' => ['uuid' => $uuid]]);
        $response = $client->request('get', config('url') . 'api/file/' . $uuid);

        $body = json_decode($response->getBody()->getContents());

        return $body;
    }
}
