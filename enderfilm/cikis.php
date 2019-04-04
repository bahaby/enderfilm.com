<?php 
	require_once 'core/init.php';
	$kullanici= new Kullanici;
	$kullanici->cikisYap();
	Yonlendir::git($_SERVER['HTTP_REFERER']);
?>