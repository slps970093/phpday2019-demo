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

    /**
     * @var  array | string
     */
    private $allowMineType;


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
     * 允許 Mine Type 可上傳
     * @param $mineType
     * @return $this
     */
    public function setAllowMineType($mineType) {
        $this->allowMineType = $mineType;
        return $this;
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
        $this->checkFileAllowUpload();
        $result = move_uploaded_file($this->clientFileSource['tmp_name'],$this->uploadPath . DIRECTORY_SEPARATOR . $renameFileName);
        if ($result) {
            return $this->uploadPath . DIRECTORY_SEPARATOR . $renameFileName;
        }
        return false;
    }

    private function checkFileAllowUpload() {
        if (empty($this->allowMineType)) {
            return "";
        }

        if (is_string($this->allowMineType)) {
            if ( $this->clientFileSource['type'] != $this->allowMineType) {
                throw new Exception('不允許的檔案型態');
            }
        }

        if (is_array($this->allowMineType)) {
            if (!in_array($this->clientFileSource['type'],$this->allowMineType)) {
                throw new Exception('不允許的檔案型態');
            }
        }

    }
}