<?php
  $password_hash = $hashed = hash('sha512', 'aisISUaisud5@ias234');
  $password_hash = substr($password_hash, 0, 65);
echo $password_hash;
?>
