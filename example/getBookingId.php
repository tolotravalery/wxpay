<?php
$mysqli = new mysqli("localhost", "trusty", "trustylabs07", "payments");
$sql = "select booking_id from wechat order by id desc limit 1;";
$result = $mysqli->query($sql);
//var_dump(mysqli_fetch_array($result));
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$booking_id = $row['booking_id'];
echo $booking_id;
?>