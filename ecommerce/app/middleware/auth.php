<?php
// session_start();
// Guest
if(empty($_SESSION['user'])) {
    // prevent guest
    header("location:login.php");
}