<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Paradise</title>
    <link rel="icon" href="img/logo.jpg">
     <!-- MDB -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
</head>
<body>
   <div class="container">
    <div class="text-center mt-3">
      <h2 class = "text-dark fw-bold">Subscription History</h2>
    </div>
    <table class="table table-dark mt-4" >
      <thead>
        <tr>
          <th scope="col">Plan Name</th>
          <th scope="col">Paid</th>
          <th scope="col">Access Content</th>
          <th scope="col">Date</th>
        </tr>
      </thead>
      <tbody>
            <?php
                include ('connection.php');
                $email = $_COOKIE['email'];
                $txt = "";
                //getting customer id
                $get_c_id_query = "select `customer_id` from `customer` where `email` = '$email'";
                $customerResult = $conn->query($get_c_id_query);
                $customer = $customerResult->fetch_assoc();
                $customer_id = $customer['customer_id'];
                
                
                //getting s_id and date from subscription_history
                $query = "select * from `subscription_history` where `customer_id` = '$customer_id'";
                $sh_result = $conn->query($query);
                if ($sh_result->num_rows>=1) {
                    while($sh_row = $sh_result->fetch_assoc()) {
                      $sId = $sh_row['s_id'];
                       // getting subcription data
                       $s_query = "select `s_name`,`s_price`,`s_accesscontent` from `subscription` where `s_id` = '$sId'";
                       $sub_result = $conn->query($s_query);
                       $sub_row = $sub_result->fetch_assoc();
                         $txt .= '<tr> <td>' . $sub_row['s_name'] .  '</td>'.
                         '<td>' . $sub_row['s_price']. '</td>'.
                         '<td>' .$sub_row['s_accesscontent'] . '</td>' .
                         '<td>'. $sh_row['date'] .  '</td> </tr>';
                    }
                    echo $txt;
                  } 
                $conn->close();
            ?>
       
      </tbody>
    </table>
   </div>
    
</body>
</html>