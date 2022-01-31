<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'users_avatars' => [
            'driver' => 'local',
            'root' => public_path('/img/users_avatars'),
            'url' => env('APP_URL').'/public',
            'visibility' => 'public',
        ],

        'clinics_logos' => [
            'driver' => 'local',
            'root' => public_path('/img/clinics_logos'),
            'url' => env('APP_URL').'/public',
            'visibility' => 'public',
        ],

        'casos_files' => [
            'driver' => 'local',
            'root' => public_path('/img/casos_files'),
            'url' => env('APP_URL').'/public',
            'visibility' => 'public',
        ],

        'seguimiento_casos_files' => [
            'driver' => 'local',
            'root' => public_path('/img/seguimiento_casos_files'),
            'url' => env('APP_URL').'/public',
            'visibility' => 'public',
        ],

        'chat_images' => [
            'driver' => 'local',
            'root' => public_path('/img/chat_images'),
            'url' => env('APP_URL').'/public',
            'visibility' => 'public',
        ],

        'patient_pictures' => [
            'driver' => 'local',
            'root' => public_path('/img/patient_pictures'),
            'url' => env('APP_URL').'/public',
            'visibility' => 'public',
        ],

        'valoraciones' => [
            'driver' => 'local',
            'root' => public_path('/img/valoraciones'),
            'url' => env('APP_URL').'/public',
            'visibility' => 'public',
        ],

        'municipalities' => [
            'driver' => 'local',
            'root' => storage_path('app/municipalities'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'rrhh_orgchart' => [
            'driver' => 'local',
            'root' => storage_path('app/rrhh_orgchart'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

];
