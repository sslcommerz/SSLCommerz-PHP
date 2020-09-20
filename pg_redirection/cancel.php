<!-- 
    ######
    # THIS FILE IS ONLY AN EXAMPLE. PLEASE MODIFY AS REQUIRED.
    # Contributor: Md. Rakibul Islam <rakibul.islam@sslwireless.com>
    ######
 -->

<!DOCTYPE html>

<head>
    <meta name="author" content="SSLCommerz">
    <title>Transaction Failed - SSLCommerz</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row" style="margin-top: 10%;">
            <div class="col-md-8 offset-md-2">
                <?php
                // First check if the POST request is real!
                if (empty($_POST['tran_id']) || empty($_POST['status'])) {
                    echo '<h2 class="text-center text-danger">Invalid Information.</h2>';
                    exit;
                }

                // Connect to database after confirming the request
                include(__DIR__ . "/../db_connection.php");
                include(__DIR__ . "/../OrderTransaction.php");

                $tran_id = trim($_POST['tran_id']);
                $ot = new OrderTransaction();
                $sql = $ot->getRecordQuery($tran_id);
                $result = $conn_integration->query($sql);
                $row = $result->fetch_array(MYSQLI_ASSOC);

                if ($row['status'] == 'Pending' || $row['status'] == 'Canceled') :
                    $sql = $ot->updateTransactionQuery($tran_id, 'Canceled');

                    if ($conn_integration->query($sql) === TRUE) :
                ?>
                        <h2 class="text-center text-danger">Transaction has been CANCELLED.</h2>
                        <br>

                        <table border="1" class="table table-striped">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th colspan="2">Payment Details</th>
                                </tr>
                            </thead>
                            <tr>
                                <td class="text-right">Description</td>
                                <td><?php echo $_POST['error'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-right">Transaction ID</td>
                                <td><?php echo $_POST['tran_id'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-right"><b>Amount: </b></td>
                                <td><?php echo $_POST['amount'] . ' ' . $_POST['currency'] ?></td>
                            </tr>
                        </table>
                    <?php else : ?>
                        <h2 class="text-center text-danger">Error updating record: </h2>" <?= $conn_integration->error; ?>
                    <?php endif; ?>
                <?php elseif ($row['status'] == 'Processing') : ?>
                    <table border="1" class="table table-striped">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th colspan="2">Payment Details</th>
                            </tr>
                        </thead>
                        <tr>
                            <td class="text-right">Transaction ID</td>
                            <td><?= $_POST['tran_id'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-right">Transaction Time</td>
                            <td><?= $_POST['tran_date'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-right">Payment Method</td>
                            <td><?= $_POST['card_issuer'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-right">Bank Transaction ID</td>
                            <td><?= $_POST['bank_tran_id'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-right">Amount</td>
                            <td><?= $_POST['amount'] . ' ' . $_POST['currency'] ?></td>
                        </tr>
                    </table>
                <?php else : ?>
                    <h2 class="text-center text-danger">Invalid Information.</h2>
                <?php endif ?>
            </div>
        </div>
    </div>
</body>