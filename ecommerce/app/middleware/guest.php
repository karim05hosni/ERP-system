<?php 
if(!empty($_SESSION['user'])){
    // prevent authenticated user
    header("location:shop.php");
}