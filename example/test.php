<!--<h3>Payment succes</h3>
<p>Congratulation!</p>
<p>Votre payment est succès</p>-->
<!--<p>Transaction id : --><?php //$_GET['transaction_id'] ?><!--</p>-->
<?php
$mysqli = new mysqli("localhost", "trusty", "trustylabs07", "payments");
$sql = "SELECT COUNT(*) AS NOMBRE FROM wechat";
$nombre = $mysqli->query($sql);
echo $nombre;
?>