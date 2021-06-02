
  <?php
  // require 'password.php';   // password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
  // セッション開始
  session_start();

  $db['host'] = "localhost";
  $db['dbname'] ="co_19_173_99sv_coco_com";
  $db['user'] = "co-19-173.99sv-c";
  $db['pass'] = "dD9fet3W";

  // エラーメッセージの初期化


  require_once('./smarty/Smarty.class.php');
  $smarty = new Smarty();
  $smarty->template_dir = './templates/';
  $smarty->compile_dir = './templates_c/';
  // $smarty->config_dir = './configs/';
  // $smarty->cache_dir = './cache/';

  $smarty->assign('errorMessage',"");


  // ログインボタンが押された場合
  if (isset($_POST["login-login"])) {
      // 1. ユーザIDの入力チェック
      if (empty($_POST["loginname"])) {  // emptyは値が空のとき
          $smarty->assign('errorMessage', "ユーザーIDが未入力です。");
      } else if (empty($_POST["loginpass"])) {
          $smarty->assign('errorMessage', "パスワードが未入力です。");
      } else if (empty($_POST["loginmail"])) {
          $smarty->assign('errorMessage', "メールアドレスがが未入力です。");
      }

      if (!empty($_POST["loginname"]) && !empty($_POST["loginpass"]) && !empty($_POST["loginmail"])) {
          // 入力したユーザIDを格納
          $username = $_POST["loginname"];
          $mail = $_POST["loginmail"];

          // 2. ユーザIDとパスワードが入力されていたら認証する
          $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

          // 3. エラー処理
          try {
              $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

              $stmt = $pdo->prepare("SELECT * FROM member WHERE name = ? ");
              // $stmt->execute(array($username));
              $stmt->execute(array($username));

              $password = $_POST["loginpass"];

              if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  if (password_verify($password, $row['password']) && ($mail === $row['mail'])) {
                    // && ($mail == $row['mail'])
                      session_regenerate_id(true);

                      ///////////////////////////////////////////////////////////////
                      // 入力したIDのユーザー名を取得
                      $id = $row['id'];
                      $sql = "SELECT * FROM member WHERE id = $id";  //入力したIDからユーザー名を取得
                      $stmt = $pdo->query($sql);
                      foreach ($stmt as $row) {
                          $row['name'];  // ユーザー名
                          // $row['mail'];  // メアド
                      }
                      $_SESSION["NAME"] = $row['name'];
                      $_SESSION["ID"] = $id;
                      header("Location: kadai4.php");  // メイン画面へ遷移
                      exit();  // 処理終了
                      //////////////////////////////////////////////////////////////////

                      /////////////////////////////////////////////////////////
                      // 入力したIDのユーザー名を取得
                      // $id = $row['id'];
                      // $sql = "SELECT * FROM member WHERE name = '$username'";  //入力したユーザー名からIDユーザー名を取得
                      // $stmt = $pdo->query($sql);
                      // foreach ($stmt as $row) {
                      //     $row['id'];  // id
                      //     // $row['mail'];  // メアド
                      // }
                      // $_SESSION['NAME'] = $row['name'];
                      // $_SESSION['ID'] = $row['id'];
                      // header("Location: kadai4.php");  // メイン画面へ遷移
                      // exit();  // 処理終了
                      /////////////////////////////////////////////////////////
                  } else {
                      // 認証失敗
                      $smarty->assign('errorMessage', "ユーザーID,メールアドレスあるいはパスワードに誤りがあります。");
                  }
              } else {
                  // 4. 認証成功なら、セッションIDを新規に発行する
                  // 該当データなし
                  $smarty->assign('errorMessage', "ユーザーID、メールアドレスあるいはパスワードに誤りがあります。");
              }
          } catch (PDOException $e) {
            $smarty->assign('errorMessage', "データベースエラー");
              //$errorMessage = $sql;
              // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
              // echo $e->getMessage();
          }
      }
  }
  $smarty->display('login.tpl');

  if (!empty($_POST["loginname"])) {
    $smarty->assign('loginname', $_POST["loginname"]);
  };

  ?>

  <!-- <!doctype html>
  <html>
      <head>
              <meta charset="UTF-8">
              <title>ログイン</title>
      </head>
      <body> -->
