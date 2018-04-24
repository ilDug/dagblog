<?php
/******************************************************/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Headers: Origin, Authorization, Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control, X-Auth-Token");
header("Access-Control-Allow-Methods: GET,HEAD,PUT,PATCH,POST,DELETE");
/******************************************************/
require_once __DIR__ . '/RSAKey.class.php';
require_once __DIR__ . '/auth.config.php';

// $key = new RSAKey(RSA_KEY_PASSPHRASE);
// //$passPhrase = readline("inserire una passPhrase: ");
// $generation = $key->generatePrivate(RSA_KEY_PASSPHRASE);
//
// echo ($generation) ? "Chiave creata con la passPhrase: ". RSA_KEY_PASSPHRASE ." \n " : "Errori nella creazione della chiave \n";

 ?>
