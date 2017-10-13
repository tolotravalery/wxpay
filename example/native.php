<?php
session_start();
ini_set('date.timezone', 'Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.NativePay.php";
require_once 'log.php';
require_once '../lib/WxPay.Notify.php';
//模式一
/**
 * 流程：
 * 1、组装包含支付信息的url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
 * 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
 * 5、支付完成之后，微信服务器会通知支付成功
 * 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$notify = new NativePay();
$url1 = $notify->GetPrePayUrl("123456789");

//模式二
/**
 * 流程：
 * 1、调用统一下单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$input = new WxPayUnifiedOrder();
$input->SetBody("ULTRAVIOLET");
if (isset($_GET['id_booking'])) {
    $booking_id = $_GET['id_booking'];
    $_SESSION['booking_id'] = $booking_id;
    $input->SetAttach($booking_id);
} else
    $input->SetAttach("1375");
if (isset($_GET['amount'])) {
    $input->SetTotal_fee($_GET['amount']);
    $_SESSION['amount'] = $_GET['amount'];
} else
    $input->SetTotal_fee("1");
$input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("UV");
$input->SetNotify_url("http://uvbypp-mmbund-payments.com/wxpay/example/notify.php");
$input->SetTrade_type("NATIVE");
$input->SetProduct_id("123456789");
$result = $notify->GetPayUrl($input);
$url2 = $result["code_url"];
//var_dump($result);
$logHandler = new CLogFileHandler("../logs/" . date('Y-m-d') . '.log');
$log = Log::Init($logHandler, 15);
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
    <title>微信支付样例-退款</title>
</head>
<body>
<header>
    <nav id="background" class="navbar navbar-default navbar-static-top ">
        <div class="container">
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
<section>
    <div class="container">
        <div class="row information">
            <div class="col-md-6 col-xs-12">
                <p><label>Order number :</label> <?php echo $_SESSION['booking_id'] ?></p>
            </div>
            <div class="col-md-6 col-xs-12 ">
                <p class="text-left-xs text-left-sm text-right-md"><label>Total Price
                        : </label> <?php echo $_SESSION['amount'] ?>
                <p>
            </div>
        </div>
        <hr class="separate">
    </div>
</section>
<section>
    <div class="container" id="container">
        <div class="bg-custom">
            <div class="row">
                <div class="col-md-6 col-xs-12 text-center-md text-center-xs">
                    <img src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($url2); ?>"
                         class="img-thumbnail qrcod" width="304" height="236">
                    <img src="../assets/img/communicate.png" class="img-thumbnail communicate" width="304" height="236">
                </div>


                <div class="col-md-6 col-xs-12 text-center-md text-center-xs">
                    <img src="../assets/img/phone.png" class="img-thumbnail" width="400" height="236">
                </div>
            </div>

            <div class="col-md-6">
                <!--                <a href="#"> < Return</a>-->
            </div>
        </div>
    </div>
</section>

<footer id="footer">
    <div class="container">
        <hr class="divider">
        <p class="text-center">Copyright © Ultraviolet 2017
        <p>

    </div>
</footer>

<?php
$mysqli = new mysqli("localhost", "trusty", "trustylabs07", "payments");
$sql = "SELECT COUNT(*) AS NOMBRE FROM wechat";
$result = $mysqli->query($sql);
//var_dump(mysqli_fetch_array($result));
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$nombre = $row['NOMBRE'];
?>
<script type="text/javascript">
    var nombre = parseInt(<?php echo $nombre; ?>);
    setInterval(checkNumber, 1000);
    console.log('nombre', nombre);
    function checkNumber() {
        $.ajax({
                url: 'test.php',
                type: 'GET',
                success: function (data) {
//                    console.log(data);
                    var newNomber = parseInt(data);
                    console.log('new_nombre', newNomber);
                    if (nombre < newNomber) {
                        var booking_id;
                        var booking_id_session = <?php echo $_SESSION['booking_id']; ?>;
                        var success;
//                        console.log('booking_id_session', booking_id_session);
                        $.ajax({
                            url: 'getBookingId.php',
                            type: 'GET',
                            success: function (dataBooking) {
//                                console.log('booking_id', dataBooking);
                                booking_id = dataBooking.split('|')[0];
                                success = dataBooking.split('|')[1];
                                if (booking_id == booking_id_session) {
                                    if (success == 'SUCCESS') {
                                        console.log('redirecting suceess');
                                        $('#container').html($('#container').load('success.php #success'))
                                    } else {
                                        console.log('redirecting error');
                                        $('#container').html($('#container').load('success.php #failed'))
                                    }
                                }
                            }
                        });
                    }
                }
            }
        );
    }
</script>
</body>
</html>