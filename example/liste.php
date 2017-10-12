<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
          integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <h1>Welcome to Wechat payment Back end</h1>
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
