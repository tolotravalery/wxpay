<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/mediaqueries.css">
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.css">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

</head>

<body>
<!-- header-start -->
<header>
    <nav id="background" class="navbar navbar-default navbar-static-top ">
        <div class="container ">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="../assets/img/alipay.png">
                </a>

                <a class="navbar-brand" href="#">
                    <img src="../assets/img/wechat.png">
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">

                <!--<ul class="nav navbar-nav navbar-right ">
                    <li><a href="#">USERNAME</a></li>
                    <li><a href="#">LOGOUT</a></li>
                </ul>-->

            </div>
        </div>
    </nav>
</header>
<!-- header-end -->

<!-- section start -->

<section>
    <div class="container">
        <div class="row information">
            <div class="col-md-6 col-xs-12">
                <p><label>Order number :</label> <?php echo $_SESSION['booking_id'] ?></p>
            </div>
            <div class="col-md-6 col-xs-12 ">
                <p class="text-left-xs text-left-sm text-right-md"><label>Total Price
                        : </label> <?php echo $_SESSION['amount']; ?>
                <p>
            </div>
        </div>
        <hr class="separate">
    </div>
</section>
<section>
    <div class="container" id="success">
        <div class="separated hidden-xs "></div>

        <div class="col-md-8 col-md-offset-2">
            <div class="bg-custom2">
                <div class="alert alert-success">
                    Payment successful !!.
                </div>
                <div class="row">
                    <!--<div class="col-md-6 col-md-offset-3 center">
                        <button type="button" class="btn btn-success btn-lg ">Confirm</button>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="failed">
        <div class="separated hidden-xs "></div>

        <div class="col-md-8 col-md-offset-2">
            <div class="bg-custom2">
                <div class="alert alert-warning">
                    Payment failed !!.
                </div>
                <div class="row">
                    <!--<div class="col-md-6 col-md-offset-3 center">
                        <button type="button" class="btn btn-success btn-lg ">Confirm</button>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>