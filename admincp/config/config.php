<?php
$mysqli = new mysqli("o3iyl77734b9n3tg.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "qpd8l97yha3kmm0y", "on8kor6fvgjukajv", "vdgpk50m2yvb0v8o", 3306);

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
?>
