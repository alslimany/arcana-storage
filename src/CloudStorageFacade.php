<?php

namespace Arcana\CloudStorage;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Arcana\CloudStorage\Skeleton\SkeletonClass
 */
class CloudStorageFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cloud-storage';
    }

    public static function upload($file)
    {
        $client = new Client();

        $path = $file->getRealPath();
        $content = file_get_contents($path);
        // $name = $file->getClientOriginalName();

        $response = $client->request(
            'POST',
            config('config.url'),
            [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => $content,
                        'filename' => 'image.jpg',
                        // 'headers'  => [
                        //     'X-Foo' => 'this is an extra header to include'
                        // ]
                    ],
                ],
            ]
        );

        return $response;
    }
}
