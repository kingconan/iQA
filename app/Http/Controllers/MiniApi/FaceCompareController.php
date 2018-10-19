<?php

namespace App\Http\Controllers\MiniApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

require_once  __DIR__.'/../Lib3/QQCloud/index.php';

use QcloudImage\CIClient;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;

class FaceCompareController extends Controller
{
    //

    public function getQUploadToken(Request $request){
        $ak = env('QI_AK');
        $sk = env('QI_CK');
        $auth = new Auth($ak, $sk);
        $policy =
        array(
            'scope' => 'info',
            'deadline' => 3600,
            'returnBody' => '{"w": $(imageInfo.width),"h": $(imageInfo.height),"key": $(etag)}');

        $token = $auth->uploadToken('info', null, 3600, $policy);

        return response()->json([
            'ok' => 0,
            'msg' => 'ok',
            'obj' => $token
        ]);
    }
    public function compareFace(Request $request){
        $father = $request->input('father');
        $mother = $request->input('mother');
        $me = $request->input('me');
        $key = $request->input('key');

        if(empty($father) || empty($mother) || empty($me)){
            return response()->json([
                'ok' => 1,
                'msg' => '找不到图片啊',
                'obj' => null
            ]);
        }
//        if($key != 'mini'){
//            return response()->json([
//                'ok' => 4,
//                'msg' => '验证失败啊',
//                'obj' => null
//            ]);
//        }
        $appId = env('QQ_APPID');
        $key = env('QQ_KEY');
        $secret = env('QQ_SECRET');

        $client = new CIClient($appId, $key, $secret, 'BUCKET');
        $client->setTimeout(30);
        $res1 = $client->faceCompare(
            array('url'=>$father),
            array('url'=>$me));

        $json1 = json_decode($res1);

        $res2 = $client->faceCompare(
            array('url'=>$mother),
            array('url'=>$me));

        $json2 = json_decode($res2);

        $res3 = $client->faceCompare(
            array('url'=>$father),
            array('url'=>$mother));

        $json3 = json_decode($res3);

        $faceFather = $this->getResult($client->faceDetect(array('url'=>$father), 1)) ;
        $faceMother =  $this->getResult($client->faceDetect(array('url'=>$mother), 1));
        $faceMe =  $this->getResult($client->faceDetect(array('url'=>$me), 1));


        if($json1->http_code == 200 && $json1->code == 0 &&
            $json2->http_code == 200 && $json2->code == 0 &&
            $json3->http_code == 200 && $json3->code == 0
        ){
            return response()->json([
                'ok' => 0,
                'msg' => '来了',
                'obj' => [
                    'similarity' => [
                        $json1->data->similarity,
                        $json2->data->similarity,
                        $json3->data->similarity,
                    ],
                    'position' => [
                        $faceFather,
                        $faceMother,
                        $faceMe
                    ]

                ]
            ]);
        }
        return response()->json([
            'ok' => 2,
            'msg' => '无法分析啊',
            'obj' => null
        ]);

    }

    private function getResult($res){
        $json = \Qiniu\json_decode($res);
        if($json->http_code == 200 && $json->code == 0){
            return $json->data;
        }
        return null;
    }
}
