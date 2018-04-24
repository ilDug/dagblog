<?php
		define ('ACTIVATION_KEY_LENGTH', 64);
		define ('USERIDP_CODE_LENGTH', 32);

		define ('DB', 'ydomjpkn_shop');
		define ('HOST', 'localhost');
		define ('USER', 'ydomjpkn_customer');
		define ('DBPASS', 'NA6lQT9ti0B9');


		$token = password_hash('requestposterbooktitle', PASSWORD_DEFAULT);
		define('REQUEST_AUTH_TOKEN', $token);


?>
