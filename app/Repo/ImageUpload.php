<?php
namespace App\Repo;
trait ImageUpload
{
    public function imageUpload($image, $path)
    {

        $image_name = rand(1000,999999);
        $ext = strtolower($image->getClientOriginalName());
        $image_full_name = $image_name.'.'.$ext;
        $upload_path = '/uploads/'.$path.'/';
        $image_url = $upload_path.$image_full_name;
        $success = $image->move(public_path().$upload_path,$image_full_name);
        return $image_url;

    }

    
}
