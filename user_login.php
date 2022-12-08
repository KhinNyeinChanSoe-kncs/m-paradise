<?php
    include('connection.php');
    if (isset($_POST['btnLogin'])) {
        $userEmail = $_POST['email'];
        $userPassword = $_POST['password'];
        $userEmail = $conn->real_escape_string($userEmail);
        $userPassword = $conn->real_escape_string($userPassword);
        $query = "select `password` from `customer` where `email` = '$userEmail'";
        $result = $conn -> query($query);
        $row = $result -> fetch_assoc();
        if (password_verify($userPassword,$row['password'])) {
            setcookie("email",$userEmail,time()+3600*12);
            echo "<script>window.location.href = 'index.php'</script>";
        }else{
            echo "<script type='text/javascript'>alert('Login Failed!! Please Try Again!!',5000);</script>";
        }
        if (isset($_POST['rememberme'])) {
            setcookie("password",password_hash($userPassword,PASSWORD_BCRYPT),time()+3600*12);
            
        }
    }
?>

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

<body class="text-dark bg-secondary"  >
    <div class="container mt-3">
        <p style="font-size: 15px;" class="  d-inline-block pe-2 fs-2 text-dark">
            <img src="img/logo.jpg" class="logo">
            <b class="text-light ms-3">M-PARADISE</b>
        </p>

        <div class="row mt-5 mb-5">
            <!-- card start -->
            <div class=" col-md-4 col-lg-5 col-xl-5 card d-inline px-md-5">
                <div class="card-header">
                    <h1 class="text-center text-dark mt-3" style="text-shadow: 1.5px 1.5px rgb(84, 83, 83);">Login</h1>
                </div>
                <div class="card-body">

                    <!-- login form start -->
                    <div class="">
                        <form action="" method = "POST">
                            <div class="input-group mb-4 mt-2" for="loginEmail">
                                <span class="input-group-text bg-white">Email</span>
                                <input type="text" class="form-control" placeholder="example@gmail.com" id="loginEmail" name = "email" />

                            </div>
                            <label id="emailErr" class="text-danger" style="display : none;">Input is invalid</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-white">Password</span>
                                <input type="password" class="form-control" placeholder="Enter your password" name = "password" />
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input text-dark" type="checkbox" name = "rememberme" value="" id="" />
                                <label class="form-check-label text-dark"><small>Remember me</small></label>
                            </div>
                            <div class="text-center mb-3">
                                <button type = "submit" class="btn btn-dark text-light ps-5 pe-5" name = "btnLogin">Login</button>
                            </div>
                            
                            <a href="#" class="text-dark d-inline float-start mt-1">
                                <u><small> Forget password?</small></u>
                            </a>

                        </form>
                    </div>
                </div>

            </div>
            <div class="col-md-2 col-lg-1 col-xl-1"></div>
            <div class="col-md-5  col-lg-5 col-xl-5 mt-5">
                <!-- Carousel wrapper -->
                <div id="carouselDarkVariant" class="carousel slide carousel-fade carousel-dark" data-mdb-ride="carousel">
                    <!-- Indicators -->
                    <div class="carousel-indicators">
                        <button data-mdb-target="#carouselDarkVariant" data-mdb-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button data-mdb-target="#carouselDarkVariant" data-mdb-slide-to="1" aria-label="Slide 1"></button>
                        <button data-mdb-target="#carouselDarkVariant" data-mdb-slide-to="2" aria-label="Slide 1"></button>
                    </div>

                    <!-- Inner -->
                    <div class="carousel-inner">
                        <!-- Single item -->
                        <div class="carousel-item active">
                            <img src="img/poster1.jpg" class="d-block w-100" />
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>

                        <!-- Single item -->
                        <div class="carousel-item">
                            <img src="img/poster2.jpg" class="d-block w-100" alt="Mountaintop" />
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>

                        <!-- Single item -->
                        <div class="carousel-item">
                            <img src="img/poster3.jpeg" class="d-block w-100" alt="Woman Reading a Book" />
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>


                    </div>
                    <!-- Inner -->

                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselDarkVariant" data-mdb-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-mdb-target="#carouselDarkVariant" data-mdb-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <!-- Carousel wrapper -->

            </div>
        </div>
        <br><br>
        <p class="text-light">If you don't have account, <a href="register.php" target="_blank" class="text-light"><b><u>Register Now</u></b></a></p>
        <br><br><br>
        <footer>
            <div class="text-capitalize text-center mb-3">
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