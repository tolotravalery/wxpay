<!--<h3>Payment succes</h3>
<p>Congratulation!</p>
<p>Votre payment est succès</p>-->
<!--<p>Transaction id : --><?php //$_GET['transaction_id'] ?><!--</p>-->
<?php
$mysqli = new mysqli("localhost", "trusty", "trustylabs07", "payments");
$sql = "SELECT COUNT(*) AS NOMBRE FROM wechat";
$result = $mysqli->query($sql);
//var_dump(mysqli_fetch_array($result));
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$nombre = $row['NOMBRE'];
echo $nombre;
?>