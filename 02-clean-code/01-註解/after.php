<?php


class RepairModel {

    /**
     * @var PDO
     */
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=pdo_example;charset=utf8', 'root', '12345678');
    }

    public function modifyRepairStatusByPrimaryKey($primaryKey,$status) {
        $this->checkDataNotSoftRemove($primaryKey);

        $sql = "UPDATE `device_repair` SET `status` = :status WHERE id = :id ";

        $query = $this->db->prepare($sql);

        $query->bindParam(':status', $status);
        $query->bindParam(':id',$primaryKey);

        $dbStatus = $query->execute();

        if (!$dbStatus) {
            throw new Exception('修改發生錯誤');
        }
    }


    private function checkDataNotSoftRemove($primaryKey) {
        // 取得設備報修
        $sql = "SELECT * FROM device_repair WHERE id = :id";

        $query = $this->db->prepare($sql);

        $query->bindParam(':id', $primaryKey);

        $res = $query->fetch();

        // 檢查是不是軟刪除資料
        if ( $res['soft_remove'] == 1) {
            throw new Exception("不可修改軟刪除資料");
        }
    }
}