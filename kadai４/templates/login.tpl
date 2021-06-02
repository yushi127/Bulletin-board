
      <!DOCTYPE html>
      <html lang="ja">
      <head>
        <!-- <meta charset="UTF-8N"> -->
        <title>掲示板ログイン</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <link rel="stylesheet" href="./style.css" type="text/css">
        <link rel="stylesheet" href="./responsive.css" type="text/css">
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
      </head>
      <body>


          <div class="login">
            <div class="login-wrapper">
              <!-- <p class="batsu"><i class="fas fa-times"></i></p> -->
              <!-- <div class="clear"></div> -->
              <div class="position">
                <div class="login-top">
                </div>
              </div>
              <form class="login-input" action="login.php" method="post">
                <input  type="text" placeholder="名前" name="loginname" >
                <input  type="email" placeholder="メールアドレス" name="loginmail">
                <input  type="password" placeholder="パスワード" name="loginpass">
                <!--  echo $errorMessage;   -->
                <p>{$errorMessage}</p>
                <input  type="submit" name="login-login" class="login-login" value="ログイン">
              </form>
              <!-- <div class="login-inline">
              <P class="login-inline1">ログイン情報を保存</p>
              <p class="login-inline2">パスワードを表示する</p>
            </div> -->
            <p class="login-last">アカウントをお持ちではないですか?<span><a href="http://co-19-173.99sv-coco.com/kadai%EF%BC%94/registration_mail_form.php">登録</a></span></p>
          </div>
        </div>
      </body>
  </html>
