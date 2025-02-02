<?php
//DBに接続
try {
$pdo = new PDO('mysql:dbname=recipe_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}
//データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM r_table ORDER BY id DESC");
$status = $stmt->execute();//降順
//データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $enc_img = base64_encode($result["upfile"]);
		try {
			$imginfo = @getimagesize('data:application/octet-stream;base64,' . $enc_img);
		} catch(Exception $e) {
			$imginfo = false;
		}
    $view .= '<div class="result">';
    $view .= '<h2>'.$result["name"].'</h2>';
    $view .= "<p>";
    if($imginfo){
      $view .= '<img src="data:' . $imginfo['mime'] . ';base64,'.$enc_img.'" style="width:400px;height:320px;">';
    }
    $view .= "</p>";
    $view .= '<p>【材料】<br>'.$result["material"].'</p>';
    $view .= '<p>【作り方】<br>'.$result["method"].'</p>';
    $view .= '<p>【メモ】<br>'.$result["memo"].'</p>';
    $view .= "</div>";
  }
}

//お肉のおかず
$stmt = $pdo->prepare("SELECT * FROM r_table WHERE junle = 'お肉のおかず'");
$status = $stmt->execute();

$view_meat="";
if($status==false){
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $enc_img = base64_encode($result["upfile"]);
		try {
			$imginfo = @getimagesize('data:application/octet-stream;base64,' . $enc_img);
		} catch(Exception $e) {
			$imginfo = false;
		}
    $view_meat .= '<div class="result">';
    $view_meat .= '<h2>'.$result["name"].'</h2>';
    $view_meat .= "<p>";
    if($imginfo){
      $view_meat .= '<img src="data:' . $imginfo['mime'] . ';base64,'.$enc_img.'" style="width:400px;height:320px;">';
    }
  
    $view_meat .= "</p>";
    $view_meat .= '<p>【材料】<br>'.$result["material"].'</p>';
    $view_meat .= '<p>【作り方】<br>'.$result["method"].'</p>';
    $view_meat .= '<p>【メモ】<br>'.$result["memo"].'</p>';
    $view_meat .= "</div>";
  }
}

//魚介のおかず
$stmt = $pdo->prepare("SELECT * FROM r_table WHERE junle = '魚介のおかず'");
$status = $stmt->execute();

$view_fish="";
if($status==false){
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $enc_img = base64_encode($result["upfile"]);
		try {
			$imginfo = @getimagesize('data:application/octet-stream;base64,' . $enc_img);
		} catch(Exception $e) {
			$imginfo = false;
		}
    $view_fish .= '<div class="result">';
    $view_fish .= '<h2>'.$result["name"].'</h2>';
    $view_fish .= "<p>";
    if($imginfo){
      $view_fish .= '<img src="data:' . $imginfo['mime'] . ';base64,'.$enc_img.'" style="width:400px;height:320px;">';
		}
    $view_fish .= "</p>";
    $view_fish .= '<p>【材料】<br>'.$result["material"].'</p>';
    $view_fish .= '<p>【作り方】<br>'.$result["method"].'</p>';
    $view_fish .= '<p>【メモ】<br>'.$result["memo"].'</p>';
    $view_fish .= "</div>";
  }
}

//副菜
$stmt = $pdo->prepare("SELECT * FROM r_table WHERE junle = '副菜'");
$status = $stmt->execute();

$view_sidedis="";
if($status==false){
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $enc_img = base64_encode($result["upfile"]);
		try {
			$imginfo = @getimagesize('data:application/octet-stream;base64,' . $enc_img);
		} catch(Exception $e) {
			$imginfo = false;
		}
    $view_sidedis .= '<div class="result">';
    $view_sidedis .= '<h2>'.$result["name"].'</h2>';
    $view_sidedis .= "<p>";
    if($imginfo){
      $view_sidedis .= '<img src="data:' . $imginfo['mime'] . ';base64,'.$enc_img.'" style="width:400px;height:320px;">';
		}
    $view_sidedis .= "</p>";
    $view_sidedis .= '<p>【材料】<br>'.$result["material"].'</p>';
    $view_sidedis .= '<p>【作り方】<br>'.$result["method"].'</p>';
    $view_sidedis .= '<p>【メモ】<br>'.$result["memo"].'</p>';
    $view_sidedis .= "</div>";
  }
}

?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>レシピ記録</title>
    <link href="style.css" rel="stylesheet">
</head>

<body>
<div class="wrap">

    <div class="header">
        <img src="top.jpg" class="top-img">
        <h1>recipe note</h1>
    </div>


    <div class="container">
        <div class="main">
        <?=$view?>
        </div>

        <div class="side">
          <ul class="menu">
            <li onclick="window.open('form.php')"><img src="pen.png" class="side-icon"><p>レシピ追加</p></li>
          </ul>

            <h2>レシピ検索</h2>
          <ul class="menu">
            <li id="meat"><img src="icon.png" class="side-icon"><p>お肉のおかず</p></li>
            <li id="fish"><img src="fish.png" class="side-icon"><p>お魚のおかず</p></li>
            <li id="sidedis"><img src="leaf.png" class="side-icon"><p>副菜</p></li>
          </ul>
      
            
        </div>
    </div>


</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>

$("h1").fadeIn(4000);

$('#meat').click(function() {
     $('.main').html('<?=$view_meat?>');
 });

 $('#fish').click(function() {
     $('.main').html('<?=$view_fish?>');
 });

 $('#sidedis').click(function() {
     $('.main').html('<?=$view_sidedis?>');
 });

</script>

</body>
</html>