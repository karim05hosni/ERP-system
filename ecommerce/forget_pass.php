<?php
include_once "layout/header.php";
include __DIR__ . "\\app\\requests\\validation.php";
include __DIR__ . "\\app\\middleware\\guest.php";
include __DIR__ . "\\app\\models\\user.php";
include __DIR__ . "\\app\\sevices\\mail.php";

if ($_POST) {
    // validation
    // $errors = [];
    // // -------email_validation--------
    // $emailValidation = new validation('email', $_POST['email']);
    // // session to use values in login
    // $errors['email-req'] = $emailValidation->required();
    // if ($errors['email-req'] == '') {
    //     // $email_regex = $emailValidation->regex('');
    // }


    // if (empty($errors)) {
        // search in DB
        $user = new user;
        $user->setEmail($_POST['email']);
        $chk_email = $user->get_user_by_email();
        if ($chk_email) {
            // if email is correct
            // ----generate_code----
            $code = rand(10000, 99999);
            $user->setCode($code);
            // update code in DB
            $is_updated_db = $user->updatecode();
            if ($is_updated_db) {
                // if code updated in DB
                // send code to user
                $subject = "Forget password";
                $message = "<div>Hello, there is your code:$code</div>";
                $mail = new mail($_POST['email'], $subject, $message);
                $is_sent = $mail->send();
                if ($is_sent) {
                    $_SESSION['email'] = $_POST['email'];
                    header('location:verify.php?page=forget-pass');
                } else {
                    echo 'try again';
                }
            } else {
                echo 'something went wrong';
            }
        } else {
            echo 'email not exists';
        }
    }
// }
?>


<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> Enter your email </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                        <input type="email" name="email" placeholder="email">
                                        <button >submit</button>
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