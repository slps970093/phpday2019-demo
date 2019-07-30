<?php


interface IRegister
{

    // 學生申請
    public function register($data);

    // 放棄入學
    public function quitRegister($registerId);
}