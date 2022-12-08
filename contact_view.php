<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Paradise</title>
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
        body{
            background-color : #E3F2FD;
        }    
    </style>
</head>
<body >
    <div class="container">
        <div class="text-center mt-5">
            <h2 class = "fw-bold ">Customers' Contact Details</h2>
        </div>
        <div class="row">
            <div class="d-d-sm-block col-lg-2 col-xl-1"></div>
            <div class="col-sm-12 col-lg-8 col-xl-10">
            <form action="" method = "POST">
                    <table class = "table table-hover table-dark mt-3 ">
                        <thead class= 'mb-3'>
                            <tr>
                                <th class= 'pe-5 fw-bold'>FirstName</th>
                                <th class= 'pe-5 fw-bold'>SurName</th>
                                <th class= 'fw-bold'> Email</th>
                                <th class= 'fw-bold'> Phone</th>
                                <th class= 'fw-bold'>Message</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody >
                
                            <?php
                                include('connection.php');
                                if (isset($_POST['btnDelete'])) {
                                    $id = $_COOKIE['contact_id'];
                                    $deleteQuery = "delete from `contact` where `contact_id` = '$id'";
                                    if ($conn->query($deleteQuery) === TRUE) {
                                        echo "<script>alert('Customer Contact Form Deletion Successful');</script>";
                                      } else {
                                        echo "Error deleting record: " . $conn->error;
                                      }
                                }
                                $temp = "";
                                $query = "select * from contact";
                                $result = $conn->query($query);
                                if ($result->num_rows>0) {
                                    while ($row = $result->fetch_assoc()) {
                                      
                                        $temp .= "
                                        <tr>
                                            <td >{$row['f_name']} </td>
                                            <td >{$row['l_name']}</td>
                                            <td>{$row['email']}</td>
                                            <td>{$row['phone']}</td>
                                            <td>{$row['message']}</td>
                                            <td><button type='submit' name = 'btnDelete' onclick = 'setID({$row['contact_id']})'
                                            class='btn btn-danger'>Delete</button></td>
                                        </tr>
                                        ";  
                                    }   
                                }
                                echo $temp;
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="d-sm-block col-lg-2 col-xl-1"></div>
        </div>
    </div>
    <script>
        // alert (sessionStorage.getItem("name"));
        function setID(id){
            document.cookie = `contact_id=${id};` ;
        }
    </script>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js">
    </script>
</body>
</html>