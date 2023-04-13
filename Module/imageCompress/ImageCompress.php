<?php 

namespace Module\imageCompress;
use Illuminate\Support\Str;
class ImageCompress{
    public function compress($fileName)
    {
        list($orig_width, $orig_height) = getimagesize($fileName);
       $extension = $fileName->getClientOriginalExtension();
        // $spliiter = explode(".",$fileName);
        // foreach($spliiter as $s){
        //     $extension = $s;
        // }
        // $extension = strtolower($extension);
        $width = $orig_width;
        $height = $orig_height;
        $max_width = 300;
        $max_height = 300;

        # taller
        if ($height > $max_height) {
            $width = ($max_height / $height) * $width;
            $height = $max_height;
        }

        # wider
        if ($width > $max_width) {
            $height = ($max_width / $width) * $height;
            $width = $max_width;
        }

        if ($extension == 'png') {
            $image_p = imagecreatetruecolor($width, $height);

            $image = imagecreatefrompng($fileName);

            imagecopyresampled(
                $image_p,
                $image,
                0,
                0,
                0,
                0,
                $width,
                $height,
                $orig_width,
                $orig_height
            );

            return $image_p;
        } elseif ($extension == 'jpg' || $extension == 'jpeg') {
            $image_p = imagecreatetruecolor($width, $height);

            $image = imagecreatefromjpeg($fileName);

            imagecopyresampled(
                $image_p,
                $image,
                0,
                0,
                0,
                0,
                $width,
                $height,
                $orig_width,
                $orig_height
            );

            return $image_p;
        } else {
            return false;
        }
    }

    public function store($imagePath, $imageCreateFromSomething)
    {
        if(!$imageCreateFromSomething) 
            {
                return "noimage";
            }
        $fileName=Str::random(20);
        $path = "$imagePath".$fileName.".jpg";
        $pathData = public_path($path);
        imagepng($imageCreateFromSomething,$pathData);
        imagedestroy($imageCreateFromSomething);
        return "public/$imagePath$fileName.jpg";
    }

    public function getImage($image)
    {
        if(!is_string($image))
        foreach ($image as $key => $value) {
            $dataTransform[] = [
                base64_encode(url($value))
            ];
        }else {
            $dataTransform = base64_encode(url($image));
        }
        return $dataTransform;
    }
}