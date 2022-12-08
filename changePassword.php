<?php
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

    if (isset($_POST['btnUpdate'])) {
        include ('connection.php');
        $email = $_COOKIE['email'];
        $caseOne = FALSE;
        $caseTwo = FALSE;
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        $currentPassword = $conn-> real_escape_string($currentPassword);;
        $newPassword = $conn->real_escape_string($newPassword);;
        $confirmPassword = $conn->real_escape_string($confirmPassword);;
        $query = "select `password` from `customer` where `email` = '$email'";
        $result = $conn -> query($query);
        if($result ->num_rows>0){
            $row = $result -> fetch_assoc();
            if (password_verify($currentPassword, $row['password'])) {
                $caseOne = TRUE;
               if (strlen($newPassword) >= 8 && strlen($confirmPassword)>=8) {
                    if ($newPassword == $confirmPassword) {
                        if (checkStrongPassword($newPassword)) {
                            $caseTwo = TRUE;
                            if ($caseOne && $caseTwo) {
                                $newPassword = password_hash($newPassword,PASSWORD_BCRYPT);
                                $updateQuery = "update `customer`
                                SET `password` = '$newPassword'
                                WHERE `email` = '$email'";
                                $updateResult = $conn->query($updateQuery);
                                if ($updateResult) {
                                    echo "<script>window.confirm('Password Changed!!!');
                                    if(confirm('Password Changed!!!')) {window.location.href = 'profile.php'}
                                    </script>
                                    ";
 
                                }
                            }
                        }
                    }else{
                    echo "<script>alert('PLEASE ENTER THE SAME PASSWORD TO CONTINUE CHANGES');</script>";
                    }
               }else{
                    echo "<script>alert('PASSWORD MUST BE AT LEAST 8 CHARACTES');</script>";
               }
            }
            else{
                echo "<script>alert('CURRENT PASSWORD IS INCORRECT!!')</script>";
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
    <title>Change Password</title>
    <link rel="icon" href="img/logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,900&display=swap');
        *{
            font-family: 'Lato', sans-serif;
        }
    </style>
</head>
<body>
    <div class="containter mt-sm-5">
        <div class="row mt-sm-3 mt-xs-3 mt-lg-5 mt-xl-5">
            <div class="col-sm-1 col-xl-3 col-lg-3"></div>
            <div class="col-xl-6 col-lg-6 col-sm-10">
                <div class="card">
                   <div class="card-body">
                        <h4 class = "fw-bold">Change Password</h4>
                        <form action="" method = "POST" class = "mt-4">
                            <!-- current password -->
                            <div class="form-floating mb-3">
                                <input type="password" id="form3Example4" name = "currentPassword" class="form-control form-control-lg" placeholder="password" />
                                <label class="form-label" for="form3Example4">Current Password</label>
                            </div>
                            <!-- New Password -->
                            <div class="form-floating mb-3">
                                <input type="password" id="form3Example4" name = "newPassword" class="form-control form-control-lg" placeholder="password" />
                                <label class="form-label" for="form3Example4">New Password</label>
                            </div>
                            <!-- Confirm Password -->
                            <div class="form-floating mb-4">
                                <input type="password" id="form3Example4" name = "confirmPassword" class="form-control form-control-lg" placeholder="password" />
                                <label class="form-label" for="form3Example4">Confirm New Password</label>
                            </div>
                            <!-- Update Button -->
                           <div class="text-center mb-3">
                            <button class = "btn btn-dark px-5 py-2" name = "btnUpdate">Update Password</button>
                           </div>
                        </form>
                   </div>
                </div>
            </div>
            <div class="col-sm-1 col-lg-3 col-xl-3"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>