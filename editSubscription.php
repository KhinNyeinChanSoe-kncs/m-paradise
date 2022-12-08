<?php
    include('connection.php');
    session_start();
    $id = $_SESSION['id'];
    $query = "select * from `subscription` where `s_id` = {$id}";
    $result = $conn->query($query);
    $row = $result -> fetch_assoc();
    setcookie("name",$row['s_name']);
    setcookie("price",$row['s_price']);
    setcookie("accesscontent",$row['s_accesscontent']);
    setcookie("validity",$row['s_validity']);

    if (isset($_POST['btnUpdate'])) {
      $updated_name = $_COOKIE["updated_name"];
      $updated_price = $_COOKIE["updated_price"];
      $updated_content = $_COOKIE["updated_content"];
      $updated_validity = $_COOKIE["updated_validity"];
      $updateQuery = "update `subscription`
      SET `s_name` = '$updated_name', 
      `s_price` = '$updated_price',
      `s_accesscontent` = '$updated_content',
      `s_validity` = '$updated_validity'
      WHERE `s_id` = '$id'";
      if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('Subscription Updated Successfully!!')</script>";
        echo "<script>window.location.href = 'admindashboard.php'</script>";
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Paradise Admin </title>
   
    <link rel="icon" href="img/admin.png">
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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,900&display=swap');
        * {
            font-family: 'Lato', sans-serif;
        }  
        body{
            background-color : #E3F2FD;
        }    
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="d-sm-block col-lg-1 col-xl-2"></div>
            <div class="col-sm-12 col-lg-10 col-xl-8">
                <div class="card mt-5">
                     <div class="card-body">
                        <form action="" method="post">
                            
                            <div class="form-outline mb-4">
                              <input type="text" id="sName" class="form-control" />
                              <label class="form-label" for="sName">Subscription Name</label>
                            </div>
                           
                            <div class="form-outline mb-4">
                              <input type="text" id="price" class="form-control" />
                              <label class="form-label" for="price">Price of Subscription</label>
                            </div>
                            <div class="form-outline mb-4">
                              <input type="text" id="content" class="form-control" />
                              <label class="form-label" for="content">Access Content of Subscription</label>
                            </div>
                            <div class="form-outline mb-4">
                              <input type="text" id="validity" class="form-control" />
                              <label class="form-label" for="validity">Validate Days</label>
                            </div>
                            <div class="text-center"><button type="submit" name = "btnUpdate" onclick = "getData()" class="btn btn-info px-5">Update</button></div>
                        <!-- </form> -->
                     </div>
                   </div>
            </div>
            <div class="d-sm-block col-lg-1 col-xl-2"></div>
        </div>
       
    </div>
    <script>

        var sName = document.getElementById("sName");     
        var price = document.getElementById("price");
        var content = document.getElementById("content");
        var validity = document.getElementById("validity");
        function getCookie(sub_data) {
          
          let decodedCookie = decodeURIComponent(document.cookie);
          let ca = decodedCookie.split(';');
          for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
              c = c.substring(1);
            }
            if (c.indexOf(sub_data) == 0) {
               c = c.split("=");
              return c[1];
            }
          }
          return "";
        }
        
        sName.value = getCookie("name");
        price.value = getCookie("price");
        content.value = getCookie("accesscontent");
        validity.value = getCookie("validity");

        function getData(){
          document.cookie = `updated_name=${sName.value};` ;
          document.cookie = `updated_price=${price.value};` ;
          document.cookie = `updated_content=${content.value};` ;
          document.cookie = `updated_validity=${validity.value};` ;
        }
    
    </script>
   

    <!-- MDB -->
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"
    ></script>
</body>
</html>

