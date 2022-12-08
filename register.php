
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Paradise</title>
    <link rel="icon" href="img/logo.jpg">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,900&display=swap');
        * {
            font-family: 'Lato', sans-serif;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        .card {
            height: 400px;
            /* background-image: linear-gradient( rgb(251, 247, 248), black); */
        }

        .poster {
            width: 500px;
            height: 500px;
        }

        body {
            background-image: linear-gradient(black, rgb(71, 70, 70), black);
        }

        .textPlusPoster {
            position: relative;
        }

        .registerPoster {
            object-fit: contain;
            width: 95%;
        }

        .txtOnPoster {
            color: white;
            position: absolute;
            top: 7%;
            left: -1%;
            transform: rotate(-0.1turn);
        }
    </style>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet" />
    
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
</head>

<body class = "bg-secondary">
    <div class="container mt-5">

        <div class="row mt-3 mb-8">
            <div class="textPlusPoster col-md-8 col-lg-5 col-xl-5 d-inline">
                <img src="img/poster for register.webp" class="registerPoster  rounded hover-shadow d-inline-block">
                <h5 class="txtOnPoster text-uppercase fw-bolder  ">Now Trending</h5>
            </div>

            <div class="col-md-8 col-lg-5 col-xl-5 ">
                <div class="fw-bolder text-light text-center">
                    <h1>Create Account</h1>
                </div>
                <div class="">
                    <form action="" class="" method="POST">
                        <div class="input-group mb-4 mt-5 hover-shadow">
                            <span class="input-group-text bg-white " for="name">Name</span>
                            <input type="text" class="form-control " name="name" />

                        </div>
                        <div class="input-group mb-4 hover-shadow">
                            <span class="input-group-text bg-white">Email</span>
                            <input type="text" class="form-control" name="email" />

                        </div>
                        <div class="input-group mb-4 hover-shadow">
                            <span class="input-group-text bg-white">Password</span>
                            <input type="password" class="form-control" placeholder="" name="password" />

                        </div>
                        <div class="input-group mb-3 hover-shadow">
                            <span class="input-group-text bg-white">Confirm Password</span>
                            <input type="password" class="form-control" placeholder="" name="confirmPassword" />

                        </div>
                        <div class="form-check mb-md-5 mb-lg-2">
                            <input class="form-check-input " type="checkbox" name="term_and_condition"/>
                            <label class="form-check-label text-light"><small>I agree to the <a href="terms_and_condition.html"
                             target = "_blank" class="text-light fw-bolder">terms & conditions</a></small></label>
                        </div>
                        <p class = "text-danger fs-5 ">
                            <b>
                                <?php
                                    include('connection.php');
                                    function checkStrongPassword($psw){
                                        $upperCaseStatus = false;
                                        $lowerCaseStatus = false;
                                        $numberStatus = false;
                                        $specialCharacterStatus = false;
                                        if (preg_match('/[A-Z]/',$psw)) {
                                            $upperCaseStatus = true;
                                        }
                                        if (preg_match('/[a-z]/',$psw)) {
                                            $lowerCaseStatus = true;
                                        }
                                        if (preg_match('/[0-9]/',$psw)) {
                                            $numberStatus = true;
                                        }
                                        if (preg_match('/[!@#$%&*]/',$psw)) {
                                            $specialCharacterStatus = true;
                                        }
                                        if ($upperCaseStatus && $lowerCaseStatus && $numberStatus && $specialCharacterStatus) {
                                        return true;
                                        }
                                    }
                                    if (isset($_POST['signup'])) {
                                        $name = $_POST['name'];
                                        $email = $_POST['email'];
                                        $password = $_POST['password'];
                                        $confirmPassword = $_POST['confirmPassword'];
                                        if ( $name != "" && $email != "" && $password != "" && $confirmPassword != "") {
                                            if (isset($_POST['term_and_condition'])){
                                                if (strlen($password) >= 8 && strlen($confirmPassword) >= 8) {
                                                    if ($password == $confirmPassword) {
                                             
                                                        $status = checkStrongPassword($password);
                                                        if ($status) {
                                                            $checkQuery = "select * from `customer` where `email`='$email'";
                                                            $result = $conn->query($checkQuery);
                                                            if ($result->num_rows>0) {
                                                                echo "<script>alert('This email address is already used')</script>";
                                                            }else{
                                                                $name =$conn-> real_escape_string(htmlentities(trim($name)));
                                                                $email =$conn-> real_escape_string(htmlentities(trim($email)));
                                                                $password =$conn-> real_escape_string(htmlentities(trim($password)));
                                                                $password = password_hash($password,PASSWORD_BCRYPT);
                                                                $query = "Insert into `customer` (`name`,`email`,`password`,`s_id`,`p_id`) values ('$name','$email','$password',0,0)";
                                                                if ($conn->query($query)=== TRUE) {
                                                                    echo "<script>window.location.href = 'user_login.php'</script>";
                                                                }
                                                        }
                                                        }
                                                        else{
                                                            echo "You need to use a more stronger password!!(Contain A-Z, a-z, 0-9 and special characters)";
                                                        }
                                                    }
                                                    else {
                                                        echo "The two passwords must be the same.";
                                                    }
                                                    }
                                                    else {
                                                        echo "Password must be at least 8 characters";
                                                    }
                                                    }
                                                    else{
                                                        echo "You need to accept terms and conditions";
                                                    }
                                                }
                                                else{
                                                    echo "You need to fill all the information in the registration form";
                                                }
                                    }
                                ?>
                            </b>
                        </p>             
                        <div class="text-center mb-5">
                            <button class="btn btn-light ps-5 pe-5" id="btnLogin" type="submit" name = "signup">Signup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer class = "mt-5">
            <div class="text-capitalize text-center ">
                <div class="mb-3">
                    <a href="https://www.facebook.com/" target="_blank" class="btn btn-light btn-floating mx-1">
                        <i class="fab fa-facebook-f"></i>
                    </a>

                    <a href="https://www.google.com/" target="_blank" class="btn btn-light btn-floating mx-1">
                        <i class="fab fa-google"></i>
                    </a>

                    <a href="https://twitter.com/" target="_blank" class="btn btn-light btn-floating mx-1">
                        <i class="fab fa-twitter"></i>
                    </a>

                    <a href="https://github.com/" target="_blank" class="btn btn-light btn-floating mx-1">
                        <i class="fab fa-github"></i>
                    </a>

                </div>
                <p for="" class="text-light fw-light mb-5">©2022 M-Paradise | <a href="privacy_policy.html" target = "_blank" class="text-light">Privacy Policy</a> | <a href="terms_and_condition.html" target = "_blank" class="text-light">Terms and Conditions</a> | <a href="contactus.php" target = "_blank" class="text-light">Contact Us</a></p>
            </div>
        </footer>
    </div>
    
    
</body>

</html>