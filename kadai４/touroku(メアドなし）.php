<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- <meta charset="UTF-8N"> -->
    <title>掲示板登録</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="./styles.css" type="text/css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
  <?php


  $db_host = 'localhost';
  $db_name = 'co_19_173_99sv_coco_com';
  $db_user = 'co-19-173.99sv-c';
  $db_pass = 'dD9fet3W';

  // データベースへ接続する
  $link = mysqli_connect( $db_host,$db_user,$db_pass,$db_name );

  define('DSN', 'mysql:host=localhost;dbname=kadai2_db');
  define('DB_USER', 'kadai2_user');
  define('DB_PASS', 'kadai2_pass');

  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("create table if not exists userDeta(
      id int not null auto_increment primary key,
      name varchar(10),
      email varchar(255),
      password varchar(255),
      created timestamp not null default current_timestamp
      )");
    } catch (Exception $e) {
      // echo $e->getMessage() . PHP_EOL;
    };
    $err_msg10="";
    $err_msg11="";
    $err_msg12="";
    $err_msg13="";
    $err_msg14="";
    $message2="";
    $dbname = ( isset($_POST["dbname"]  )  === true  ) ?$_POST["dbname"]: "";
    $dbmail = ( isset($_POST["dbmail"]  )  === true  ) ?$_POST["dbmail"]: "";
    $dbpass=( isset( $_POST["dbpass"] ) === true ) ?$_POST["dbpass"]: "";

    if ( isset($_POST["touroku-touroku"] ) ===  true ) {
        if ( $dbname   === "" ) $err_msg10 = "名前を入力してください";
        if ( $dbmail   === "" ) $err_msg11 = "メールアドレスを入力してください";
        if ( $dbpass  === "" )  $err_msg12= "パスワードを入力してください";

        if ( ($err_msg10 === "") && ($err_msg11 === "") && ($err_msg12 === "")) {
          if (filter_var($dbmail, FILTER_VALIDATE_EMAIL) === false) {
            $err_msg13 = "emailアドレスの形式ではありません";
          }

          if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $dbpass)) {
            $password = password_hash($_POST['dbpass'], PASSWORD_DEFAULT);
          } else {
            $err_msg14= "パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。";
          }
          // try {
          //   $stmt = $pdo->prepare("insert into userDeta(name, email, password) value(?, ?)");
          //   $stmt->execute([$dbname, $dbmail, $password]);
          //   $message2="登録に完了しました";
          // } catch (\Exception $e) {
          //   echo '登録済みのメールアドレスです。';
          // }
          if ( ($err_msg13 === "") && ($err_msg14 === "")) {
          $query = " INSERT INTO userDeta ( "
                 . "    name , "
                 . "    email , "
                 . "    password   "
                 . " ) VALUES ( "
                 . "'" . mysqli_real_escape_string( $link, $dbname ) ."', "
                 . "'" . mysqli_real_escape_string( $link, $dbmail ) ."', "
                 . "'" . mysqli_real_escape_string( $link, $password ) ."'  "
                 ." ) ";

          $res   = mysqli_query( $link, $query );
          $query  = "SELECT id, name, email, password, created FROM userDeta ORDER BY id";
          $res    = mysqli_query( $link,$query );
          $data = array();
          while( $row = mysqli_fetch_assoc( $res ) ) {
            array_push( $data, $row);
          }
          foreach( $data as $key => $val ){

            // echo $val['id'];
          $message2 =  "ID：" . $val['id'] . "　" ."name：". $val['name'] . "の登録に完了しました";
         }
        }
      }
      }
    ?>
  <div class="touroku">
   <div class="touroku-wrapper">
     <p class="batsu"><i class="fas fa-times"></i></p>
     <div class="clear"></div>
     <form class="login-input" action="touroku.php" method="post">
       <input  type="text" name="dbname" placeholder="ネーム">
       <?php echo $err_msg10; ?>
       <input  type="email" name="dbmail" placeholder="メールアドレス">
       <?php echo $err_msg11; ?>
       <?php echo $err_msg13; ?>
       <input  type="password" name="dbpass" placeholder="パスワード">
       <?php echo $err_msg12; ?>
       <?php echo $err_msg14; ?>
       <input type="submit" name="touroku-touroku" class="login-login touroku-touroku" value="登録">
       <?php echo $message2; ?>
       <p class="touroku-last">Airbnbアカウントはお持ちですか?<span><a href="http://co-19-173.99sv-coco.com/kadai%EF%BC%92/login.php">ログイン</a></span></p>
     </form>
   </div>
  </div>

  </body>
