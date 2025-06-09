<?php
$con = mysqli_connect(
    "shortline.proxy.rlwy.net", // Host
    "root",                     // Username
    "jXnqIAPTrAokFkzTaQeEuZUzesgaobaa", // Password
    "railway",                  // Database
    13306                       // Port
);

if (mysqli_connect_errno()) {
    echo "Connection Fail: " . mysqli_connect_error();
}
?>
