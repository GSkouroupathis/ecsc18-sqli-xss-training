<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Login</title>

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

#login-div {
 background-color: #FFF4F6;
 width: 60%;
 height: 40%;
 margin: 10% auto 0 auto;
 padding: 5%;
}

.warning {
  color: #EEE;
  font-size: 30px;
}

#ate {
  width: 100%;
  margin-top: 5px;
  float: left;
  clear: both;
}

#login-div {
 background-color: #FFF4F6;
 width: 75%;
 height: 40%;
 margin: 5% auto 0 auto;
 padding: 5%;
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

a:link, a:visited {
 color: #D74534;
}

a:hover {
 color: #F52703;
}

</style>
</head>
<body>

<?php
function write_html() {
 echo '<p class="warning" style="padding:4%;">Incorrect key!</p>
</body>
</html>
 ';
 exit();
}

if($_SERVER["REQUEST_METHOD"] == "GET") {

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

<div id="ate">
<div id="login-div">
 <h1>LOGIN using your ADMIN KEY</h1>
 <h3>to continue to the guestbook</h3>
 <hr />
 <form action ="/adminlogin.php" method="POST">
  <input type="text" name="key" />
  <input type="submit" value="LOGIN"/>
 </form>
</div>
</div>';
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
 define('DB_SERVER', 'localhost:3306');
 define('DB_USERNAME', 'root');
 define('DB_PASSWORD', 'root');
 define('DB_DATABASE', 'guestbook_db');
 $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 $key = $_POST['key'];
 $key_hash = $hashed = hash('sha512', $key);
 $key_hash = substr($key_hash, 0, 65);

 $sql = "SELECT akey FROM admin_keys WHERE akey = '$key_hash';";
 $result = mysqli_query($db, $sql);
 $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
 if (is_null($row) || sizeof($row) == 0) {
   write_html();
   exit();
 }

$username = 'Admin';

// server should keep session data for AT LEAST 1 day
ini_set('session.gc_maxlifetime', 87000);

// each client should remember their session id for EXACTLY 1 day
session_set_cookie_params(87000);

session_start();
$_SESSION["username"] = $username;

echo '<script>window.location.replace("/guestbook.php")</script>';

}

?>
</body>
</html>
