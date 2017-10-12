<?php
ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';

//初始化日志
$logHandler = new CLogFileHandler("../logs/" . date('Y-m-d') . '.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{

    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::DEBUG("query:" . json_encode($result));
        if (array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS"
        ) {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        $jsonData = json_encode($data);
        Log::DEBUG("call back:" . $jsonData);
        $notfiyOutput = json_decode($jsonData, true);

        if (!array_key_exists("transaction_id", $data)) {
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if (!$this->Queryorder($data["transaction_id"])) {
            $msg = "订单查询失败";
            return false;
        }
        $mysqli = new mysqli("localhost", "trusty", "trustylabs07", "payments");

        if ($mysqli->connect_error) {
            Log::DEBUG("connection error " . $mysqli->connect_error);
        }

        $stmt = $mysqli->prepare('INSERT INTO wechat(provider, booking_id, amount, return_code,return_message,transaction_id) VALUES (?,?,?,?,?,?)');
        $providers = 'uv';
        /* bind parameters for markers */
        $stmt->bind_param("sidsss", $providers, $notfiyOutput['attach'], $notfiyOutput['total_fee'], $notfiyOutput['return_code'], $notfiyOutput['return_msg'], $notfiyOutput['transaction_id']);

        /* execute query */
        $stmt->execute();
        Log::DEBUG("new record to database");
        /* close statement */
        $stmt->close();
//    }
        Log::DEBUG("before redirect");
        header('Location: http://uvbypp-mmbund-payments.com/wxpay/example/test.php');
        die();
        Log::DEBUG("after redirect");
        return true;
    }
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
