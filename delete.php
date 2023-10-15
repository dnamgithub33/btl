<?php
    session_start();
    if (!isset($_SESSION['user']))
        header("location: index.php?Message=Login To Continue");
    elseif ($_SESSION['user']!="admin")
        header("location: index.php?Message=You are not admin");
    include "dbconnect.php";
    $username = $_GET['uname'];
    $sql = "DELETE FROM users WHERE UserName='$username';";
    $got = mysqli_query($con, $sql);
    header("location:admin.php");
?>