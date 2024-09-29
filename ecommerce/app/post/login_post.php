<?php 
include __DIR__."\\..\\requests\\validation.php";
include __DIR__."\\..\\models\\user.php";
session_start();
if(!isset(($_POST['login']))){
    header('location:../../layout/errors/404.php');die;
}

$success = [];
// -------email_validation--------
$emailValidation = new validation('email',$_POST['email'] );
// session to use values in login
$_SESSION['emailReq'] =$emailValidation->required();
if($_SESSION['emailReq'] == ''){
    // $email_regex = $emailValidation->regex('');
    $success['email'] = '1';
}
// -----pass_validation-------
$passValidation = new validation('password',$_POST['password'] );
// session to use values in login
$_SESSION['passReq'] =  $passValidation->required();
if($_SESSION['passReq'] == ''){
    // $pass_regex = $passValidation->regex('');
    $success['password'] = '1';
}
if (!empty($_SESSION['emailReq']) || !empty($_SESSION['passReq']) ){
    header('location:../../login.php');die;
}
if (($success['email']) == '1' && ($success['password']) == '1') {
    $userObj = new User;
    $userObj->setEmail($_POST['email']) ;
    $userObj->setPassword($_POST['password']);
    $login = $userObj->login();
    if ($login){
        $info = $login->fetch_object();
        if ($info->status == 1){
            // verified user
            // store values to use in logout.php, profile.php, middleware
            if($_POST['remember_me']){
                // generate code in DB
                $userObj->generat_rem_me();
                $got_user_by_email=$userObj->get_user_by_email();
                $fetched = $got_user_by_email->fetch_object();
                $userObj->setrem_me($fetched->remember_token);
                setcookie("code_value",$fetched->remember_token, time()+ 60*24*60,"/");
                // set code in attribute
            //     $i = $userObj->get_user_by_rm()->fetch_object();
            //     print_r($i);
            //     $_SESSION['test'] = $i->rem_me;
            }
            $_SESSION['user'] = $info;
            header('location:../../shop.php');die;
        } else if ($info->status == 0){ // unverified user
            // session to use the values in verify.php
            $_SESSION['email_from_login'] = $_POST['email'];
            header('location:../../verify.php?page=register');die;
        }
    }else {
        // session to use values in login
        $_SESSION['wrong_login'] =  '<div class="alert alert-danger">wrong email or password</div>';
        header('location:../../login.php');
    }
}





