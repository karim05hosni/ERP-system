<?php
include_once __DIR__ . "\\..\\app\\models\\category.php";
include_once __DIR__ . "\\..\\app\\models\\subcategory.php";
$category = new Category;
$read_categories = $category->read();
// print_r($fetched);
$sub_category = new SubCategory;

?>

<header class="header-area gray-bg clearfix">
    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="logo">
                        <h2>E-Shopping</h2>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-6">
                    <div class="header-bottom-right">
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li><a href="shop.php">shop</a></li>
                                    <li class="mega-menu-position top-hover"><a href="shop.php">categories</a>
                                        <ul class="mega-menu">
                                            <?php
                                            if ($read_categories) {
                                                $fetched_categories = $read_categories->fetch_all(MYSQLI_ASSOC);
                                                // print_r($fetched_categories);
                                                if ($fetched_categories) {
                                                    foreach ($fetched_categories as $key => $category) {
                                                        $sub_category->setid($category['id']);
                                                        // retrieve
                                                        $read_sub_categories = $sub_category->read();
                                                        if($read_sub_categories){
                                                        ?>

                                                        <li class="cate">
                                                            <ul>
                                                                <?php
                                                                // $sub_category->setquery("");
                                                                // print_r($read_sub_categories);
                                                                if (!empty($read_sub_categories->num_rows) && $read_sub_categories->num_rows > 0) {
                                                                // fetch
                                                                    ?>
                                                                    <li class="mega-menu-title"><?= $category['name_en'] ?></li><?php
                                                                    $fetch_sub_categories = $read_sub_categories->fetch_all(MYSQLI_ASSOC);
                                                                    if (isset($fetch_sub_categories)) {
                                                                        foreach ($fetch_sub_categories as $key => $value) {
                                                                            # code...
                                                                            ?>
                                                                            <li><a href="shop.php?sub=<?=$value['id']?>"><?= $value['name_en'] ?></a></li>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                // print_r($fetch_sub_categories);
                                                                // display
                                                                ?>
                                                            </ul>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="header-currency">
                            <?php
                            if (isset($_SESSION['user'])) {
                                // print_r($fetch_sub_categories);
                                ?>
                                <span
                                    class="digit"><?php echo $_SESSION['user']->name; ?>
                                    <i class="ti-angle-down"></i></span>
                                <div class="dollar-submenu">
                                    <ul>
                                        <li><a href="profile.php">Profile</a></li>
                                        <li><a href=app/post/logout.php>Logout</a></li>
                                    </ul>
                                </div>
                                <?php
                                ;
                            } else {
                                ?>
                                <span class="digit">Welcome<i class="ti-angle-down"></i></span>
                                <div class="dollar-submenu">
                                    <ul>
                                        <li><a href="login.php">login</a></li>
                                        <li><a href="register.php">register</a></li>
                                    </ul>
                                </div>
                                <?php ;
                            } ?>
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
        </div>
        <style>
            .logo > h2 {
                font-size: 30px;
                font-family: 'Work Sans', sans-serif;
                color: #519f10;
                font-weight: 500;
            }
        </style>
</header>