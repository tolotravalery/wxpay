<?php
/**
 * Created by PhpStorm.
 * User: KOERA
 * Date: 12/10/2017
 * Time: 12:14
 */

$mysqli = new mysqli("localhost", "trusty", "trustylabs07", "payments");
$sql = "SELECT * FROM wechat";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - provider: " . $row["provider"]. " - booking id:" . $row["booking_id"]. " - amount:". $row["amount"] . " - return code:". $row["return_code"]."- return message:". $row["return_message"]." - tansaction:".$row['transaction_id']."<br>";
    }
} else {
    echo "0 results";
}
$mysqli->close();