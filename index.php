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

  <div id="ate">
  <div id="login-div">
   <h1>LOGIN using your KEY</h1>
   <h3>to continue to the guestbook</h3>
   <hr />
   <form action ="/login.php" method="POST">
    <input type="text" name="key" />
    <input type="submit" value="LOGIN"/>
   </form>
<p>
   <a href="/viewcomments.php">Search for comments</a> - <a href="/adminlogin.php">Admin Login</a>
</p>
</div>
</div>
  </body>
</html>
