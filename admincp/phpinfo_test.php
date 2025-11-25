<?php
echo "PHP Version: " . phpversion() . "<br>";
echo "post_max_size: " . ini_get('post_max_size') . "<br>";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "max_file_uploads: " . ini_get('max_file_uploads') . "<br>";
echo "memory_limit: " . ini_get('memory_limit') . "<br>";
echo "max_execution_time: " . ini_get('max_execution_time') . "<br>";

echo "<hr>";
echo "POST data:<br>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

echo "FILES data:<br>";
echo "<pre>";
print_r($_FILES);
echo "</pre>";
?>
