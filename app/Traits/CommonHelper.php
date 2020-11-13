<?php
namespace App\Traits;
use Illuminate\Support\Facades\Log;

trait CommonHelper
{
    public function sendCurlRequest($url,$type='get',$data=[], $headers=['application/json']){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if($type=='post')
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if(count($headers)>0)
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result=curl_exec($ch);
        curl_close($ch);
        echo $result;
    }

}
