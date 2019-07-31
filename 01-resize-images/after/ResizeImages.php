<?php


class ResizeImages
{

    private $filePath;

    private $resizeWeight;

    private $resizeHeight;

    private $resizeFilePath;



    public function setFilePath($path) {
        $this->filePath = $path;
        return $this;
    }

    public function setResizeWeight($weight) {
        $this->resizeWeight = $weight;
        return $this;
    }

    public function setResizeHeight($height) {
        $this->resizeHeight = $height;
        return $this;
    }

    public function setResizeFilePath($path) {
        $this->resizeFilePath = $path;
        return $this;
    }


    public function resize() {
        $sourceWeight = imagesx($this->filePath);
        $sourceHeight = imagesy($this->filePath);

        $dst_image = imagecreatetruecolor($this->resizeWeight,$this->resizeHeight);

        imagecopyresized($dst_image,0,0,0,0,$this->resizeWeight,$this->resizeHeight,$sourceWeight,$sourceHeight);


        $res = imagejpeg($dst_image,$this->resizeFilePath);

        if(!$res) {
            throw new Exception("resize images error");
        }
    }

}