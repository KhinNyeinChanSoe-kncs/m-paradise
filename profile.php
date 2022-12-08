<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" href="img/logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,900&display=swap');
        * {
            font-family: 'Lato', sans-serif;
        }
        
        body {
            background-color: #9da1a0;
        }
        
        .imgProfile {
            width: 90px;
            height: 90px;
        }
        
        @media only screen and (max-width: 600px) {
            .imgProfile {
                width: 50px;
                height: 50px;
            }
        }
        
        @media only screen and (max-width: 768px) {
            .imgProfile {
                width: 60px;
                height: 60px;
            }
        }
        
        @media only screen and (max-width: 992px) {
            .imgProfile {
                width: 80px;
                height: 80px;
            }
        }
        
        @media only screen and (max-width: 1300px) {
            .imgProfile {
                width: 90px;
                height: 90px;
            }
        }
        
        .cardText {
            font-size: 18px;
        }
    </style>
</head>

<body class="opacity-3">
    <div class="container mt-xl-5 mt-lg-5 mt-sm-5">
        <div class="card bg-dark mt-5 border border-white border-2">
            <div class="card-header text-center mt-2 mb-2">
                <img src="img/profile.jpg" class="imgProfile rounded-circle border border-white border-3 " alt="profile image">
            </div>
            <div class="card-body text-center">
                    <?php
                        include('connection.php');
                        $email = $_COOKIE["email"];
                        $query = "select `name`,`s_id` from `customer` where `email` = '$email'";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) { 
                           $row = $result->fetch_assoc();
                           echo "<p class='cardText fw-bold text-white mt-2'>Name : " . $row['name'] . "</p>" ;
                           echo "<p class='cardText fw-bold text-white mt-2'>Email : "  . $email . "</p>";
                       
                           $sid = $row['s_id'];
                           $queryOne = "select * from `subscription` where `s_id` = '$sid'";
                           $resultOne = $conn->query($queryOne);
                           if ($resultOne->num_rows>0) {
                                $rowOne = $resultOne->fetch_assoc();
                                echo " <div class='dropdown'>
                                <a class='cardText btn btn-dark dropdown-toggle text-white fw-bold' href='#'
                                 role='button' id='dropdownMenuLink' data-bs-toggle='dropdown' aria-expanded='false'>"
                                . $row['name']. " 's  Details Subscription </a>";
                                echo "<ul class='dropdown-menu bg-dark' aria-labelledby='dropdownMenuLink'>";
                                echo "<li><a class='dropdown-item text-white px-5 mt-1' href='#'>Plan Name : " . $rowOne['s_name'] . "</a></li>";
                                echo "<li><a class='dropdown-item text-white px-5 mt-1' href='#'>Paid : " . $rowOne['s_price']. " </a></li>";
                                echo "<li><a class='dropdown-item text-white px-5 mt-1' href='#'>Access Content : " . $rowOne['s_accesscontent'] . " </a></li>";
                                echo "<li><a class='dropdown-item text-white px-5 mt-1' href='#'>Validate Day : " . $rowOne['s_validity'] . " </a></li>";
                                echo " </ul></div>";
                               
                           }
                      
                        }

                    ?>
                    <a href = 'changePassword.php' class='cardText btn btn-light px-5 fw-bold mt-3 mb-5'>Change Password</a>
                </div>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>