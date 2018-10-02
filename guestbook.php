<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Guestbook</title>

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

#guestbook-div {
 background-color: #FFF4F6;
 width: 80%;
 margin: 0 auto 0 auto;
 padding: 5%;
 clear: both;
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

textarea {
width: 100%;
}

.warning {
  color: #EEE;
  font-size: 30px;
}

a:link, a:visited {
 color: #D74534;
}

a:hover {
 color: #F52703;
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
  <div id="menu">
    <span class="menuspan"><?php ini_set('session.gc_maxlifetime', 87000); session_set_cookie_params(87000);session_start();
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
      echo $_SESSION["username"];
    }
    ?> <a href="/logout.php">Logout</a></span>
  </div>

<?php
function write_html() {
 echo '<p class="warning" style="padding:4%;">Must log in to view guestbook!</p>
</body>
</html>
 ';
}

if(! isset($_SESSION["username"])) {
  echo $_SESSION["username"];
  write_html();
  exit();
}
?>
  <div id="ate">
  <div id="guestbook-div">
   <marquee style="font-size:250%">&#128031;</marquee>
   <h2>Please leave your comment</h2>
   <h4>Comments:</h4>
   <hr />

<?php

define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'guestbook_db');
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $comment = $_POST['comment'];
  $comment = mysqli_real_escape_string($db, $comment);
  $sessionUsername = $_SESSION["username"];
  $sql = "INSERT INTO comments(username, text) VALUES('$sessionUsername', '$comment');";
  $result = mysqli_query($db, $sql);
}


 $sql = "SELECT * FROM comments;";
 $result = mysqli_query($db, $sql);
 while ($row = mysqli_fetch_array($result)) {

  printf("\n");
  printf('   <div class="comment-container">');
  printf('    <div class="comment-username">');
  printf('%s said:', $row['username']);
  printf('    </div>');
  printf('    <div class="comment-text">');
  printf('%s', $row['text']);
  printf('    </div>');
  printf('   </div>');
  printf("\n");
 }

?>
   <hr />
   <form action ="/guestbook.php" method="POST">
    <textarea rows="4" cols="50" name="comment">
    Comment goes here
    </textarea>
    <input type="submit" value="Leave comment" />
   </form>
 </div>
</div>
  </body>
</html>
