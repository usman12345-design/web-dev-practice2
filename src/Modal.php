<?php
namespace App;

abstract class Modal
{
    protected database $db;
    public function __construct()
    {
        $this->db = myApp::DB();

    }

}