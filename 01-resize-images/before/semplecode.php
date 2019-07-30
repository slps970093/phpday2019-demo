<?php


if($_SERVER['REQUEST_METHOD']=='POST'){
    try {
        //進行檔案上傳
        $dir = "upload/";
        unlink($dir."webimg.jpg"); //刪除檔案
        //改檔案名
        $ext = pathinfo($_FILES['imgfile']['name'],PATHINFO_EXTENSION);
        $filename = pathinfo($_FILES['imgfile']['name'],PATHINFO_FILENAME);

        $tmp_path = $dir . date('Y-m-d') . ".jpg";

        if ($_FILES['imgfile']['type'] != 'image/jpeg') {
            throw new Exception('圖片不是 JPG');
        }

        $result = move_uploaded_file($_FILES['imgfile']['tmp_name'],$tmp_path);

        if (!$result) {
            throw new Exception('檔案上傳失敗');
        }
        if($_POST['resize'] == 1){
            //改檔案名
            $src = imagecreatefromjpeg($tmp_Path);
            //取圖片長寬
            $src_weight = imagesx($src);
            $src_height = imagesy($src);
            //套用自定義大小
            $usr_weight = (!empty($_POST['weight']))?intval($_POST['weight']) : null;
            $usr_heiget = (!empty($_POST['height']))?intval($_POST['height']) : null;
            $dst_image = imagecreatetruecolor($usr_weight, $usr_heiget);
            imagecopyresized($dst_image, $src, 0, 0, 0, 0, $usr_weight, $usr_heiget, $src_weight, $src_height);
            $result = imagejpeg($dst_image,$dir."webimg.jpg");
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