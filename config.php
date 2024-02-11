<?php
$conn = mysqli_connect("localhost","root","","quiz");
if(mysqli_connect_errno()){
    echo "Connection Failed".mysqli_connect_error();
    exit;
}
?>
