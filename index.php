<?php

error_reporting (E_ALL ^ E_NOTICE);

if (preg_match("/MSIE [5-9]/", $_SERVER['HTTP_USER_AGENT']) ) {// || (preg_match("/MSIE 7/", $_SERVER['HTTP_USER_AGENT']) && preg_match('/Trident\/[0-5]/', $_SERVER['HTTP_USER_AGENT']) )
	echo '<html>';
	echo '<head>';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	echo '</head>';
	echo '<body>';
	//echo $_SERVER['HTTP_USER_AGENT'].'<br>';
	//var_dump($_SERVER);
	echo '<br><center><h1>You web browser access denide.<br> Browser นี้ไม่สามารถแสดงผลหรือประมวลผลได้<br>กรุณาใช้  Browser อื่น เพื่อเลี่ยงปัญหาที่จะเกิดขึ้น<br>';
	echo "<br>แนะนำให้ใช้ Browser <a href='https://www.google.co.th/chrome/browser/desktop/index.html?hl=th&brand=CHNG&utm_source=th-hpp&utm_medium=hpp&utm_campaign=th'>Google Chrome</a><br>";
	echo '<br>**ขออภัยในความไม่สะดวก**</h1></center>';
	echo '</body>';
	echo '</html>';
	exit();
}

//// Autoload
require 'libs/Bootstrap.php';
require 'libs/Controller.php';
require 'libs/Model.php';
require 'libs/View.php';

 //Library
require 'libs/Database.php';
require 'libs/Session.php';

require 'config/paths.php';
require 'config/database.php';
require 'config/system_name.php';

Session::init();
$app = new Bootstrap();

//require 'config.php';
//
//// Also spl_autoload_register (Take a look at it if you like)
//function __autoload($class) {
//	require LIBS . $class .".php";
//}
//
//
//
//$app = new Bootstrap();