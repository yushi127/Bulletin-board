

<?php
session_start();
// include 'login.php';
$db_host = 'localhost';
$db_name = 'co_19_173_99sv_coco_com';
$db_user = 'co-19-173.99sv-c';
$db_pass = 'dD9fet3W';

// データベースへ接続する
$link = mysqli_connect( $db_host,$db_user,$db_pass,$db_name );

$sessionname=$_SESSION['NAME'];
if (!isset($_SESSION['NAME']) === true) {
    header("Location:logout.php");
    exit;
}

if ( $link !== false ) {

  require_once('./smarty/Smarty.class.php');
  $smarty = new Smarty();
  $smarty->template_dir = './templates/';
  $smarty->compile_dir = './templates_c/';
  $smarty->config_dir = './configs/';


$smarty->assign('err_msg1',"" );
$smarty->assign('err_msg2',"" );
$smarty->assign('err_msg3',"" );
$smarty->assign('err_msg4',"" );
$smarty->assign('err_msg5',"" );
$smarty->assign('err_msg6',"" );
$smarty->assign('err_msg7',"" );
$smarty->assign('err_msg8',"" );
$smarty->assign('err_msg9',"" );
$smarty->assign('err_msg10',"" );
$smarty->assign('err_msg11',"" );
$smarty->assign('err_msg12',"" );
$smarty->assign('err_msg13',"" );
$smarty->assign('err_msg14',"" );
$smarty->assign('err_msg15',"" );
$smarty->assign('err_msg16',"" );
$smarty->assign('err_msg17',"" );
$smarty->assign('message',"" );
$smarty->assign('message2',"" );
$smarty->assign('message3',"" );



        $message ="";
        $err_msg1 = "";
        $err_msg2 = "";
        $err_msg7= "";
        $err_msg15="";
        $err_msg16="";
        $err_msg17="";
        $passmessage="";
        $name=( isset( $_POST["name"] ) === true ) ?$_POST["name"]: "";
        $text=( isset( $_POST["text"] ) === true ) ?$_POST["text"]: "";
        $password=( isset( $_POST["password"] ) === true ) ?$_POST["password"]: "";
        $upfile=(isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== "") ?$_FILES["upfile"]: "";
        $user = "co-19-173.99sv-c";
        $pass = "dD9fet3W";
        $pdo = new PDO("mysql:host=localhost;dbname=co_19_173_99sv_coco_com;charset=utf8", $user, $pass);

        // // コメントだけ入力されていた時
            if ( isset($_POST["posting"] ) === true ) {
              if ( $name     === "" ) $err_msg1 = "名前を入力してください";
              if (($text     === "") && ($upfile    === "")) $err_msg2 = "コメント、画像を入力してください";
              if (($text     === "") && ($upfile    !== "")) $err_msg15 = "コメントを入力してください";
              if (($text     !== "") && ($upfile    === "")) $err_msg16 = "画像を選択してください";
              if ( $password === "" ) $err_msg7 = "パスワードを入力してください";


              if ( $name     === "" ) $smarty->assign('err_msg1', "名前を入力してください");
              if (($text     === "") && ($upfile    === "")) $smarty->assign('err_msg2', "コメント、画像を入力してください");
              if (($text     === "") && ($upfile    !== "")) $smarty->assign('err_msg15', "コメントを入力してください");
              if (($text     !== "") && ($upfile    === "")) $smarty->assign('err_msg16', "画像を選択してください");
              if ( $password === "" ) $smarty->assign('err_msg7', "パスワードを入力してください");
              if ( ($err_msg1 === "") && ($err_msg7 === "") && ($err_msg15 === "") && ($err_msg16 !== "")) {
                $query = " INSERT INTO board ( "
                       . "    name , "
                       . "    text , "
                       . "    password   "
                       . " ) VALUES ( "
                       . "'" . mysqli_real_escape_string( $link, $name ) ."', "
                       . "'" . mysqli_real_escape_string( $link, $text ) ."', "
                       . "'" . mysqli_real_escape_string( $link, $password ) ."'  "
                       ." ) ";

                $res   = mysqli_query( $link, $query );
                  // $message = "投稿に成功しました。";
                  $smarty->assign('message', "投稿に成功しました。");
                  $smarty->clearAllCache();

                }
              }

            // // 画像だけ入力されていた時
          if ( isset($_POST["posting"] ) === true ) {

            if ( $name     === "") $err_msg1 = "名前を入力してください";
            if (($text     === "") && ($upfile    === "")) $err_msg2 = "コメント、画像を入力してください";
            if (($text     === "") && ($upfile    !== "")) $err_msg15 = "コメントを入力してください";
            if (($text     !== "") && ($upfile    === "")) $err_msg16 = "画像を選択してください";
            if ( $password === "" ) $err_msg7 = "パスワードを入力してください";


            if ( $name     === "") $smarty->assign('err_msg1', "名前を入力してください");
            if (($text     === "") && ($upfile    === ""))  $smarty->assign('err_msg2', "コメント、画像を入力してください");
            if (($text     === "") && ($upfile    !== "")) $smarty->assign('err_msg15', "コメントを入力してください");
            if (($text     !== "") && ($upfile    === "")) $smarty->assign('err_msg16', "画像を選択してください");
            if ( $password === "" ) $smarty->assign('err_msg7', "パスワードを入力してください");
            if ( ($err_msg1 === "") && ($err_msg16 === "") && ($err_msg7 === "") && ($err_msg15 !== "")) {

              // 画像投稿
              try{

                //ファイルアップロードがあったとき
                // if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== ""){


                  //エラーチェック
                  switch ($_FILES['upfile']['error']) {
                    case UPLOAD_ERR_OK: // OK
                    break;
                    case UPLOAD_ERR_NO_FILE:   // 未選択
                    throw new RuntimeException('ファイルが選択されていません', 400);
                    case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
                    throw new RuntimeException('ファイルサイズが大きすぎます', 400);
                    default:
                    throw new RuntimeException('その他のエラーが発生しました', 500);
                  }


                  //画像・動画をバイナリデータにする．
                  $raw_data = file_get_contents($_FILES['upfile']['tmp_name']);

                  //拡張子を見る
                  $tmp = pathinfo($_FILES["upfile"]["name"]);
                  $extension = $tmp["extension"];
                  if($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG"){
                    $extension = "jpeg";
                  }
                  elseif($extension === "png" || $extension === "PNG"){
                    $extension = "png";
                  }
                  elseif($extension === "gif" || $extension === "GIF"){
                    $extension = "gif";
                  }
                  elseif($extension === "mp4" || $extension === "MP4"){
                    $extension = "mp4";
                  }
                  else{
                    echo "非対応ファイルです．<br/>";
                    echo ("<a href=\"index.php\">戻る</a><br/>");
                    exit(1);
                  }

                  //DBに格納するファイルネーム設定
                  //サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
                  $date = getdate();
                  $fname = $_FILES["upfile"]["tmp_name"].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];
                  $fname = hash("sha256", $fname);


                //画像・動画をDBに格納．
                $sql = "INSERT INTO board (name, text, password, fname, extension, raw_data ) VALUES (:name,:text ,:password,:fname, :extension, :raw_data);";
                $stmt = $pdo->prepare($sql);
                $stmt -> bindValue(":name",$name, PDO::PARAM_STR);
                $stmt -> bindValue(":text",$text, PDO::PARAM_STR);
                $stmt -> bindValue(":password",$password, PDO::PARAM_STR);
                $stmt -> bindValue(":fname",$fname, PDO::PARAM_STR);
                $stmt -> bindValue(":extension",$extension, PDO::PARAM_STR);
                $stmt -> bindValue(":raw_data",$raw_data, PDO::PARAM_STR);
                $stmt -> execute();


                // $res   = mysqli_query( $link, $sql );

              }

              catch(PDOException $e){
                echo("<p>500 Inertnal Server Error</p>");
                exit($e->getMessage());
              }

                $message = "投稿に成功しました";
                $smarty->assign('message', "投稿に成功しました。");
                $smarty->clearAllCache();

              }
            }
            // \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

            // // すべて入力されていた時
            if ( isset($_POST["posting"] ) === true ) {
              if ( $name     === "") $err_msg1 = "名前を入力してください";
              if (($text     === "") && ($upfile    === ""))  $err_msg2 = "コメント、画像を入力してください";
              if (($text     === "") && ($upfile    !== ""))  $err_msg15 = "コメントを入力してください";
              if (($text     !== "") && ($upfile    === ""))  $err_msg16 = "画像を選択してください";
              if (($text     !== "") && ($upfile    !== ""))  $err_msg17 = "両方選択されています";
              if ( $password === "" ) $err_msg7 = "パスワードを入力してください";


              if ( $name     === "") $smarty->assign('err_msg1', "名前を入力してください");
              if (($text     === "") && ($upfile    === ""))  $smarty->assign('err_msg2', "コメント、画像を入力してください");
              if (($text     === "") && ($upfile    !== ""))  $smarty->assign('$err_msg15', "コメントを入力してください");
              if (($text     !== "") && ($upfile    === ""))  $smarty->assign('$err_msg16', "画像を選択してください");
              if (($text     !== "") && ($upfile    !== ""))  $smarty->assign('$err_msg17', "両方選択されています");
              if ( $password === "" ) $smarty->assign('err_msg7', "パスワードを入力してください");
              if ( ($err_msg1 === "") && ($err_msg17 !== "") && ($err_msg7 === "")) {

                // 画像投稿
                try{

                  //ファイルアップロードがあったとき
                  // if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== ""){


                    //エラーチェック
                    switch ($_FILES['upfile']['error']) {
                      case UPLOAD_ERR_OK: // OK
                      break;
                      case UPLOAD_ERR_NO_FILE:   // 未選択
                      throw new RuntimeException('ファイルが選択されていません', 400);
                      case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
                      throw new RuntimeException('ファイルサイズが大きすぎます', 400);
                      default:
                      throw new RuntimeException('その他のエラーが発生しました', 500);
                    }


                    //画像・動画をバイナリデータにする．
                    $raw_data = file_get_contents($_FILES['upfile']['tmp_name']);

                    //拡張子を見る
                    $tmp = pathinfo($_FILES["upfile"]["name"]);
                    $extension = $tmp["extension"];
                    if($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG"){
                      $extension = "jpeg";
                    }
                    elseif($extension === "png" || $extension === "PNG"){
                      $extension = "png";
                    }
                    elseif($extension === "gif" || $extension === "GIF"){
                      $extension = "gif";
                    }
                    elseif($extension === "mp4" || $extension === "MP4"){
                      $extension = "mp4";
                    }
                    else{
                      echo "非対応ファイルです．<br/>";
                      echo ("<a href=\"index.php\">戻る</a><br/>");
                      exit(1);
                    }

                    //DBに格納するファイルネーム設定
                    //サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
                    $date = getdate();
                    $fname = $_FILES["upfile"]["tmp_name"].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];
                    $fname = hash("sha256", $fname);


                  //画像・動画をDBに格納．
                  $sql = "INSERT INTO board (name, text, password, fname, extension, raw_data ) VALUES (:name,:text ,:password,:fname, :extension, :raw_data);";
                  $stmt = $pdo->prepare($sql);
                  $stmt -> bindValue(":name",$name, PDO::PARAM_STR);
                  $stmt -> bindValue(":text",$text, PDO::PARAM_STR);
                  $stmt -> bindValue(":password",$password, PDO::PARAM_STR);
                  $stmt -> bindValue(":fname",$fname, PDO::PARAM_STR);
                  $stmt -> bindValue(":extension",$extension, PDO::PARAM_STR);
                  $stmt -> bindValue(":raw_data",$raw_data, PDO::PARAM_STR);
                  $stmt -> execute();


                  // $res   = mysqli_query( $link, $sql );

                }

                catch(PDOException $e){
                  echo("<p>500 Inertnal Server Error</p>");
                  exit($e->getMessage());
                }


                  $message = "投稿に成功しました。";
                  $smarty->assign('message', "投稿に成功しました。");
                  $smarty->clearAllCache();

                }
              }
              // \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


            $query  = "SELECT id, name, text, date, password, fname, extension, raw_data FROM board ORDER BY id";
            $res    = mysqli_query( $link,$query );
            $data = array();
            while( $row = mysqli_fetch_assoc( $res ) ) {
              array_push( $data, $row);
            }


        // 編集フォーム
        $err_msg3 = "";
        $err_msg4 = "";
        $err_msg5 = "";
        $err_msg9 = "";
        $message2 ="";
        $renum=( isset( $_POST["renum"] ) === true ) ?$_POST["renum"]: "";
        $rename=( isset( $_POST["rename"] ) === true ) ?$_POST["rename"]: "";
        $retext=( isset( $_POST["retext"] ) === true ) ?$_POST["retext"]: "";
        $pass2ed=( isset( $_POST["pass2ed"] ) === true ) ?$_POST["pass2ed"]: "";

        if (  isset($_POST["edit"] ) ===  true ) {

          if ( $renum   === "" ) $err_msg3 = "番号を入力してください";
          if ( $rename   === "" ) $err_msg4 = "名前を入力してください";
          if ( $retext  === "" )  $err_msg5 = "コメントを入力してください";
          if ( $pass2ed  === "" )  $err_msg9 = "パスワードを入力してください";


          if ( $renum   === "" ) $smarty->assign('err_msg3', "番号を入力してください");
          if ( $rename   === "" ) $smarty->assign('err_msg4', "名前を入力してください");
          if ( $retext  === "" )  $smarty->assign('err_msg5', "コメントを入力してください");
          if ( $pass2ed  === "" )  $smarty->assign('err_msg9', "パスワードを入力してください");

          if ( ($err_msg3 === "") && ($err_msg4 === "") && ($err_msg5 === "") && ($err_msg9 === "") ) {
            foreach( $data as $key => $val ){
                  if ($val['id'] !== $renum) {
                  }
                  else {  // <-- 投稿番号と編集番号が一致
                    if ($val['password'] === $pass2ed){
                      // ここに編集のコード書く
                      $sql = "UPDATE board SET name = '$rename', text = '$retext' WHERE id = '$renum'";
                      $res = $link->query($sql);
                      $message2="編集に成功しました。";
                      $smarty->assign('message2', "編集に成功しました。");
                      $smarty->clearAllCache();

                    }
                    else {
                      $message2="編集に失敗しました。パスワードが間違っています。";
                      $smarty->assign('message2', "編集に失敗しました。パスワードが間違っています。");
                    }
                  }
                if ($message2 === '') {
                  $smarty->assign('message2', "編集に失敗しました。編集番号が一致しませんでした。");
                }
            }
          }
        }
        // 消去フォーム
        $err_msg6 = "";
        $err_msg8 = "";
        $message3="";
        $delete   = ( isset( $_POST["delnum"] )   === true ) ? $_POST["delnum"]   : "";
        $pass3del = ( isset( $_POST["pass3del"] ) === true ) ? $_POST["pass3del"] : "";



        if ( isset($_POST["delete"] ) ===  true ) {
          if ( $delete   === "")  $err_msg6 = "番号を入力してください";
          if ( $pass3del === "")  $err_msg8 = "パスワードを入力してください";

          if ( $delete   === "")  $smarty->assign('err_msg6', "番号を入力してください");
          if ( $pass3del === "")  $smarty->assign('err_msg8', "パスワードを入力してください");

          if ( ($err_msg6 === "") && ($err_msg8 === "") ) {
            foreach( $data as $key => $val ){
              if ( $val['id'] !== $delete ) {
              }
              else {
                if ($val['password'] === $pass3del) {
                  // ここに書き変えのコードを書く
                  $sql = "DELETE FROM board WHERE id = '$delete'";
                  $res = $link->query($sql);
                  $message3 = $delete . "番の消去に成功しました。";
                  $smarty->assign('message3', $delete . "番の消去に成功しました。");
                  $smarty->clearAllCache();

                }
                else {
                  $err_msg8 = $delete . "番の消去に失敗しました。パスワードが間違っています。";
                  $smarty->assign('err_msg8', $delete . "番の消去に失敗しました。パスワードが間違っています。");
                }
              }
            }

            if ( ($message3 === '') && ($err_msg8 === '') ) {
              $err_msg6 = $delete . '番に一致するものを見つけられませんでした。';
              $smarty->assign('err_msg6', $delete . "番に一致するものを見つけられませんでした。");
            }
          }
         }

    } else {
        echo "データベースの接続に失敗しました";
    }


    // $smarty = new Smarty;
    //
    // $smarty->caching = 1; // 生存時間はキャッシュご
    // $smarty->caching = true;
    // $smarty->cache_dir = './cache/';
    // $smarty->cache_lifetime = 1800;
    // $smarty->display('cache.tpl');


    if ($row['id'] === "") {
        echo "投稿がありません";
    } else {
      $sql = "SELECT  * FROM board ORDER BY id;";
      $stmt = $pdo->prepare($sql);
      $stmt -> execute();
      // foreach( $data as $key => $val ){
      // echo $val['id'] . ' '  . $val['name'] . ' ' . $val['text'] . ' ' . $val['date'] . '<br>';

    $values = array();
    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
      // echo ($row["id"]."<br/>");
      // 動画と画像で場合分け
      $target = $row["fname"];
      if($row["extension"] == "mp4"){
        $mp4=($row["id"].' ' . $row['name'] . ' ' . $row['text'] . ' ' . $row['date'] . "<br/>".
        "<video src=\"import_media.php?target=$target\" width=\"426\" height=\"240\" controls></video>". "<br/>");
        array_push($values,$mp4);
      }
      elseif($row["extension"] == "jpeg" || $row["extension"] == "png" || $row["extension"] == "gif"){
        $mp3=($row["id"].' ' . $row['name'] . ' ' . $row['text'] . ' ' . $row['date'] . "<br/>".
        "<img src='import_media.php?target=$target'>". "<br/>");
        array_push($values,$mp3);
      }
      else{
        $textonly=($row["id"].' ' . $row['name'] . ' ' . $row['text'] . ' ' . $row['date'] . "<br/>");
        array_push($values, $textonly);
    }
  }

  $sql = "SELECT  * FROM board ORDER BY id;";
  $stmt = $pdo->prepare($sql);
  $stmt -> execute();
  $count2=$stmt->rowCount();
  // echo $count;

  $count=count($values);

  $smarty->cache_dir = './cache/';
  $smarty->assign("values",$values);
  // $smarty->compile_check  = true;
  $chache_id = $count;
    $smarty-> assign('count2',$count2);
    $smarty-> assign('chache_id',$chache_id);
            // $smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
            // $smarty->display("kadai4.tpl", $chache_id);


  // if ($count2 == $chache_id) {
    $smarty->caching = 1;
      $smarty->display("kadai4.tpl", $chache_id);
   // }






  //
  // $smarty->assign("values",$values);
  // $smarty->caching = 1;
  // $smarty->compile_check  = true;
  // $smarty->cache_dir = './cache/';
  // $smarty->display("kadai4.tpl");







       }




?>
