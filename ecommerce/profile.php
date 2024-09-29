<?php
$title = "My Account";
include_once "layout/header.php";
include_once "app/middleware/auth.php";
include_once "app/models/user.php";
$userobj = new user;
$userobj->setEmail($_SESSION['user']->email);
$got = $userobj->get_user_by_email();
$user = $got->fetch_object();

if($_POST){
    // print_r($_SESSION['user']);
    // validation 
    $errors=[];
    if (isset($_POST['update-profile'])){
        if (empty($_POST['name'])||empty($_POST['phone'])||empty($_POST['gender'])){
            $errors['general'] = "<div class='alert alert-danger' > All fields are required </div>";
        }
    }
    if (empty($errors)){
        $userobj->setname($_POST["name"]);
        $userobj->setPhoneNo($_POST["phone"]);
        $userobj->setGender($_POST["gender"]);
        // print_r($userobj->getGender());
        $userobj->setUpdatedAt(date('Y-m-d H:i:s'));
        if($_FILES['image']['name']){
            // photo exists
            $maxsize = 10**6;
            $error_size = $maxsize / 10**6;
            // size
            if($_FILES['image']['size']>$maxsize){
                $errors['img_size'] = "<div class='alert alert-danger'> maximum size is {$error_size} mb  </div>";
            }
            // extension
            $available = ['jpg', 'png', 'jpeg'];
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            if(!in_array($extension, $available)){
                $errors['extension'] = '<div class="alert alert-danger"> undefined extension  </div>';
            }
            if(empty($errors)){
                // add to path
                $photo_name = uniqid().'.'.$extension;
                $photo_path = "../Admin_Panel/public/dist/img/$photo_name";
                move_uploaded_file($_FILES['image']['tmp_name'], $photo_path);
                $userobj->setImg($photo_name);
            }
        }
        if(empty($errors)){
            $is_updated = $userobj->update();
            if ($is_updated){
                $success = '<div class="alert alert-success">updated successfuly</div>';
            }
            $got = $userobj->get_user_by_email();
            $user = $got->fetch_object();
            $_SESSION['user'] = $user;
            // print_r($_SESSION['user']);
        }
        // print_r($user);
    }
}
include_once "layout/nav.php";
?>
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                            </div>
                            <div id="my-account-1" class="panel-collapse collapse show">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>My Account Information</h4>
                                            <h5>Your Personal Details</h5>
                                            <h5 class="text-center">
                                                <?php
                                                if(isset($errors)){
                                                    if(!empty($errors)){
                                                        foreach ($errors as $key => $error){
                                                            echo $error;
                                                        }
                                                    }
                                                } 
                                                if(isset($success)){
                                                    echo $success;
                                                }
                                                ?>
                                                
                                            </h5>
                                        </div>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-12 ">
                                                    <div class="row">
                                                        <div class="col-4 offset-4">
                                                            <img src="../Admin_Panel/public/dist/img/Users/<?= $user->img ?>" alt="" id="image" class="w-100 rounded-circle" style="cursor: pointer;">
                                                            <input type="file" name="image" id="file" class="d-none">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 mt-5">
                                                    <div class="billing-info">
                                                        <label>Name</label>
                                                        <input type="text" name="name" value="<?=$user->name ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-6 col-md-6 mt-5">
                                                    <div class="billing-info">
                                                        <label>Phone</label>
                                                        <input type="number" name="phone" value="<?=$user->phone ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label for="Gender"> Gender </label>
                                                        <select name="gender" id="Gender" class="form-control">
                                                            <option  value="male">Male</option>
                                                            <option  value="female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-btn">
                                                    <button type="submit" name="update-profile">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your password </a></h5>
                            </div>
                            <div id="my-account-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Change Password</h4>
                                            <h5>Your Password</h5>
                                        </div>
                                        <form  method="post">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Old Password</label>
                                                        <input type="password" name="old_password">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>New Password</label>
                                                        <input type="password" name="new_password">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Password Confirm</label>
                                                        <input type="password" name="password_confirmation">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-btn">
                                                    <button type="submit" name="update-password">Update Password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>3</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-3">Modify your address book entries </a></h5>
                            </div>
                            <div id="my-account-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Address Book Entries</h4>
                                        </div>
                                        <div class="entries-wrapper">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                    <div class="entries-info text-center">
                                                        <p>Farhana hayder (shuvo) </p>
                                                        <p>hastech </p>
                                                        <p> Road#1 , Block#c </p>
                                                        <p> Rampura. </p>
                                                        <p>Dhaka </p>
                                                        <p>Bangladesh </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                    <div class="entries-edit-delete text-center">
                                                        <a class="edit" href="#">Edit</a>
                                                        <a href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-back">
                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                            </div>
                                            <div class="billing-btn">
                                                <button type="submit">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>4</span> <a href="wishlist.html">Modify your wish list </a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- my account end -->

<?php
include_once "layout/footer.php";
include_once "layout/footerScriptes.php";
?>
<script>
    // document.getElementById('image').onclick(function(){
    //     document.getElementById('file').click();
    // });
    $('#image').on('click', function() {
        $('#file').click();
    });
</script>