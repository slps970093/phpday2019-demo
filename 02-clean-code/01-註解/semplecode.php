<?php


function changeRepairStatusByPrimaryKey ($primaryKey, $status)
{
    $db = new PDO('mysql:host=localhost;dbname=pdo_example;charset=utf8', 'root', '12345678');

    // 取得設備報修
    $sql = "SELECT * FROM device_repair WHERE id = :id";

    $query = $db->prepare($sql);

    $query->bindParam(':id', $primaryKey);

    $res = $query->fetch();

    // 檢查是不是軟刪除資料
    if ( $res['soft_remove'] == 1) {
        throw new Exception("不可修改軟刪除資料");
    }

    // Enum 檢查
    $enum = [
        1 => '報修中',
        2 => '指派人員維修中',
        3 => '維修完畢',
        4 => '結單'
    ];

    if (!array_key_exists($primaryKey,$enum)) {
        throw new Exception('Enum Error');
    }

    // 修改狀態
    $sql = "UPDATE `device_repair` SET `status` = :status WHERE id = :id ";

    $query = $db->prepare($sql);

    $query->bindParam(':status', $status);

    $dbStatus = $query->execute();

    if (!$dbStatus) {
        throw new Exception('修改發生錯誤');
    }
}

