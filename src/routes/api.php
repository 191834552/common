<?php

// 阿里云oss上传
$router->prefix('api/oss')->group(function () {
    // 获得上传sts
    Route::post('/signature', 'OssUploadController@signature');
    // 阿里云上传回调
    Route::post('/callback', 'OssUploadController@callbackVerify');
});

//});
