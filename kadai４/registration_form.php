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

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//データベース接続
require_once("db.php");
$dbh = db_connect();

//エラーメッセージの初期化
$errors = array();


if(empty($_GET)) {
	header("Location: registration_mail_form.php");
	exit();
}else{
	//GETデータを変数に入れる
	$urltoken = isset($_GET['urltoken']) ? $_GET['urltoken'] : NULL;
	//メール入力判定
	if ($urltoken == ''){
		$errors['urltoken'] = "もう一度登録をやりなおして下さい。";
	}else{
		try{
			//例外処理を投げる（スロー）ようにする
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			//flagが0の未登録者・仮登録日から24時間以内
			$statement = $dbh->prepare("SELECT mail, name, password FROM pre_member WHERE urltoken=(:urltoken) AND flag =0 AND date > now() - interval 24 hour");
			$statement->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
			$statement->execute();

			//レコード件数取得
			$row_count = $statement->rowCount();

			//24時間以内に仮登録され、本登録されていないトークンの場合
			if( $row_count ==1){
				$mail_array = $statement->fetch();
				$mail = $mail_array['mail'];
				$_SESSION['mail'] = $mail;
				$statement->execute();
				$account_array = $statement->fetch();
				$name = $account_array['name'];
				$_SESSION['name'] = $name;
				$statement->execute();
				$password_array = $statement->fetch();
				$password = $password_array['password'];
				$_SESSION['password'] = $password;
				$password_hide = str_repeat('*', strlen($password));
				$smarty->assign('password_hide', str_repeat('*', strlen($password)));
			}else{
				$errors['urltoken_timeover'] = "このURLはご利用できません。有効期限が過ぎた等の問題があります。もう一度登録をやりなおして下さい。";
			}

      $smarty->assign('errors', count($errors));
			//データベース接続切断
			$dbh = null;

		}catch (PDOException $e){
			print('Error:'.$e->getMessage());
			die();
		}
	}
}
$smarty->display("registration_form.tpl");

?>
