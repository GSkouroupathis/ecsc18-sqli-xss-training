<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Logout</title>

  </head>
  <body>

<?php

if(isset($_COOKIE[session_name()])):
  setcookie(session_name(), '', time()-1, '/');
  session_destroy();
endif;

header('Location: index.php');

?>
  </body>
</html>
