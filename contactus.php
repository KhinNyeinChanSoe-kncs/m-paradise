<?php
    include ('connection.php');
    if (isset($_POST['btnSend'])) {
        $firstName = $conn->real_escape_string(htmlentities(trim($_POST['firstName'])));
        $lastName = $conn->real_escape_string(htmlentities(trim($_POST['lastName'])));
        $email = $conn->real_escape_string(htmlentities(trim($_POST['email'])));
        $phone = $conn->real_escape_string(htmlentities(trim($_POST['phone'])));
        $message = $conn->real_escape_string(htmlentities(trim($_POST['message'])));
        
        $query = "insert into contact (`f_name`,`l_name`,`email`,`phone`,`message`) values ('$firstName','$lastName','$email','$phone','$message')";
        if ($conn->query($query)=== TRUE) {
            echo "<script>alert('M-Paradise Team will contact you soon!!');</script>";
         }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="icon" href="img/logo.jpg">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,900&display=swap');
        * {
            font-family: 'Lato', sans-serif;
        }
        
    </style>
   
</head>

<body class="bg-secondary">
    
    <div class="container mt-3">
        <div class="row mb-5">
            <div class="col-sm-1 col-lg-2 col-xl-2"></div>
            <div class="col-sm-10 col-lg-8 col-xl-8">
                <div class="card shadow-1-strong">
                    <div class="card-header">
                        <div class="text-center px-5">
                            <small class="text-dark fw-light">GOT A QUESTION?</small>
                            <h3 class="fw-light mt-1 mb-1">Contact M-Paradise</h3>
                            <small class="text-dark fw-light">
                                <i class="fa-regular fa-heart"></i> 
                                &nbsp;WE ARE HERE TO HELP AND ANSWER
                                 ANY QUESTION YOU MIGHT HAVE.
                                WE LOOK FORWARD TO HEARING FROM YOU.
                                &nbsp; <i class="fa-regular fa-heart"></i>
                            </small>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <!-- input first name and last name -->
                            <div class="row ps-lg-5 ps-xl-5 ps-sm-2 mb-3">
                                <div class="col-sm-10 col-lg-5 col-xl-5 ">
                                    <div class="">
                                        <label for="firstName"  class="fw-light form-label" style="font-size: 18px;">
                                         First Name
                                        </label><br>
                                        <input type="text" class="w-100 form-control" name = "firstName" id="firstName">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-1 col-xl-1"></div>
                                <div class="col-sm-10 col-lg-5 col-xl-5">
                                    <div>
                                        <label for="lastName"  class="fw-light form-label" style="font-size: 18px;">
                                          Last Name
                                        </label><br>
                                        <input type="text" class="w-100 form-control" name = "lastName" id="lastName">
                                    </div>
                                </div>
                            </div>

                            <!-- input email -->
                            <div class="row ps-lg-5 ps-xl-5 ps-sm-2 mb-3">
                                <div class="col-sm-10 col-lg-11 col-xl-11">
                                    <label for="email"  class="fw-light form-label" style="font-size: 18px;">Email</label><br>
                                    <input type="email" class="w-100 form-control" name = "email" id="email">
                                </div>
                            </div>

                            <!-- input phone -->
                            <div class="row ps-lg-5 ps-xl-5 ps-sm-2 mb-3">
                                <div class="col-sm-10 col-lg-11 col-xl-11">
                                    <label for="phone"  class="fw-light form-label" style="font-size: 18px;">Phone</label><br>
                                    <input type="tel" class="w-100 form-control" name = "phone" id="phone">
                                </div>
                            </div>

                            <!-- textarea message -->
                            <div class="row ps-lg-5 ps-xl-5 ps-sm-2 mb-4">
                                <div class="col-sm-10 col-lg-11 col-xl-11">
                                    <label for="taMessage" class="fw-light form-label" style="font-size: 18px;">Message</label><br>
                                    <textarea class="form-control w-100" name = "message" id="taMessage" rows="4"></textarea>
                                </div>
                            </div>

                            <!-- send button -->
                            <div class="text-center mb-3">
                                <button type="submit" name="btnSend" class="btn btn-dark px-5 fw-light" style="font-size: 15px;"> Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-1 col-lg-2 col-xl-2"></div>
        </div>
        <footer>
            <div class="text-capitalize text-center mb-3">
                <div class="mb-3">
                    <a href="https://www.facebook.com/" target="_blank" class="btn btn-dark btn-floating mx-1">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.google.com/" target="_blank" class="btn btn-dark btn-floating mx-1">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="https://twitter.com/" target="_blank" class="btn btn-dark btn-floating mx-1">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://github.com/" target="_blank" class="btn btn-dark btn-floating mx-1">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
                <p for="" class="text-dark fw-light mb-5">©2022 M-Paradise | <a href="privacy_policy.html" target = "_blank" class="text-dark">Privacy Policy</a> | <a href="terms_and_condition.html" target = "_blank" class="text-dark">Terms and Conditions</a> | <a href="contactus.php" target = "_blank" class="text-dark">Contact Us</a></p>
            </div>
        </footer>
    </div>
</body>
</html>