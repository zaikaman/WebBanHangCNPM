<?php
$mysqli = new mysqli("gtizpe105piw2gfq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "ayw5ins0ced93eo8", "h1tbx5lubhhx65r9", "kv0l93tcry5svq6w", 3306);

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
?>
