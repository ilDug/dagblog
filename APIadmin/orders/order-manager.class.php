<?php
require_once(__DIR__ . '/order-engine.class.php');
require_once(__DIR__ . '/../Email.class.php');



/**
 * gestione degli ordini
 */
class OrderManager extends OrderEngine
{
    /**
     * ottine tutti gli ordini da una certa data. sel adata non viene passata li ritorna proprio tutti;
     * @return array of object OrderItem;
     */
    public function getOrders($since = null){
        $sql =  "SELECT fingerprint, OID from orders";
        $sql .= isset($since) ?  " WHERE creationDate > '" . $this->dateParser->timestampToMysql($since) . "'" :'';
        $list =  $this->getOrderFromDB($sql);
        $orders = array();
        //raggruppa per codice
        foreach ($list as $item) { $orders[$item->orderCode][] = $item ;}
        return $orders;
    }






    public function activeOrders(){
        $sql =  "SELECT fingerprint from orders WHERE closed = 0";
        $list =  $this->getOrderFromDB($sql);
        $orders = array();
        //raggruppa per codice
        foreach ($list as $item) { $orders[$item->orderCode][] = $item ;}
        return $orders;
    }






    /**
     * aggiorna il database e ritorna l'orderCode dell'ordine
     */
    public function setOrder($order){
        if(!isset($order) || !isset($order->items) ||  count($order->items) == 0) return new ServerResponse(false, 'malformed order');

        foreach ($order->items as $oi) {
            $sql  =  $this->updateQuery($oi);
            if($this->SetDataInDB($sql) == -1) { return new ServerResponse(false, 'errore scrittura database', null); break; }
        }

        return new ServerResponse(true, 'ordine salvato', $sql);
    }



    /**
     * manda le mail di conferma spedizione
     */
    public function sendShipConfirmation($orderCode, $trackingCode, $trackingLink){
        $sql =  "SELECT fingerprint FROM orders WHERE orderCode = '$orderCode'";
        $items =  $this->getOrderFromDB($sql);
        $recipient = $items[0]->billingAddress->email;
        $subject = "Conferma spedizione PosterBook - " . $items[0]->orderCode;


        $body = file_get_contents(__DIR__ . '/emails/email-ship-confirmation-template.html');
        $sr = array(
            "%ORDER_CODE%" => $items[0]->orderCode,
            "%FIRSTNAME%" => $items[0]->shippingAddress->firstName,
            "%LASTNAME% " => $items[0]->shippingAddress->lastName,
            "%CAP%" => $items[0]->shippingAddress->cap,
            "%ADDRESS%" => $items[0]->shippingAddress->address,
            "%CITY%" => $items[0]->shippingAddress->city,
            "%PROVINCE%" => $items[0]->shippingAddress->province,
            "%TRACKING_CODE%" => $trackingCode,
            "%TRACKING_LINK%" => $trackingLink
        );

        $body = str_replace(array_keys($sr), array_values($sr), $body);

        $customerEmail = new PBMail($recipient, $subject, $body, 'shop');
        $receipt = $customerEmail->send();

        return $receipt;
    }





}


















 ?>
