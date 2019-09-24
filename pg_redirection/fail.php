<?php

if ($_POST['tran_id']) {

    include(__DIR__ ."/../db_connection.php");
    include(__DIR__ . "/../OrderTransaction.php");

    $tran_id = trim($_POST['tran_id']);
    $query = new OrderTransaction();
    $sql = $query->getRecordQuery($tran_id);
    $result = $conn_integration->query($sql);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    if ($row['status'] == 'Pending') {
        $query = new OrderTransaction();
        $sql = $query->updateTransactionQuery($tran_id, 'Falied');

        if ($conn_integration->query($sql) === TRUE) {
            echo "This order is updated as Failed";
        } else {
            echo "Error updating record: " . $conn_integration->error;
        }

    } else if ($row['status'] == 'Success') {
        echo "This order is already successfull";
    } else {
        echo "Invalid Information";
    }

} else {

    echo "Invalid Information";
}

?>