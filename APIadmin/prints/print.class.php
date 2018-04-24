<?php
require_once(__DIR__ . '/../Engine.class.php');

/**
 * oggetto stampa
 */
class PBPrint{
    public $ID;
    public $printDate;
    public $batch;
    public $printCode;
    public $orderCode;
    public $pbCode;
    public $title;
    public $dimensions;
    public $material;
    public $stock;
    public $sold;
    public $saleDate;
    public $recipient;

    function __construct($p = null)
    {
        $this->ID = isset($p->ID) ? (int)$p->ID : null;
        $this->printDate = isset($p->printDate) ? (new DateParser())->mysqlToTimestampJS($p->printDate) : null;
        $this->batch = isset($p->batch) ?  $p->batch : null;
        $this->printCode = isset($p->printCode) ? $p->printCode : null;
        $this->orderCode = isset($p->orderCode) ? $p->orderCode : null;
        $this->pbCode = isset($p->pbCode) ? $p->pbCode : null;
        $this->title = isset($p->title) ? $p->title : null;
        $this->dimensions = isset($p->dimensions) ? $p->dimensions : null;
        $this->material = isset($p->material) ? $p->material : null;
        $this->stock =  isset($p->stock) ? (bool)$p->stock : null ;
        $this->sold =  isset($p->sold) ? (bool)$p->sold : null ;
        $this->saleDate = isset($p->saleDate) ? (new DateParser())->mysqlToTimestampJS($p->saleDate) : null;
        $this->recipient = isset($p->recipient) ? $p->recipient : null;
    }


    public function parseforDB($p){
        $str = new StringTool();
        $dp = new DateParser();

        $this->ID = $p->ID ? (int)$p->ID : 'null';
        $this->printDate = $p->printDate ? $str->sqly($dp->timestampToMysql($p->printDate)) : 'null';
        $this->batch = $p->batch ? $str->sqly($p->batch) : 'null';
        $this->printCode = $p->printCode ? $str->sqly($p->printCode) : 'null';
        $this->orderCode = $p->orderCode ? $str->sqly($p->orderCode) : 'null';
        $this->pbCode = $p->pbCode ? $str->sqly($p->pbCode) : 'null';
        $this->title = $p->title ? $str->sqly($p->title) : 'null';
        $this->dimensions = $p->dimensions ? $str->sqly($p->dimensions) : 'null';
        $this->material = $p->material ? $str->sqly($p->material) : 'null';
        $this->stock = isset($p->stock) ? (int)$p->stock : 'null';
        $this->sold =  isset($p->sold) ? (int)$p->sold : 'null';
        $this->saleDate = $p->saleDate ? $str->sqly($dp->timestampToMysql($p->saleDate)) : 'null';
        $this->recipient = $p->recipient ? $str->sqly($p->recipient) : 'null';
    }
}

 ?>
