<?php
ob_start();
// session_save_path(__DIR__ . "/../../TenantLayer/storage/framework/sessions");
session_start();
// -----fetch user----
$host = $_SERVER['HTTP_HOST'];
$subdomain = explode('.', $host)[0];
if (isset($_COOKIE['code_value'])) {
    include __DIR__ . "\\..\\app\\models\\user.php";
    $user->setrem_me($_COOKIE["code_value"]);
    $got_user_by_rm = $user->get_user_by_rm();
    $fetched = $got_user_by_rm->fetch_object();
    $_SESSION['user'] = $fetched;
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= $title ?></title>
    <meta name="description" content="">
    <meta name="robots" content="noindex, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <!-- all css here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/chosen.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <?php isset($links) ? $links : "" ?>
    <style>
        .main-menu nav>ul>li>ul.mega-menu>li {
            /* max-width: 300px !important; */
            display: flex;
        }

        .main-menu nav>ul>li>ul.mega-menu {
            display: grid;
            grid-template-columns: auto auto auto auto;
            gap: 20px 0px;
        }
    </style>
</head>