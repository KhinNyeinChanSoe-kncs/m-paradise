<?php
    include('connection.php');
    $adminOne = "adminone@gmail.com";
    $pswOne = password_hash("adminone123",PASSWORD_BCRYPT);  
    $queryOne = "Insert into `admin` (`email`,`password`) values ('$adminOne','$pswOne')";
    if ($conn->query($queryOne) !== TRUE) {
        echo "Error: " . $queryOne . "<br>" . $conn->error;
      } 
     
    
