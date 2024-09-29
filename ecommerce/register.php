<?php
$title = "register";
include_once "layout/header.php";
include_once "app/middleware/guest.php";
include_once "layout/nav.php";
include_once "layout/breadcrumb.php";
include_once __DIR__ ."\\app\\requests\\validation.php";
include_once __DIR__ ."\\app\\models\\user.php";
include_once __DIR__."\\app\\sevices\\mail.php";

if ($_POST){
    $success = [];
    // -----first_name validation------
    $fn_validation = new validation('name', $_POST['name']);
    $fn_req = $fn_validation->required();
    if (empty($fn_req)) {
        $success['fn']=1;
    }

    // -----last_name validation------
    // $ln_validation = new validation('last_name', $_POST['last-name']);
    // $ln_req = $ln_validation->required();
    // if (empty($ln_req)) {
    //     $success['ln']=2;
    // }
    // -----email_validation------
    $email_validation = new Validation('email', $_POST['user-email']);
    $email_req = $email_validation->required();
    if (empty($email_req)) {
        // $email_regex = $email_validation->regex('');
        $email_unique = $email_validation->unique('users');
    echo 'ssssss';

        if (empty($email_unique)) {
            $success['email']=3;
        }
    }
    // -----password_validation-----
    $pass_validation = new Validation('pass', $_POST['user-password']);
    $pass_req = $pass_validation->required();
    if (empty($pass_req)) {
        // $pass_regex = $pass_validation->regex('');
        $pass_confirm = $pass_validation->confirm($_POST['confirm-password']);
        if (empty($pass_confirm)) {
            $success['pass']=4;
        }
    }
    // -----phone_validation-----
    $phone_validation = new validation('phone', $_POST['phone']);
    $phone_req = $phone_validation->required();
    if (empty($phone_req)) {
        $phone_unique = $phone_validation->unique('users');

        if (empty($phone_unique)) {
            $success['phone']=5;
        }
    }
    if (isset($success['phone'])&&isset($success['fn'])&&isset($success['email'])&&isset($success['pass'])){
        // No errors
        $userObj = new user;
        // print_r($_POST);
        $userObj->setName($_POST['name']);
        $userObj->setEmail($_POST['user-email']);
        $userObj->setPhoneNo($_POST['phone']);
        $userObj->setPassword($_POST['user-password']);
        $userObj->setGender($_POST['user-gender']);
        $userObj->setCreatedAt(date('Y-m-d H:i:s'));
        $userObj->setUpdatedAt(date('Y-m-d H:i:s'));
        $code = rand(10000, 99999);
        $userObj->setCode($code);
        $result = $userObj->creat();
        try {
            if ($result) {
                echo 'insert-ed';
                $subject = 'verify';
                $message = "HELLO {$_POST['name']},<br>this is your verification code:$code</br>";
                $mail = new mail($_POST['user-email'],$subject, $message);
                $mail_result= $mail->send();
                if ($mail_result) {
                    $_SESSION['email'] = $_POST['user-email'];
                    header('location:verify.php?page=register');die;
                } else {
                    echo 'something went wrong';
                }
            }
        }  catch (Exception $e) {
            echo $e;
        }
        echo $email_unique;
        echo $phone_unique;
    }
}
?>

<div class="login-register-area ptb-100 reg">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a data-toggle="active" href="#lg2">
                            <h4> register </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg2" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form  method="post">
                                        <input
                                            type="text" name="name"
                                            placeholder="name" 
                                            value="<?= isset($_POST['name']) ? $_POST['name'] : ''; ?>" 
                                            class="mb-10"
                                        >
                                        <?php if(isset($fn_req)) {echo $fn_req;} ?>
                                        <input 
                                            name="user-email" placeholder="Email" 
                                            type="email"
                                            value="<?= isset($_POST['user-email']) ? $_POST['user-email'] : ''; ?>"
                                        >
                                        <?php if(isset($email_req) ) { echo $email_req;}?>

                                        <?= empty($email_unique) ? "" : "<div class='alert alert-danger'>$email_unique</div>" ; ?>
                                        <input 
                                            type="password" name="user-password"
                                            placeholder="Password" class="mb-10">
                                        <?php if(isset($pass_req) ) { echo $pass_req;}?>

                                        <input
                                            type="password" name="confirm-password" 
                                            placeholder="confirm Password" class="mb-10">
                                        <?php if(isset($pass_confirm) ) { echo $pass_confirm;}?>

                                        <input name="phone" type="number"  
                                            placeholder="phone no." class="mb-10"
                                            value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];}?>">
                                        <?php if(isset($phone_req) ) { echo $phone_req;}?>

                                        <?= empty($phone_unique) ? "" : "<div class='alert alert-danger'>$phone_unique</div>" ; ?>

                                        <select name="user-gender" id="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        <div class="button-box mt-5">
                                            <button type="submit"><span>Register</span></button>
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
<style>
</style>

<!-- all js here -->
<?php include_once __DIR__."\\layout\\footerScriptes.php";
?>
</body>

</html>
