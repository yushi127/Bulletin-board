
<!DOCTYPE html>
<html>
<head>
<title>メール確認画面</title>
<meta charset="utf-8">
<link rel="stylesheet" href="./style.css" type="text/css">
<link rel="stylesheet" href="./responsive.css" type="text/css">
</head>
<body>
<h1>メール確認画面</h1>

	{if $errors == 0}

	<p>{$message}</p>


<p>↓このURLが記載されたメールが届きます。</p>
<a href='{$url}'>{$url}</a>
	{elseif $errors > 0}
<p>{$value}</p>


<input type="button" value="戻る" onClick="history.back()">

{/if}


</body>
</html>
