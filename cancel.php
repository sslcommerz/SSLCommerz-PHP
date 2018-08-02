<?php
if($_POST['tran_id'])
{
        include("connection.php");
        $tran_id = trim($_POST['tran_id']);
        $sql = "select * from orders WHERE transaction_id='".$tran_id."'";
        $result = $conn_integration->query($sql);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if($row['status'] == 'Pending') 
        {
                $sql = "UPDATE orders SET status='Canceled' WHERE transaction_id='$tran_id'";

                if ($conn_integration->query($sql) === TRUE) 
                {
                    echo "This order is updated as Canceled";
                } 
                else 
                {
                    echo "Error updating record: " . $conn_integration->error;
                }          
           
        }
        else if($row['status'] == 'Success') 
        {
                echo "This order is already successfull";
        }
	    else
	    {

	        echo "Invalid Information";
	    }   

    }
    else
    {

        echo "Invalid Information";
    }    

?>