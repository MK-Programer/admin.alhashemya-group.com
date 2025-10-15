<?php
namespace App\Classes;
use Illuminate\Support\Str;

class Image{

    static public function savePictureInStorage($picture, $imagePath){
        $uuid = Str::uuid();
        $pictureName = $uuid . '.' . $picture->getClientOriginalExtension();
        $picturePath = public_path($imagePath);
        $picture->move($picturePath, $pictureName);
        return $pictureName;
    }

    static public function unlinkPicture($picturePath){
        $picturePath = public_path($picturePath);
        if (file_exists($picturePath)) {
            unlink($picturePath);
        }
    }
}
?>