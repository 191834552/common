<?php

// 阿里云oss上传
$router->group(['prefix' => 'oss'],function ($router) {
    // 获得上传sts
    $router->post('signature', 'OssUploadController@signature');
    // 阿里云上传回调
    $router->post('callback', 'OssUploadController@callbackVerify');
});
