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
$smarty->assign('message', "");



if(empty($_POST)) {
	header("Location: registration_mail_form.php");
	exit();
}else{
	//POSTされたデータを変数に入れる
	$mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;



	//メール入力判定
	if ($mail == ''){
		$errors['mail'] = "メールが入力されていません。";
	}else{
		if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
			$errors['mail_check'] = "メールアドレスの形式が正しくありません。";
		}
		/*
		本登録用のmemberテーブルにすでに登録されているmailかどうかをチェックする。
		$errors['member_check'] = "このメールアドレスはすでに利用されております。";
		*/


				if (empty($errors)) {
					$sql ='select COUNT(*) AS cnt FROM member WHERE mail =:mail';
					$stmt = $dbh->prepare($sql);
					$stmt->bindValue(':mail',$mail);
					$stmt->execute();
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					// var_dump($result);

								if ($result['cnt']  > 0) {
										$error['mail'] = 'duplicate';
								}else{
									$error['mail'] = '';
								}
								if ($error['mail'] == 'duplicate'){
									$errors['member_check'] = "このメールアドレスはすでに利用されております。";
								}
						}

	}



	function spaceTrim ($str) {
		// 行頭
		$str = preg_replace('/^[ 　]+/u', '', $str);
		// 末尾
		$str = preg_replace('/[ 　]+$/u', '', $str);
		return $str;
	}
	//POSTされたデータを各変数に入れる
	$name = isset($_POST['name']) ? $_POST['name'] : NULL;
	$password = isset($_POST['password']) ? $_POST['password'] : NULL;

	//前後にある半角全角スペースを削除
	$name = spaceTrim($name);
	$password = spaceTrim($password);

	//アカウント入力判定
	if ($name == ''):
		$errors['name'] = "アカウントが入力されていません。";
	elseif(mb_strlen($name)>10):
		$errors['account_length'] = "アカウントは10文字以内で入力して下さい。";
	endif;

	//パスワード入力判定
	if ($password == ''):
		$errors['password'] = "パスワードが入力されていません。";
	elseif(!preg_match('/^[0-9a-zA-Z]{5,30}$/', $_POST["password"])):
		$errors['password_length'] = "パスワードは半角英数字の5文字以上30文字以下で入力して下さい。";
	else:
		$password_hide = str_repeat('*', strlen($password));
	endif;

	if(count($errors) === 0){
		$_SESSION['name'] = $name;
		$_SESSION['password'] = $password;
	}
}

if (count($errors) === 0){

	$urltoken = hash('sha256',uniqid(rand(),1));
	$url = "http://co-19-173.99sv-coco.com/kadai%EF%BC%94/registration_form.php"."?urltoken=".$urltoken;
  $smarty->assign('url', "http://co-19-173.99sv-coco.com/kadai%EF%BC%94/registration_form.php"."?urltoken=".$urltoken);
	//ここでデータベースに登録する
	try{
		//例外処理を投げる（スロー）ようにする
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$statement = $dbh->prepare("INSERT INTO pre_member (urltoken,mail,date,name,password) VALUES (:urltoken,:mail,now(),:name,:password )");

		//プレースホルダへ実際の値を設定する
		$statement->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
		$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
		$statement->bindValue(':name', $name, PDO::PARAM_STR);
		$statement->bindValue(':password', $password, PDO::PARAM_STR);

		$statement->execute();

		//データベース接続切断
		$dbh = null;

	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}

	//メールの宛先
	$mailTo = $mail;

	//Return-Pathに指定するメールアドレス
	$returnMail = 'web@sample.com';

	$name = "掲示板";
	$mail = 'web@sample.com';
	$subject = "【掲示板課題】会員登録用URLのお知らせ";

$body = <<< EOM
24時間以内に下記のURLからご登録下さい。
{$url}
EOM;

	mb_language('ja');
	mb_internal_encoding('UTF-8');
	//Fromヘッダーを作成
	$header = 'From: ' . mb_encode_mimeheader($name). ' <' . $mail. '>';

	if (mb_send_mail($mailTo, $subject, $body, $header, '-f'. $returnMail)) {

	 	//セッション変数を全て解除
		$_SESSION = array();

		//クッキーの削除
		if (isset($_COOKIE["PHPSESSID"])) {
			setcookie("PHPSESSID", '', time() - 1800, '/');
		}

 		//セッションを破棄する
 		session_destroy();

		$smarty->assign('message', 'メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。');

	 } else {
		$errors['mail_error'] = "メールの送信に失敗しました。";
	}
}
$smarty->assign('errors', count($errors));

foreach($errors as $value){
	$smarty->assign('value', $value);
}
$smarty->display("registration_mail_check.tpl");

?>
