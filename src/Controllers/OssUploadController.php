<?php
/**
 * 阿里云oss上传
 */

namespace iBrand\Common\Controllers;

use Illuminate\Http\Request;

class OssUploadController extends Controller
{
    public function getPrefix($fileType,$prefix="")
    {
        return sprintf('%s/%s',$prefix,$fileType);
    }
    public function signature(Request $request)
    {
        /**
         * 1. 前缀如：'images/'
         * 2. 回调服务器 url
         * 3. 回调自定义参数，oss 回传应用服务器时会带上
         * 4. 当前直传配置链接有效期
         */
        $fileName = $request->fileName;
        $fileType = $request->fileType;
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $dir = $this->getPrefix($fileType,config('filesystems.disks.oss.root'));

        if ($request->dirFormat == 'date'){
            $dir.= '/'.date('Y-m-d');
        }

        $disk = \Storage::disk('oss');
        $config = $disk->signatureConfig(
            $prefix = $dir,
            $callBackUrl = '',
            $customData = ['uniqName' => md5(uniqid()) . '.' . $ext],
            $expire = 30, 1024 * 1024 * 1024 * 5);
        return $this->success(json_decode($config, 1));
    }

    public function callbackVerify($id)
    {
        $disk = \Storage::disk('oss');
        // 验签，就是如此简单
        // $verify 验签结果，$data 回调数据
        [$verify, $data] = $disk->verify();
        if (!$verify) {
            // 验证失败处理，此时 $data 为验签失败提示信息
            response()->json($data);
        }
        // 注意一定要返回 json 格式的字符串，因为 oss 服务器只接收 json 格式，否则给前端报 CallbackFailed
        $res = [
            'id' => $data['filename'],
            'name' => $data['uniqName'],
            'path' => $data['uniqName'],
            'status' => true,
            'url' => $disk->url($data['filename'])
        ];
        return response()->json($res);
    }

}
