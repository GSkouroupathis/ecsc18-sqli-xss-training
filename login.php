<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Login</title>

<style>
body {
 background-color: #444;
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

</style>
  </head>
  <body>

<?php
function write_html() {
 echo '<p class="warning" style="padding:4%";>Incorrect key!</p>
</body>
</html>
 ';
}

define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'guestbook_db');
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if($_SERVER["REQUEST_METHOD"] == "POST") {
 $key = $_POST['key'];
 $key = mysqli_real_escape_string($db, $key);
 $sql = "SELECT ukey FROM user_keys WHERE ukey = '$key';";
 $result = mysqli_query($db, $sql);
 $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
 if (is_null($row) || sizeof($row) == 0) {
   write_html();
  exit();
 }

$key = $row['ukey'];

$sql = "SELECT username FROM users WHERE ukey='$key';";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$username = $row['username'];

// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 87000);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(87000);

session_start();
$_SESSION["username"] = $username;

echo '<script>window.location.replace("/guestbook.php")</script>';

}

?>
  </body>
</html>
