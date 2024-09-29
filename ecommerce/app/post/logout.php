<?php
include __DIR__ . "\\..\\models\\user.php";
session_start();


// print_r($t->fetch_object());
if (isset($_COOKIE["code_value"])) {
    $del_user= new user;
    $del_user->setrem_me($_COOKIE["code_value"]);
    setcookie("code_value","", time() -2222,"/");
    $del_user->del_rem_code();
}
unset($_SESSION['user']);
header('location:../../login.php');
