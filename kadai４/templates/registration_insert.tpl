
<!DOCTYPE html>
<html>
<head>
<title>会員登録完了画面</title>
<meta charset="utf-8">
<link rel="stylesheet" href="./style.css" type="text/css">
<link rel="stylesheet" href="./responsive.css" type="text/css">
</head>
<body>

<?php if (count($errors) === 0): ?>
	{if $errors == 0}

<h1>会員登録完了画面</h1>

<p>登録完了いたしました。ログイン画面からどうぞ。</p>
<p><a href="http://co-19-173.99sv-coco.com/kadai%EF%BC%94/login.php">ログイン画面（未リンク）</a></p>

<?php elseif(count($errors) > 0): ?>
	{elseif $errors > 0}


<p>{$value}</p>

?>

{/if}


</body>
</html>
