<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Paradise</title>
    <link rel="icon" href="img/logo.jpg">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,900&display=swap');
        *{
            font-family: 'Lato', sans-serif;
        }
        
        .dataplan{
            font-size : 16px;
        }
        @media only screen and (max-width : 576px){
            .dataplan{
                font-size : 11px;
            }
        }
        @media only screen and (max-width : 992px){
            .dataplan{
                font-size : 13px;
            }
        }
        
    </style>
</head>
<body class="bg-black">
    <div class="container mt-5">
        <div class="card bg-secondary">
            <div class="card-header ">
                <h3 class="text-capitalize text-dark text-center py-3 fw-bold"> choose one plan and get a month free</h3>
            </div>
            <div class="card-body">
                <form action="" method = "POST">
                    <?php
                        include('connection.php');
                        
                        if (isset($_COOKIE['s_status'])) {
                            $status = $_COOKIE['s_status'];
                            if ($status) {
                                echo "<script>window.location.href = 'payment.php'</script>";
                                
                            }
                            setcookie("s_status",$status,time()-1200);
                        }
                        $temp= "";
                        $s_query = "select * from `subscription`";
                        $sub_result = $conn->query($s_query);
                        while ($sub_row = $sub_result->fetch_assoc()) {
                             
                            $temp .= "
                            <div class='card mt-3'>
                                <div class='card-body'>
                                    <div class='row'>
                                        <div class='col-sm-1 col-lg-1 col-xl-1'></div>
                                        <div class='col-sm-1 col-lg-1 col-xl-1'>
                                            <small class='text-secondary'> PLAN</small>
                                            <p class='text-dark fw-bold mt-1 dataplan'>{$sub_row['s_name']} </p>
                                        </div>
                                        <div class='col-sm-1 col-lg-1 col-xl-1'></div>
                                        <div class='col-sm-1 col-lg-1 col-xl-1'>
                                            <small class='text-secondary'>CHARGES</small>
                                            <p class='text-dark fw-bold mt-1 dataplan'>{$sub_row['s_price']}</p>
                                        </div>
                                        <div class='col-sm-1 col-lg-1 col-xl-1'></div>
                                        <div class='col-sm-2 col-lg-2 col-xl-2'>
                                            <small class'text-secondary'>ACCESS TO CONTENT</small>
                                            <p class='text-dark fw-bold mt-1 dataplan'>{$sub_row['s_accesscontent']}</p>
                                        </div>
                                        <div class='col-sm-1 col-lg-1 col-xl-1'></div>
                                        <div class='col-sm-1 col-lg-1 col-xl-1'>
                                            <small class='text-secondary'>VALIDITY</small>
                                            <p class='text-dark fw-bold mt-1 dataplan'>{$sub_row['s_validity']}</p>
                                        </div>
                                        <div class='col-sm-1 col-lg-1 col-xl-1'></div>
                                        <div class='col-sm-1 col-lg-1 col-xl-1'> 
                                            <button class='btn btn-dark px-sm-4 px-lg-4 px-xl-5 mt-xl-4 mt-sm-5 dataplan ' 
                                            name= 'cardOne' onclick = 'setID({$sub_row['s_id']})'  type = 'submit'>
                                                Buy
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            ";
                        }
                        echo $temp;
                        
                    ?>
                    
                </form>
            </div>
        </div>

    </div>
    <script>
         function setID(id){
            document.cookie = `s_id=${id};` ; 
            document.cookie = `s_status = true`;
        }
    </script>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
</body>

</html>