
<!DOCTYPE html>
<html>
<head>
<title>メール登録画面</title>
<meta charset="utf-8">
<link rel="stylesheet" href="./style.css" type="text/css">
<link rel="stylesheet" href="./responsive.css" type="text/css">
</head>
<body>

<div class="touroku">
 <div class="touroku-wrapper">
   <div class="clear"></div>
   <form class="login-input" action="registration_mail_check.php" method="post">

     <p>メールアドレス：<input type="text" name="mail" size="50"></p>
     <p>アカウント名：<input type="text" name="name"></p>
     <p>パスワード：<input type="text" name="password"></p>

     <input type="hidden" name="token" value='{$smarty.session.token}'>
     <input type="submit" value="登録する" class="login-login touroku-touroku" >
     <p class="touroku-last">アカウントはお持ちですか?<span><a href="http://co-19-173.99sv-coco.com/kadai%EF%BC%94/login.php">ログイン</a></span></p>
   </form>
 </div>
</div>


</body>
</html>
