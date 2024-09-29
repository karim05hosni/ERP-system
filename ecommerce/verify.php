<?php
session_start();
include_once __DIR__ . "\\app\\models\\user.php";
include __DIR__ . "\\app\\middleware\\guest.php";
if($_GET){
    // echo 'ssssssssssssssssssssssssssssssssss';
    if($_GET['page']){
        if ($_GET['page'] == 'forget-pass' || $_GET['page'] == 'register'){
            if ($_POST) {
                // validation
                $errors = [];
                if (empty($_POST['verify'])) {
                    $errors['chk'] = "<div>enter verify code</div>";
                } else if (intval($_POST["verify"]) == 0) {
                    $errors["chk_data"] = "your code is only numbers";
                } else if (strlen($_POST["verify"]) != 5) {
                    $errors["chk_len"] = "code is 5 digits";
                } else if (intval($_POST["verify"]) < 10000 || intval($_POST["verify"]) > 99999) {
                    $errors["chk_range"] = "invalid";
                }
                if (empty($errors)) {
                    $userobj = new user;
                        if (!isset($_SESSION['email'])) {
                            $userobj->setEmail($_SESSION['email_from_login']);
                        } else {
                            $userobj->setEmail($_SESSION['email']);
                        }
                    $userobj->setCode($_POST['verify']);
                    $v = $userobj->verifyCode();
                    if ($v) {
                        date_default_timezone_set('Africa/Cairo');
                        $userobj->setEmailVerifiedAt(date('Y-m-d H:i:s'));
                        $userobj->setStatus(1);
                        $verifiedUser = $userobj->verifyUser();
                        if ($verifiedUser) {
                            echo 'sssss';
                            $page='';
                            if ($_GET['page']=='register'){
                                unset($_SESSION['email']);
                                $page = 'login.php';
                            } else if ($_GET['page']== 'forget-pass'){
                                $page = 'reset_pass.php';
                            }
                            // echo $_SESSION['email'];
                            header("location:$page?email={$_SESSION['email']}");
                            die;
                        }
                    } else {
                        echo 'wrong code';
                    }
                }
            }
        } //else {
//             header('location:layout/errors/404.php');
//         }
//     } else {
//         header('location:layout/errors/404.php');
//     }
// } else{
//     header('location:layout/errors/404.php');
}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Muli:wght@300;700&display=swap");

    * {
        box-sizing: border-box;
    }

    body {
        background-color: #fbfcfe;
        font-family: "Muli", sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        overflow: hidden;
        margin: 0;
    }

    .container {
        background-color: #fff;
        border: 3px #000 solid;
        border-radius: 10px;
        padding: 30px;
        max-width: 1000px;
        text-align: center;
    }

    .code-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 40px 0;
    }

    .code {
        border-radius: 5px;
        font-size: 75px;
        height: 120px;
        width: 300px;
        border: 1px solid #eee;
        margin: 1%;
        text-align: center;
        font-weight: 300;
        -moz-appearance: textfield;
    }

    .code::-webkit-inner-spin-button,
    .code::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .code:valid {
        border-color: #3498db;
        box-shadow: 0 10px 10px -5px rgba(0, 0, 0, 0.25);
    }

    .info {
        background-color: #eaeaea;
        display: inline-block;
        padding: 10px;
        line-height: 20px;
        max-width: 400px;
        color: #777;
        border-radius: 5px;
    }

    @media (max-width: 800px) {
        .code-container {
            flex-wrap: wrap;
        }

        .code {
            font-size: 50px;
            height: 70px;
            max-width: 300px;
        }
    }
</style>

<body>
    <form action="" method="post">
        <div class="container">
            <h2>Verify Your Account</h2>
            <p>
                We emailed you the six digit code to cool_guy@email.com <br />
                Enter the code below to confirm your email address.
            </p>
            <div class="code-container">
                <input name="verify" type="number" class="code" placeholder="0 0 0 0 0" />
            </div>
            <?php
            // Display errors to user
            if (isset($errors)) {
                if ($errors) {
                    foreach ($errors as $key => $message) {
                        echo $message;
                    }
                }
            }
            ?>
            <button>Verify</button>
        </div>
    </form>
</body>

</html>