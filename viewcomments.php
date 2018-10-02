<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Search for comments</title>

<style>

html, body, body div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, abbr, address, cite, code, del, dfn, em, img, ins, kbd, q, samp, small, strong, sub, sup, var, b, i, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, figure, footer, header, hgroup, menu, nav, section, time, mark, audio, video {
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    font-size: 100%;
    vertical-align: baseline;
    background: transparent;
}

body {
 background: #444 url('imgs/bg1.png') repeat;
}

#ate {
  width: 100%;
  margin-top: 5px;
  float: left;
  clear: both;
}

a:link, a:visited {
 color: #D74534;
}

a:hover {
 color: #F52703;
}

.comment-container {
 width: 100%;
 background: red;
 padding: 0;
 margin: 1% 0 2% 0;
 border: 5px solid black;
 box-sizing: border-box;
float:left;
}

.comment-username {
box-sizing: border-box;
 width: 100%;
 float:left;
 background: black;
 color: white;
}

.comment-text {
box-sizing: border-box;
 width: 100%;
 padding: 1%;
 float: left;
 clear: both;
background:white;
}

marquee{
margin:0;
padding: 0;
}

hr {
clear:both;
}

.warning {
  color: #EEE;
  font-size: 30px;
}

p {
  color: white;
}

h3 {
  color: white;
}

#menu {
  margin: 0;
  width: 100%;
  height: 25px;
  padding-top: 10px;
  background: #FFF url('imgs/bg.png') repeat;
  float: left;
  clear:both;
  border-bottom: 1px solid red;
}

.menuspan {
  margin: 0 1%;
  float: right;
}

</style>
</head>
<body>

<?php

function write_html($extra) {

  echo '<div id="menu">
    <span class="menuspan">';
    ini_set('session.gc_maxlifetime', 87000);
    session_set_cookie_params(87000);
    session_start();

    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
      echo $_SESSION["username"];
    }
    echo '<a href="/logout.php">Logout</a></span>
  </div>
<div id="ate">';
echo $extra;
echo '<form action ="/viewcomments.php" method="POST">
<p>Seach for comments by username:</p>
 <input type="text" name="username" style="width:60%"/>
 <input type="submit" value="Search for comments" style="width:30%"/>
</form>
</div>
</body>
</html>';
}

define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'guestbook_db');
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if($_SERVER["REQUEST_METHOD"] == "POST") {

 $username = $_POST['username'];
 $sql = "SELECT username FROM users WHERE username = '$username';";
 echo "<p><h3>$sql</h3></p><br />";
 $result = mysqli_query($db, $sql);
 $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
 if (is_null($row) || sizeof($row) == 0) {
  write_html('');
  exit();
 }

 $username = $row['username'];

 $sql = "SELECT text FROM comments WHERE username = '$username';";
 echo "<p><h3>$sql</h3></p>";
 $result = mysqli_query($db, $sql);
 $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
 if (is_null($rows) || sizeof($rows) == 0) {
  echo '<p class="warning">No Comments found for user!</p>';
  write_html('');
  exit();
 }

 foreach ($rows as $key => $arr) {
  printf('   <div class="comment-container">');
  printf('    <div class="comment-text">');
  printf('%s', $arr['text']);
  printf('    </div>');
  printf('   </div>');
 }

 write_html('');

} else {
  write_html('');
}

mysqli_close($db);

?>
