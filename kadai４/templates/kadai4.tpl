

<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- <meta charset="UTF-8N"> -->
    <title>掲示板</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="./style.css" type="text/css">
    <link rel="stylesheet" href="./responsive.css" type="text/css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
  <header>
   <div class="header-left">
     <p class="envelope-big">ID</p>
     <div class="ID">
       {nocache}
       <p>{$smarty.session.ID}</p>
       <p>{$smarty.session.NAME}</p>
       {/nocache}
     </div>
   </div>
   <div class="header-right">
     <!-- ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー -->
     <ul>
       <li><a class="header-roguin" href="logout.php">ログアウト</a></li>
     </ul>
   </div>
  <div class="clear"></div>
 </header>
<h1>掲示板</h1>
<section>
    <h2>新規投稿</h2>
    <form action="kadai4.php" method="post" enctype="multipart/form-data">
        {nocache}
        　名前　: <input type="text" name="name"  value={$smarty.session.NAME} readonly>
        <p>{$err_msg1}</p>
        {/nocache}
        コメント: <input type="text" name="text" >
        {nocache}
        <p>{$err_msg2}</p>
        {/nocache}

        <label>画像/動画アップロード</label>
        <input type="file" name="upfile" >
        <!-- <p>{$err_msg15}</p><?php echo $err_msg15 ?>
        <p>{$err_msg16}</p><?php echo $err_msg16 ?> -->

        <br>
        ※画像はjpeg方式，png方式，gif方式に対応しています．動画はmp4方式のみ対応しています．<br>

        パスワードを設定　<input type="text" name="password" >
        {nocache}
        <p>{$err_msg7}</p>
        {/nocache}
        <input type="submit" value="投稿" name="posting"><br>
        {nocache}
        <p>{$message}</p>
        {/nocache}

    </form>


    <h2>投稿編集</h2>
    <form action="kadai4.php" method="post">
      編集番号　<input type="number" name="renum">
      {nocache}
      <p>{$err_msg3}</p>
      {/nocache}
      {nocache}
      名前: <input type="text" name="rename" value={$smarty.session.NAME} readonly>
      <p>{$err_msg4}</p>
      {/nocache}
      コメント: <input type="text" name="retext" >
      {nocache}
      <p>{$err_msg5}</p>
      {/nocache}
      パスワードを入力　<input type="text" name="pass2ed" >
      {nocache}
      <p>{$err_msg9}</p>
      {/nocache}
      <input type="submit" value="編集" name="edit"><br>
      {nocache}
      <p>{$message2}</p>
      {/nocache}
    </form>




    <h2>消去</h2>
    <form action="kadai4.php" method="post">
      消去番号 <input type="number" name="delnum">
      {nocache}
      <p>{$err_msg6}</p>
      {/nocache}
      パスワードを入力　<input type="text" name="pass3del" >
      {nocache}
      <p>{$err_msg8}</p>
      {/nocache}
      <a class="delp" href="#">消去</a><br><br>
      {nocache}
      <p>{$message3}</p>
      {/nocache}


      <!-- //////////////////////////////////////////////////////////// -->
      <!-- パスワード確認モーダル -->
      <div class="confirm">
        <div class="confirm-wrapper">
          <p class="batsu"><i class="fas fa-times"></i></p>
          <div class="clear"></div>
          <h1>本当に消去してもいいですか？</h1>
          <input type="submit" value="はい" name="delete">　　<br><br>
          <input type="submit" value="いいえ" name="delete3">　　<br>
        </div>
      </div>

      <!-- ///////////////////////////////////////////////////////////// -->

    </form>

</section>
<section>
    <h2>投稿一覧</h2>

    {foreach $values as $value}
    {$value}
    {/foreach}


    </section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
$(function(){
  $('.delp').click(function(){
    $('.confirm').addClass('open');
  });
  $('.batsu').click(function(){
    $('.confirm').removeClass('open');
});

  });

</script>

</body>
</html>
