<?php
$con = mysqli_connect("db", "root", "aerms", "aermsdb");  // host: db, user: root, password: aerms
if (mysqli_connect_errno()) {
    echo "Connection Fail: " . mysqli_connect_error();
}
?>
