<?php
    include('connection.php');
    if (isset($_POST['btn_submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $username =  $conn-> real_escape_string(trim($username));  
        $password =  $conn-> real_escape_string(trim($password));  
        $query = "select `password` from `admin` where `email` = '$email'";
        $result = $conn -> query($query);
        $row = $result -> fetch_assoc();
        if (password_verify($password,$row["password"])) {
            echo "<script>window.location.href = 'admindashboard.php'</script>";
        }else{
            echo "<script type='text/javascript'>alert('Login Failed!! Try Again!!',5000);</script>";
        }

    }
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="icon" href="img/admin.png">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,900&display=swap');
        * {
            font-family: 'Lato', sans-serif;
        }

        body {
            background-image: linear-gradient(#b2e0f4, white);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <section class="vh-100">
            <div class="">
                <div class="row d-flex justify-content-center align-items-center h-100 mt-3">

                    <h1 class="text-dark">M-Paradise</h1>
                    <div class="col-md-9 col-lg-6 col-xl-5 mt-5">
                        <img src="img/admin.png" class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form method = "POST">
                            <h3 class="text-dark mt-1">Admin Login</h3>
                            <!-- Email input -->
                            <div class="form-floating mb-4 mt-5">
                                <input type="email" id="form3Example3" name = "email" class="form-control form-control-lg" placeholder="Enter a valid email address" />
                                <label class="form-label" for="form3Example3">Email address</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-floating mb-3">
                                <input type="password" id="form3Example4" name = "password" class="form-control form-control-lg" placeholder="Enter password" />
                                <label class="form-label" for="form3Example4">Password</label>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <!-- Checkbox -->
                                <div class="form-check mb-0 mt-2">
                                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                                    <label class="form-check-label" for="form2Example3">Remember me</label>
                                </div>
                                <a href="#!" class="text-body">Forgot password?</a>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" name = "btn_submit" class="btn btn-primary btn-lg ps-5 pe-5">Login</button>

                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
</body>

</html>