<?php


class FileUpload
{

    /**
     * @var 檔案上傳路徑
     */
    private $uploadPath;

    /**
     * @var 檔案取名
     */
    private $fileName;

    /**
     * @var Client 端的檔案來源 array
     */
    private $clientFileSource;

    public function setFileUploadPath($path) {
        if (!is_dir($path)) {
            mkdir($path,0777);
        }
        $this->uploadPath = $path;
        return $this;
    }


    public function setFileName($fileName) {
        $this->fileName = $fileName;
        return $this;
    }

    public function setClientFileSource($source) {
        $this->clientFileSource = $source;
        return $this;
    }

    /**
     * 圖片檔案上傳
     * @return bool|string
     * @throws Exception
     */
    public function uploadImage() {
        $type = explode("/",$this->clientFileSource['type']);
        if(strtolower($type[0]) != "images") {
            throw new Exception("上傳的檔案不是圖片");
        }
        $uploadFilePath = $this->upload();
        if($uploadFilePath !== false) {
            return $uploadFilePath;
        }
        throw new Exception("無法取得檔案上傳路徑");
    }

    /**
     * 上傳檔案
     * @return bool|string
     * @throws Exception
     */
    public function uploadFile() {
        $uploadFilePath = $this->upload();
        if($uploadFilePath !== false) {
            return $uploadFilePath;
        }
        throw new Exception("無法取得檔案上傳路徑");
    }


    private function upload() {
        $clientFileExt =  pathinfo($this->clientFileSource['name'],PATHINFO_EXTENSION);
        $renameFileName = (!empty($this->fileName)) ? $this->fileName .".". $clientFileExt : uniqid(15).".".$clientFileExt;
        $result = move_uploaded_file($this->clientFileSource['tmp_name'],$this->uploadPath . DIRECTORY_SEPARATOR . $renameFileName);
        if ($result) {
            return $this->uploadPath . DIRECTORY_SEPARATOR . $renameFileName;
        }
        return false;
    }
}