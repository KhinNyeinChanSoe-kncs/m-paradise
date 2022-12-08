<?php
    include ('connection.php');
    $email = $_COOKIE["email"];
    $q = "select `customer_id` from customer where `email` = '$email'";
    $customerResult = $conn->query($q);
    $customer = $customerResult->fetch_assoc();
    $customer_id = $customer['customer_id'];
    
    function insertSubscription(){
        include ('connection.php');
        $email = $_COOKIE["email"];
        $s_id = $_COOKIE["s_id"];
        $query = "update `customer` set `s_id` = '$s_id' where `email` = '$email'";
        if ($conn->query($query) === TRUE) {
            return true;
          } else {
            echo $query. "<br>" . $conn->error;
          }
    }
    if (isset($_POST['btnMakePayment'])) {

        $fName = $conn->real_escape_string(htmlentities(trim($_POST['firstName'])));
        $lName = $conn->real_escape_string(htmlentities(trim($_POST['lastName'])));
        $zipCode = $conn->real_escape_string(htmlentities(trim($_POST['billingZipCode'])));
        $cardNumber = $conn->real_escape_string(htmlentities(trim($_POST['cardNumber'])));
        $cvv = $conn->real_escape_string(htmlentities(trim($_POST['cvv'])));
        $expDate = $conn->real_escape_string(htmlentities(trim($_POST['expirationDate'])));
        $zipCode = md5($zipCode);
        $cardNumber = md5($cardNumber);
        $cvv = md5($cvv);
        $expDate = md5($expDate);
        $s_id = $_COOKIE["s_id"];

        $query = "insert into payment (`f_name`,`l_name`,`zip_code`,`card_number`,`cvv`,`exp_date`) values ('$fName','$lName','$zipCode','$cardNumber','$cvv','$expDate')";
        if ($conn -> query($query)=== TRUE) {
            $queryOne = "select `p_id` from payment where `f_name` = '$fName' and `l_name` = '$lName'";
            $result = $conn->query($queryOne);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    $pID = $row['p_id'];
                }
            }
            $queryTwo = "update `customer` set `p_id` = '$pID' WHERE `email` = '$email'";
            if ($conn->query($queryTwo)===TRUE) {
                insertSubscription();
                $date = date("l jS \of F Y h:i:s A");
                $queryThree = "insert into `subscription_history` (`customer_id`,`s_id`,`date`) values ('$customer_id','$s_id','$date')";
                if ($conn->query($queryThree)===TRUE) {
                    echo "<script>alert('Payment Successful!!');
                    window.location.href = 'index.php'</script>";
                }
            }
            
            
        }
    }
   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="icon" href="img/logo.jpg">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,900&display=swap');
        * {
            font-family: 'Lato', sans-serif;
        }
        
        .paymentLogo {
            width: 40px;
            height: 30px;
            object-fit: contain;
        }
        
        @media only screen and (max-width: 600px) {
            .paymentLogo {
                width: 30px;
                height: 20px;
                object-fit: contain;
            }
        }
    </style>
    
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet" />

</head>

<body class="bg-secondary">
    <div class="container mt-3">
        <div class="row mb-5 mt-5">
            <div class="col-sm-1 col-lg-2 col-xl-2"></div>
            <div class="col-sm-10 col-lg-8 col-xl-8">
                <div class="card shadow-1-strong border border-dark">
                    <div class="card-header">
                        <div class="px-sm-1 px-lg-5 px-xl-5">
                            <h3 class="text-capitalize fw-bold mt-2 ">Make Payment Today</h3>
                        </div>
                        <div class="px-sm-1 px-lg-5 px-xl-5 my-2">
                            <img src="img/visa.jpeg" class="paymentLogo me-3 rounded-5" alt="">
                            <img src="img/paypal.jpg" class="paymentLogo me-3 rounded-5" alt="">
                            <img src="img/mastercard.png" class="paymentLogo me-3 rounded-5" alt="">
                            <img src="img/americanexp.jpg" class="paymentLogo me-3 rounded-5" alt="">
                            <img src="img/jcb_card_logo.png" class="paymentLogo me-3 rounded-5" alt="">
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <!-- First Name -->
                            <div class="form-floating mb-4 mt-2">
                                <input type="text" id="firstName" name="firstName" class="form-control form-control-lg" placeholder="Enter First Name" />
                                <label class="form-label" for="firstName">First Name</label>
                            </div>
                            <!-- Last Name -->
                            <div class="form-floating mb-4 ">
                                <input type="text" id="lastName" name="lastName" class="form-control form-control-lg" placeholder="Enter Last Name" />
                                <label class="form-label" for="lastName">Last Name</label>
                            </div>
                            <!-- Billing Zip Code -->
                            <div class="form-floating mb-4 ">
                                <input type="text" id="billingZipCode" name="billingZipCode" class="form-control form-control-lg" placeholder="Enter Billing Zip Code" />
                                <label class="form-label" for="billingZipCode">Billing Zip Code</label>
                            </div>
                            <!-- Card Number -->
                            <div class="form-floating mb-4 ">
                                <input type="text" id="cardNumber" name="cardNumber" class="form-control form-control-lg" placeholder="Enter Card Number" />
                                <label class="form-label" for="cardNumber">Card Number</label>
                            </div>
                            <!-- CVV -->
                            <div class="form-floating mb-4 ">
                                <input type="text" id="cvv" name="cvv" class="form-control form-control-lg" placeholder="Enter CVV" />
                                <label class="form-label" for="cvv">CVV</label>
                            </div>
                            <!-- Expiration Date -->
                            <div class="form-floating mb-4 ">
                                <input type="text" id="expirationDate" name="expirationDate" class="form-control form-control-lg" placeholder="Enter Expiration Date" />
                                <label class="form-label" for="expirationDate">Expiration Date(MM/YY)</label>
                            </div>
                            <!-- Save Button -->
                            <div class="text-center mb-2">
                                <button type="submit" name = "btnMakePayment" class="btn btn-dark px-5 py-2 fw-bold" style = "font-size : 15px;">Make Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-1 col-lg-2 col-xl-2"></div>
        </div>
    </div>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
</body>

</html>