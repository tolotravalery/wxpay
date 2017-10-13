<?php
$mysqli = new mysqli("localhost", "trusty", "trustylabs07", "payments");
$sql = "select booking_id,return_code from wechat order by id desc limit 1;";
$result = $mysqli->query($sql);
//var_dump(mysqli_fetch_array($result));
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$booking_id = $row['booking_id'];
$return_code = $row['return_code'];
echo $booking_id . "|" . $return_code;
?>