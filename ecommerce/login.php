<?php
// session_start();
$title = "login";
include_once "layout/header.php";
include_once "app/middleware/guest.php";
include_once "layout/nav.php";
include_once "layout/breadcrumb.php";
// print_r($_SESSION);
?>
<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> login </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="app/post/login_post.php" method="post">
                                        <input type="email" name="email" placeholder="email">
                                        <input type="password" name="password" placeholder="Password">
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input type="checkbox" name="remember_me">
                                                <label>Remember me</label>
                                                <a href="forget_pass.php">Forgot Password?</a>
                                            </div>
                                            <?php  
                                            unset($_SESSION['email_from_login']);
                                            foreach ($_SESSION as $key => $value) {
                                                # code...
                                                if ($key == 'user') {
                                                    continue;
                                                }
                                                echo $value;
                                            }
                                            
                                            
                                            ?>
                                            <button type="submit" name="login"><span>Login</span></button>
                                        </div>
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

<?php
include_once "layout/footer.php";
?>
<!-- all js here -->
<?php include_once __DIR__ . "\\layout\\footerScriptes.php";
?>