<?php

return [
    "directory"=>'storage',
    'disks' => [
        'oss' => [
            'driver' => 'oss',
            'root' => '', // 设置上传时根前缀
            'access_key' => env('OSS_ACCESS_KEY'),
            'secret_key' => env('OSS_SECRET_KEY'),
            'endpoint'   => env('OSS_ENDPOINT'), // 使用 ssl 这里设置如: https://oss-cn-beijing.aliyuncs.com
            'bucket'     => env('OSS_BUCKET'),
            'isCName'    => env('OSS_IS_CNAME', false), // 如果 isCname 为 false，endpoint 应配置 oss 提供的域名如：`oss-cn-beijing.aliyuncs.com`，否则为自定义域名，，cname 或 cdn 请自行到阿里 oss 后台配置并绑定 bucket
            // 如果有更多的 bucket 需要切换，就添加所有bucket，默认的 bucket 填写到上面，不要加到 buckets 中
            'buckets'=>[
                'test'=>[
                    'access_key' => env('OSS_ACCESS_KEY'),
                    'secret_key' => env('OSS_SECRET_KEY'),
                    'bucket'     => env('OSS_TEST_BUCKET'),
                    'endpoint'   => env('OSS_TEST_ENDPOINT'),
                    'isCName'    => env('OSS_TEST_IS_CNAME', false),
                ],
            ],
        ],
    ]
];
