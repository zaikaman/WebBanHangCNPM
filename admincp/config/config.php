<?php
$mysqli = new mysqli("ol5tz0yvwp930510.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "ot9yhdbg6jaf15t0", "u5loufopei3laxcr", "dj61lxep55zuk7bd", 3306);

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
?>
