<?php


require_once "FileUpload.php";
require_once "ResizeImages.php";


$fileUpload = new FileUpload();
$resizeImage = new ResizeImages();

try {

    $filePath = $fileUpload->setClientFileSource($_FILES['imgfile'])
        ->setFileName(uniqid())
        ->setFileUploadPath('/img')
        ->uploadImage();

    $resizeImage->setFilePath($filePath)
        ->setResizeHeight($_POST['height'])
        ->setResizeWeight($_POST['weight'])
        ->setResizeFilePath("/resize/webimg.jpg")
        ->resize();

    if (file_exists($filePath)) {
        unlink($filePath);
    }

    header("location: imgupload.php?success");
} catch (Exception $e) {
    header("location: imgupload.php?errorMsg=".$e->getMessage(). "&failed");
}