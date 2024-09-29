<?php 
include "layout/header.php";
include "app/requests/validation.php";
include __DIR__ . "\\app\\middleware\\guest.php";
include "app/models/user.php";
if ($_POST){
    $pass_validation = new Validation('pass', $_POST['password']);
    $pass_req = $pass_validation->required();
    if (empty($pass_req)) {
        // $pass_regex = $pass_validation->regex('');
        $pass_confirm = $pass_validation->confirm($_POST['confirm-pass']);
        if (empty($pass_confirm)) {
        }
    }

    if (empty($pass_req) && empty($pass_confirm)) {
        $user = new user;
        $user->setEmail($_GET['email']);
        $user->setPassword($_POST['password']);
        $is_updated = $user->updatepassword();
        if ($is_updated) {
            unset($_SESSION['email']);
            header('Refresh: 3;URL=login.php');
        } else {
            echo 'something went wrong';
        }
    }
}
?>


<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> Reset Password </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form  method="post">
                                        <?php
                                        if(isset($is_updated)){
                                            if ($is_updated){
                                                echo '<div class="alert alert-success">Your Password Updated Sucessfully</div>';
                                            }
                                        }
                                        ?>
                                        <input type="password" name="password" placeholder="Password">
                                        <input type="password" name="confirm-pass" placeholder="confirm password">
                                        <button>confirm</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
