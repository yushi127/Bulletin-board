<?php
session_start();

header("Content-type: text/html; charset=utf-8");

require_once('./smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = './templates/';
$smarty->compile_dir = './templates_c/';
$smarty->config_dir = './configs/';
$smarty->cache_dir = './cache/';


//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];
$smarty->assign('token', $_SESSION['token']);

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

$smarty->display("registration_mail_form.tpl");

?>
