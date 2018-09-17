<?php

namespace AppBundle\Helper;

/**
 * Uploader helper.
*/
class Uploader
{
    private $pictureFolder = "media";

    public function imageValidate($file, $required_aspect = null)
    {
        $error = null;
        if ($required_aspect){//require validate aspect !
            $uploadedfile = $file->getRealPath();
            list($width,$height)=getimagesize($uploadedfile);
            if ($width > $height){
                $picture_aspect_width = $width / $height;
                $picture_aspect_height = 1;
            }else{
                $picture_aspect_width = 1;
                $picture_aspect_height = $height / $width;
            }

            if (round($picture_aspect_width, 2) != round($required_aspect["width"], 2)){
                $error = "La relacion de Aspecto (ancho) requerida no se esta cumpliendo";
            }

            if (round($picture_aspect_height, 2) != round($required_aspect["height"], 2)){
                $error = "La relacion de Aspecto (alto) requerida no se esta cumpliendo";
            }
        }
        $extension = strtolower($file->getClientOriginalExtension());
        switch ($extension){
            case 'jpg':
                break;
            case 'jpeg':
                break;
            case 'png':
                break;
            case 'gif':
                break;
            default:
                $error = "Solo se permiten fotos con formato JPG, JPEG, PNG, GIF";
            }

        return $error;
    }

    public function imageUpload($file, $folder, $resize = null)
    {
        $uploadedfile = $file->getRealPath();
        $extension = strtolower($file->getClientOriginalExtension());
        switch ($extension){
            case 'jpg':
                $src = imagecreatefromjpeg($uploadedfile);
                $new_name = md5(uniqid().'_'.time()).'.jpg';
                break;
            case 'jpeg':
                $src = imagecreatefromjpeg($uploadedfile);
                $new_name = md5(uniqid().'_'.time()).'.jpeg';
                break;
            case 'png':
                $src = imagecreatefrompng($uploadedfile);
                $new_name = md5(uniqid().'_'.time()).'.png';
                break;
            case 'gif':
                $src = imagecreatefromgif($uploadedfile);

                $new_name = md5(uniqid().'_'.time()).'.gif';
                $filename = $this->imageFilename($folder, $new_name);
                copy($uploadedfile, $filename);
                return $new_name;

                break;
        }


        list($width,$height)=getimagesize($uploadedfile);
        if ($resize != null){
            if ($width > $height){
                $new_width = $resize["width"];
                $new_height = ($height / $width) * $resize["width"];
            }else{
                $new_height = $resize["height"];
                $new_width = ($width / $height) * $resize["height"];
            }
        }else{
            $new_width = $width;
            $new_height = $height;
        }
        $tmp = imagecreatetruecolor ($new_width, $new_height);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        if (!file_exists($this->pictureFolder."/".$folder)){
            mkdir($this->pictureFolder."/".$folder, 0777, true);
        }

        $filename = $this->imageFilename($folder, $new_name);

        imagejpeg($tmp, $filename);
        imagedestroy($tmp);

        return $new_name;
    }


    public function imageRemove($file, $folder) {
        $filename = $this->imageFilename($folder, $file);
        if (file_exists($filename)) {
            @unlink($filename);
        }
    }

    public function imageFilename($folder, $file) {
        return $this->pictureFolder.'/'.$folder.'/'.$file;
    }



}
