<?php
session_start();

header("Content-type: text/html; charset=utf-8");

require_once('./smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = './templates/';
$smarty->compile_dir = './templates_c/';
$smarty->config_dir = './configs/';
$smarty->cache_dir = './cache/';

//クロスサイトリクエストフォージェリ（CSRF）対策のトークン判定
if ($_POST['token'] != $_SESSION['token']){
	echo "不正アクセスの可能性あり";
	exit();
}

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//データベース接続
require_once("db.php");
$dbh = db_connect();

//エラーメッセージの初期化
$errors = array();


if(empty($_POST)) {
	header("Location: registration_mail_form.php");
	exit();
}

$mail = $_SESSION['mail'];
$name = $_SESSION['name'];

//パスワードのハッシュ化
$password_hash =  password_hash($_SESSION['password'], PASSWORD_DEFAULT);

//ここでデータベースに登録する
try{
	//例外処理を投げる（スロー）ようにする
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//トランザクション開始
	$dbh->beginTransaction();

	//memberテーブルに本登録する
	$statement = $dbh->prepare("INSERT INTO member (name,mail,password) VALUES (:name,:mail,:password_hash)");
	//プレースホルダへ実際の値を設定する
	$statement->bindValue(':name', $name, PDO::PARAM_STR);
	$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
	$statement->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
	$statement->execute();

	//pre_memberのflagを1にする
	$statement = $dbh->prepare("UPDATE pre_member SET flag=1 WHERE mail=(:mail)");
	//プレースホルダへ実際の値を設定する
	$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
	$statement->execute();

	// トランザクション完了（コミット）
	$dbh->commit();

	//データベース接続切断
	$dbh = null;

	//セッション変数を全て解除
	$_SESSION = array();

	//セッションクッキーの削除・sessionidとの関係を探れ。つまりはじめのsesssionidを名前でやる
	if (isset($_COOKIE["PHPSESSID"])) {
    		setcookie("PHPSESSID", '', time() - 1800, '/');
	}

 	//セッションを破棄する
 	session_destroy();

 	/*
 	登録完了のメールを送信
 	*/

}catch (PDOException $e){
	//トランザクション取り消し（ロールバック）
	$dbh->rollBack();
	$errors['error'] = "もう一度やりなおして下さい。";
	print('Error:'.$e->getMessage());
}

$smarty->assign('errors', count($errors));

foreach($errors as $value){
	$smarty->assign('value', $value);
}
$smarty->display("registration_insert.tpl");
?>
