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
$input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
$input->SetTotal_fee("1");
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

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>微信支付样例-退款</title>
</head>
<body>
<!--	<div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫描支付模式一</div><br/>-->
<!--	<img alt="模式一扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=-->
<?php //echo urlencode($url1);?><!--" style="width:150px;height:150px;"/>-->
<!--	<br/><br/><br/>-->
<div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫描支付模式二</div>
<br/>
<img alt="模式二扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($url2); ?>"
     style="width:150px;height:150px;"/>

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
    setInterval(checkNumber, 3000);
    console.log('nombre', nombre);
    function checkNumber() {
        $.ajax({
                url: 'test.php',
                type: 'GET',
                success: function (data) {
                    console.log(data);
                    var newNomber = parseInt(data);
                    console.log('new_nombre', newNomber);
                    if (nombre < newNomber) {
                        var booking_id;
                        var booking_id_session = <?php echo $_SESSION['booking_id']; ?>;
                        console.log('booking_id_session', booking_id_session);
                        $.ajax({
                            url: 'getBookingId.php',
                            type: 'GET',
                            success: function (dataBooking) {
                                console.log('booking_id', dataBooking);
                                booking_id = dataBooking;
                                if (booking_id==booking_id_session) {
                                    alert('Payement ok');
                                    window.location.href = "test1.php";
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