<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <title>Login | JoeyCo</title>
    <meta name="description" content="" />
    <!-- InstanceEndEditable -->
    <meta charset="UTF-8" />
    <meta content='IE=edge' http-equiv=X-UA-Compatible>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./assets/css/main.css">

    <link rel="apple-touch-icon" sizes="57x57" href="./favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="./favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#e36d29">
</head>

<body>
    <main id="main" class="page-login">
        <div class="pg-container container-fluid">
            <div class="row_1 align-items-top no-gutters justify-content-end">
                <!-- Login right column - [Start] -->
                <div class="inner full-h-min flexbox flex-center">
                    <div class="full-w">
                        <div id="logo" class="dp-table marginauto mb-20">
                            <img src="./assets/images/logo.jpg" alt="">
                        </div>
                        <div class="row no-gutters justify-content-center">
                            <div class="col-10 col-md-9 col-lg-5 col-xl-5">
                                <div class="hgroup divider-after align-center">
                                    <h2>Reset Password?</h2>
                                    <p class="f14">Please enter your email address to reset your password.</p>
                                </div>

                                <!-- Login Form -->
                                <form action="" id="login-form"  class="needs-validation" novalidate>
                                    <div class="form-group align-center">
                                        <label for="emailInput">Email / username</label>
                                        <input type="email" class="form-control form-control-lg" id="emailInput" required>
                                    </div>
                                    <div class="align-center">
                                        <button type="submit" disabled class="btn btn-primary submitButton">Reset Password</button>
                                    </div>
                                </form>
                                <div class="extra-info">
                                    <p class="forgot-pwd align-center"><a href="login.php">Back to login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Login right column - [/end] -->
            </div>
        </div>
    </main>
    <?php include('./includes/footer.php') ?>
</body>

<script src="./assets/js/jquery-3.0.0.js"></script>
<script src="./assets/js/jquery-migrate-3.3.2.js"></script>
<script src="./assets/js/bootstrap.js"></script>
<script src="./assets/js/main.js"></script>
</html>