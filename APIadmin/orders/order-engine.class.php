<?php
require_once(__DIR__ . '/../Engine.class.php');
require_once(__DIR__ . '/../ServerResponse.class.php');



/**
 * operazioni di base
 */
class OrderEngine extends Engine
{


    public function __construct() {
		parent::__construct();
	}




    protected function getOrderFromDB($sql){
        $orders  = array();
        $data = $this->db->query($sql);
        while($row = $data->fetch_object()) {
            $item = json_decode($row->fingerprint);
            $item->OID = $row->OID;
            // $item->orderCode = $row->orderCode;
            $orders[] = $item;
        }
        return $orders;
    }



    protected function updateQuery($orderItem){
        $oi = $this->parseForDb($orderItem);

$sql = <<<SQL
        UPDATE orders  SET
        orderCode = '$oi->orderCode',
        uid = '$oi->uid',
        pbCode = '$oi->pbCode',
        fingerprint = '$oi->fingerprint',
        quantity = $oi->quantity,
        opened = $oi->opened,
        payed = $oi->payed,
        confirmed = $oi->confirmed,
        worked = $oi->worked,
        shipped = $oi->shipped,
        invoiced = $oi->invoiced,
        accepted = $oi->accepted,
        rejected = $oi->rejected,
        returned = $oi->returned,
        refounded = $oi->refounded,
        closed = $oi->closed,
        creationDate = $oi->creationDate,
        paymentDate = $oi->paymentDate,
        shippingDate = $oi->shippingDate,
        deliveringDate = $oi->deliveringDate,
        closingDate = $oi->closingDate
        WHERE OID =' $oi->OID'
SQL;
        return $sql;
    }





    protected function parseForDb($oi){
        $db->OID = $oi->OID;
        $db->orderCode = $oi->orderCode;
        $db->uid = isset($oi->uid) ? $oi->uid  : NULL;
        $db->pbCode = $oi->titleCode . '.' . $oi->subCode . '.' . $oi->revision;
        $db->fingerprint = $oi->fingerprint;
        $db->quantity = $oi->quantity;
        $db->opened = (int)$oi->status->opened;
        $db->payed = (int)$oi->status->payed;
        $db->confirmed = (int)$oi->status->confirmed;
        $db->worked = (int)$oi->status->worked;
        $db->shipped = (int)$oi->status->shipped;
        $db->invoiced = (int)$oi->status->invoiced;
        $db->accepted = (int)$oi->status->accepted;
        $db->rejected = (int)$oi->status->rejected;
        $db->returned = (int)$oi->status->returned;
        $db->refounded = (int)$oi->status->refounded;
        $db->closed = (int)$oi->status->closed;
        $db->creationDate = $oi->status->creationDate ?       '"' . DateParser::timestampToMysql($oi->status->creationDate) . '"' : 'NULL';
        $db->paymentDate = $oi->status->paymentDate ?         '"' . DateParser::timestampToMysql($oi->status->paymentDate) . '"' : 'NULL';
        $db->shippingDate = $oi->status->shippingDate ?       '"' . DateParser::timestampToMysql($oi->status->shippingDate) . '"' : 'NULL';
        $db->deliveringDate = $oi->status->deliveringDate ?   '"' . DateParser::timestampToMysql( $oi->status->deliveringDate) . '"' : 'NULL';
        $db->closingDate = $oi->status->closingDate ?         '"' . DateParser::timestampToMysql($oi->status->closingDate) . '"' : 'NULL';

        return $db;
    }

}

 ?>
