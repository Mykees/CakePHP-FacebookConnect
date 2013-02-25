<?php
$default = array(

	'facebook'=>array(
		'facebookSDK' => APP . 'Plugin' . DS . 'Facebook' . DS . 'Vendor' . DS . 'Facebook'.DS.'facebook.php',
		'appID'=>'YOUR APPID',
		'secretKey'=>'YOUR SECRET KEY',
	)
);
Configure::write('Plugin.Facebook', (Configure::read('Plugin.Facebook') ? Configure::read('Plugin.Facebook') : array()) + $default);