<?php

require_once 'FileUpload.php';
require_once 'ResizeImages.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    try {
        //進行檔案上傳
        $dir = "upload/";

        $fileUpload = new FileUpload();
        $resizeImage = new ResizeImages();

        $filePath = $fileUpload->setFileUploadPath($dir)
            ->setFileName(date('Y-m-d'))
            ->setAllowMineType('image/jpeg')
            ->uploadFile();

        if($_POST['resize'] == 1){
            $usr_weight = (!empty($_POST['weight']))?intval($_POST['weight']) : null;
            $usr_heiget = (!empty($_POST['height']))?intval($_POST['height']) : null;

            $resizeImage->setResizeFilePath($filePath)
                ->setResizeFilePath($dir . DIRECTORY_SEPARATOR . 'webimg.jpg')
                ->setResizeWeight($usr_weight)
                ->setResizeHeight($usr_weight)
                ->resize();
        }

        if (file_exists($dir . DIRECTORY_SEPARATOR . 'webimg.jpg')) {
            copy($filePath,$dir . DIRECTORY_SEPARATOR . 'webimg.jpg');
        }

        if (!empty($tmp_path) && file_exists($tmp_path)) {
            unlink($tmp_Path);
        }

        header("location:imgupload.php?success");
    }catch (Exception $e) {
        if (!empty($tmp_path) && file_exists($tmp_path)) {
            unlink($tmp_Path);
        }
        header("location:imgupload.php?failed");
    }

}