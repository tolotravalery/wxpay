<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Backend</title>

    <!-- Bootstrap core CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="padding-top: 50px;">
<div class="container">
    <div class="row">
        <center>
            <h1>Welcome to Wechat payment Back end</h1>
        </center>
        <div class="panel panel-primary">
            <div class="panel-heading">Liste des payments</div>
            <div class="panel-body">
                <table class="table table-responsive">
                    <tr>
                        <th>ID</th>
                        <th>PROVIDER</th>
                        <th>BOOKING ID</th>
                        <th>AMOUNT</th>
                        <th>RETURN CODE</th>
                        <th>RETURN MESSAGE</th>
                        <th>TRANSACTION ID</th>
                    </tr>
                    <?php
                    $mysqli = new mysqli("localhost", "trusty", "trustylabs07", "payments");
                    $sql = "SELECT * FROM wechat";
                    $result = $mysqli->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["provider"]; ?></td>
                                <td><?php echo $row["booking_id"]; ?></td>
                                <td><?php echo $row["amount"]; ?></td>
                                <td><?php echo $row["return_code"]; ?></td>
                                <td><?php echo $row["return_message"]; ?></td>
                                <td><?php echo $row['transaction_id']; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    $mysqli->close();
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
        integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
        crossorigin="anonymous"></script>
</body>
</html>
