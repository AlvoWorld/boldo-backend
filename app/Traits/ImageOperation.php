<?php
/**
 * Created by PhpStorm.
 * User: bai
 * Date: 6/7/2019
 * Time: 12:10 AM
 */

namespace App\Traits;
trait ImageOperation
{
    public function uploadImage($image_object,$directory=null,$prefix=null){
        $file_name=null;
        if ($image_object){
            $file=$image_object;
            try{
                $file_name = $prefix.microtime().'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
                if(!is_null($directory))
                    \Image::make($image_object)->save(public_path("uploads/$directory/").$file_name);
                else
                    \Image::make($image_object)->save(public_path("uploads/").$file_name);
            }catch(\Exception $e){
                $file_name='default.png';
            }
        }
        return $file_name;
    }

    public function getImage($key,$directory=null){
        $image=null;
        if (!is_null($key)){
            if (is_null($directory))
                $image=url("/uploads/$key");
            else
                $image=url("/uploads/$directory/$key");
        }
        return $image;

    }
}