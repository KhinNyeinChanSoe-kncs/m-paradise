<?php
 include('connection.php');
 if (isset($_POST['btnAdd'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $email =  $conn-> real_escape_string($email);
    $password =  $conn-> real_escape_string($password);
    $password = password_hash($password,PASSWORD_BCRYPT);
    $query = "Insert into `admin`(`email`,`password`) values ('$email','$password')";
    if ($conn->query($query)!== TRUE) {
        echo "Error : " . $query . "<br>" . $conn-> error;
    }else{
        echo "<script>alert('Insert Successfully!!')</script>";
    }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
    <!-- MDB -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css"
      rel="stylesheet"
    />
    <link rel="icon" href="img/admin.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,900&display=swap');
        * {
            font-family: 'Lato', sans-serif;
        }      
    </style>
</head>
<body>
    <div class = "container">
        <div class = "row">
            <div class = "col-3"></div>
            <div class = "col">
                <div class = "card mt-5">
                    <div class = "card-header text-center">
                        <h3 class = "text-black">Add Admin Account </h3>
                    </div>
                    <div class="card-body">
                        <form action="" class="" method="POST">
                                <div class="input-group mb-4 hover-shadow">
                                    <span class="input-group-text bg-white">Email</span>
                                    <input type="text" class="form-control" name="email" />

                                </div>
                                <div class="input-group mb-4 hover-shadow">
                                    <span class="input-group-text bg-white">Password</span>
                                    <input type="password" class="form-control" placeholder="" name="password" />
                                </div>
                                <div class="text-center mb-5">
                                    <button class="btn btn-dark ps-5 pe-5" id="btnAdd" type="submit" name = "btnAdd">Add Admin Account</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>

    <!-- MDB -->
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"
    ></script>
</body>
</html>