<?php 


if (empty($_SESSION['csrf'])) {
	if (function_exists('random_bytes')) {
		$_SESSION['csrf'] = bin2hex(random_bytes(32));
	} else if (function_exists('mcrypt_create_iv')) {
		$_SESSION['csrf'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
	} else {
		$_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
	}
}


if($_SERVER['REQUEST_METHOD']==='POST'){
	if(!hash_equals($_SESSION['csrf'], $_POST['csrf'])){
		echo "Invalid CSRF token!";
		die();
	}else{
		unset($_SESSION['csrf']);
	}
}


?>