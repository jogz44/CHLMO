<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
        ],

        // newly created one
        'awardee-photo-requirements' => [
            'driver' => 'local',
            'root' => storage_path('app/awardee-photo-requirements'),
            'serve' => true,
            'throw' => false,
            'url' => env('APP_URL').'/awardee-photo-requirements',
            'visibility' => 'public',
        ],
        // newly created one
//        'tagging-house-structure-images' => [
//            'driver' => 'local',
//            'root' => storage_path('app/tagging-house-structure-images'),
//            'serve' => true,
//            'throw' => false,
//            'url' => env('APP_URL').'/tagging-house-structure-images',
//            'visibility' => 'public',
//        ],
        'livewire-tmp' => [
            'driver' => 'local',
            'root' => storage_path('app/livewire-tmp'),
        ],
        'tagging-house-structure-images' => [
            'driver' => 'local',
            'root' => storage_path('app/public/tagging-house-structure-images'),
            'url' => env('APP_URL').'/storage/tagging-house-structure-images',
            'visibility' => 'public',
        ],
        // newly created one
        'transfer-photo-requirements' => [
            'driver' => 'local',
            'root' => storage_path('app/transfer-photo-requirements'),
            'serve' => true,
            'throw' => false,
            'url' => env('APP_URL').'/transfer-photo-requirements',
            'visibility' => 'public',
        ],
        'grantee-photo-requirements' => [
            'driver' => 'local',
            'root' => storage_path('app/grantee-photo-requirements'),
            'serve' => true,
            'throw' => false,
            'url' => env('APP_URL').'/grantee-photo-requirements',
            'visibility' => 'public',
        ],
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
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

    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('awardee-photo-requirements') => storage_path('app/awardee-photo-requirements'),
        public_path('tagging-house-structure-images') => storage_path('app/public/tagging-house-structure-images'), // Updated path
        public_path('transfer-photo-requirements') => storage_path('app/transfer-photo-requirements'),
        public_path('grantee-photo-requirements') => storage_path('app/grantee-photo-requirements'),
    ],
//    'links' => [
//            public_path('awardee-photo-requirements') => storage_path('app/awardee-photo-requirements'),
//        ],
    // after customizing, run php artisan storage:link
];
