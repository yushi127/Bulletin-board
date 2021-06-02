
<!DOCTYPE html>
<html>
<head>
<title>会員登録画面</title>
<meta charset="utf-8">
<link rel="stylesheet" href="./style.css" type="text/css">
<link rel="stylesheet" href="./responsive.css" type="text/css">
</head>
<body>
<h1>会員登録画面</h1>

  <!-- ここあってるかわからんから確認必要 (６７行目)-->
{if $errors == 0}

<form action="registration_insert.php" method="post">

<p>メールアドレス：{$smarty.session.mail}</p>
<p>アカウント名：{$smarty.session.name}</p>
<p>パスワード：{$password_hide}</p>


<input type="button" value="はじめに戻る" onClick="location.href='./registration_mail_form.php'">
<input type="hidden" name="token" value='{$smarty.session.token}'>
<input type="submit" value="登録する">

</form>
{/if}
</body>
</html>
