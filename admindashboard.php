<?php
    include ('connection.php');
    session_start();
    // $_SESSION['name'] = "Hello";
    if (isset($_POST['btnEdit'])) {
       echo $_SESSION['id'] = $_POST['btnEdit'];
       echo '<script>window.location.href = "editSubscription.php"</script>';
    //    echo '<script>alert('.$_SESSION['id'].')</script>';
    
    }
    if (isset($_COOKIE['status'])) {
        $status= $_COOKIE['status'];
        if ($status) {
            $dUID = $_POST['customer_id'];
            $ch_query = "select `name` from `customer` where `customer_id` = '$dUID'";
            $ch_result = $conn->query($ch_query);
            if ($ch_result->num_rows>0) {
                $query = "delete from `customer` where `customer_id`= '$dUID'";
                $result = $conn->query($query);
                if ($result) {
                    echo "<script>alert('User Delete Successfully!!')</script>";
                    setcookie("status","",time()-3600);
                }
            }else{
                echo "<script>alert('Invalid User ID, Try Again!!')</script>";
                $status = false;
                setcookie("status","",time()-3600);
            }
            
           
        }
        
    }
    if (isset($_POST['btnAddStaff'])) {
        $name = $conn->real_escape_string($_POST['staff_name']);
        $email = $conn->real_escape_string($_POST['staff_email']);
        $phone = $conn->real_escape_string($_POST['staff_phone']);
        $dept = $conn->real_escape_string($_POST['staff_dept']);
        $salary = $conn->real_escape_string($_POST['staff_salary']);
        $query = "insert into `staff`( `name`, `email`, `phone`, `dept`, `salary`) values ('$name','$email','$phone','$dept','$salary')";
        if ($conn->query($query) === TRUE) {
            echo "<script>alert('Staff Registration Successful!!')</script>";
          } else {
            echo "Error: " . $query . "<br>" . $conn->error;
          }
    }
    function output($d,$m,$y){
        if ($m == "January") {
            $m = "February";
        }else if ($m == "February") {
            $m = "March";
        }else if ($m == "March") {
            $m = "April";
        }else if ($m == "April") {
            $m = "May";
        }else if ($m == "May") {
            $m = "June";
        }else if ($m == "June") {
            $m = "July";
        }else if ($m == "July") {
            $m = "August";
        }else if ($m == "August") {
            $m = "September";
        }else if ($m == "September") {
            $m = "October";
        }else if ($m == "October") {
            $m = "November";
        }else if ($m == "November") {
            $m = "December";
        }else if ($m == "December") {
            $m = "January";
            $y = (int)$y;
            $y += 1;
        }
        echo "<script>alert('Subscription Expire Date : {$d},{$m},{$y}')</script>";
    }
    if (isset($_POST['btnCheck'])) {
        $cus_id = $_POST['cus_id'];
        
        $query = "select `s_id` from `customer` where `customer_id` = '$cus_id'";
        $result = $conn->query($query);
        if ($result->num_rows>0) {
            $row = $result->fetch_assoc();
            $sid = $row['s_id'];
        
            $shQuery = "select `date` from `subscription_history` where `customer_id` = '$cus_id' and `s_id` = '$sid'";
            $shResult = $conn->query($shQuery);
            if ($shResult->num_rows>0) { 
                $data = "";
                while($shRow = $shResult->fetch_assoc()) {
                  $data = $shRow['date'];
                }
                $date = explode(" ",$data);  
                $day = $date[1];
                $month = $date[3];
                $year = $date[4];
                output($day,$month,$year);
              } 
        }else{
            echo "<script>alert('Invalid User ID')</script>";
        }
    }
    
    
   
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>M-Paradise Admin </title>
    <style>
        *{
            margin:0;
            padding:0;
        }
        
        @media only screen and (max-width: 604px){
            .subTable{
                overflow-x: scroll;
            }
        }
        @media only screen and (max-width: 768px){
            .subTable{
                overflow-x: scroll;
            }
        }
    </style>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/feather/feather.css">
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/typicons/typicons.css">
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <!-- endinject -->
    
    <link rel="icon" href="img/admin.png">
    <!-- Font Awesome -->
    <script src="https://smtpjs.com/v3/smtp.js"></script>
</head>

<body>
    <div class="container-scroller">

        <!-- navbar.html -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <div class="me-3">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
                </div>
                <div>
                    <a class="navbar-brand brand-logo" href="index.html">
                        <img src="img/logo.jpg" alt="logo" style="border-radius: 50%;" />
                    </a>

                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-top">
                <ul class="navbar-nav">
                    <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                        <h1 class="welcome-text">Welcom Back, <span class="text-black fw-bold">Admin</span></h1>
                        <h3 class="welcome-sub-text">Your performance summary this week </h3>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item d-none d-lg-block">
                        <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                            <span class="input-group-addon input-group-prepend border-right">
                                <span class="icon-calendar input-group-text calendar-icon"></span>
                            </span>
                            <input type="text" class="form-control">
                        </div>
                    </li>
                    <!-- mail -->
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                            <i class="icon-mail icon-lg"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
                            <a class="dropdown-item py-3 border-bottom">
                                <p class="mb-0 font-weight-medium float-left">You have 4 new notifications </p>
                                <span class="badge badge-pill badge-primary float-right">View all</span>
                            </a>
                            <a class="dropdown-item preview-item py-3">
                                <div class="preview-thumbnail">
                                    <i class="mdi mdi-alert m-auto text-primary"></i>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject fw-normal text-dark mb-1">Application Error</h6>
                                    <p class="fw-light small-text mb-0"> Just now </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item py-3">
                                <div class="preview-thumbnail">
                                    <i class="mdi mdi-settings m-auto text-primary"></i>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject fw-normal text-dark mb-1">Settings</h6>
                                    <p class="fw-light small-text mb-0"> Private message </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item py-3">
                                <div class="preview-thumbnail">
                                    <i class="mdi mdi-airballoon m-auto text-primary"></i>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject fw-normal text-dark mb-1">New user registration</h6>
                                    <p class="fw-light small-text mb-0"> 2 days ago </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <!-- notification -->
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon-bell"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
                            <a class="dropdown-item py-3">
                                <p class="mb-0 font-weight-medium float-left">You have 7 unread mails </p>
                                <span class="badge badge-pill badge-primary float-right">View all</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="images/faces/face10.jpg" alt="image" class="img-sm profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">Marian Garner </p>
                                    <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="images/faces/face12.jpg" alt="image" class="img-sm profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">David Grey </p>
                                    <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="images/faces/face1.jpg" alt="image" class="img-sm profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">Travis Jenkins </p>
                                    <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <!-- profile -->
                    <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                            <img class="img-xs rounded-circle" src="images/faces/face8.jpg" alt="Profile image">
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="ti-settings"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close ti-close"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border me-3"></div>Light</div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border me-3"></div>Dark</div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>
            <div id="right-sidebar" class="settings-panel">
                <i class="settings-close ti-close"></i>
                <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
                    </li>
                </ul>

                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                        <div class="add-items d-flex px-3 mb-0">
                            <form class="form w-100">
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                    <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                                </div>
                            </form>
                        </div>
                        <div class="list-wrapper px-3">
                            <ul class="d-flex flex-column-reverse todo-list">
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Team review meeting at 3.00 PM
                    </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Prepare for presentation
                    </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Resolve all the low priority tickets due today
                    </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li class="completed">
                                    <div class="form-check">
                                        <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Schedule meeting for next week
                    </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li class="completed">
                                    <div class="form-check">
                                        <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Project review
                    </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                            </ul>
                        </div>
                        <h4 class="px-3 text-muted mt-5 fw-light mb-0">Events</h4>
                        <div class="events pt-4 px-3">
                            <div class="wrapper d-flex mb-2">
                                <i class="ti-control-record text-primary me-2"></i>
                                <span>Feb 11 2018</span>
                            </div>
                            <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
                            <p class="text-gray mb-0">The total number of sessions</p>
                        </div>
                        <div class="events pt-4 px-3">
                            <div class="wrapper d-flex mb-2">
                                <i class="ti-control-record text-primary me-2"></i>
                                <span>Feb 7 2018</span>
                            </div>
                            <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
                            <p class="text-gray mb-0 ">Call Sarah Graves</p>
                        </div>

                    </div>
                    <div class="col-lg-4 d-flex flex-column">
                        <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card card-rounded">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h4 class="card-title card-title-dash">Todo list</h4>
                                                    <div class="add-items d-flex mb-0">
                                                        <!-- <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?"> -->
                                                        <button class="add btn btn-icons btn-rounded btn-primary todo-list-add-btn text-white me-0 pl-12p"><i class="mdi mdi-plus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="list-wrapper">
                                                    <ul class="todo-list todo-list-rounded">
                                                        <li class="d-block">
                                                            <div class="form-check w-100">
                                                                <label class="form-check-label">
                      <input class="checkbox" type="checkbox"> Lorem Ipsum is simply dummy text of the printing <i class="input-helper rounded"></i>
                    </label>
                                                                <div class="d-flex mt-2">
                                                                    <div class="ps-4 text-small me-3">24 June 2020</div>
                                                                    <div class="badge badge-opacity-warning me-3">Due tomorrow</div>
                                                                    <i class="mdi mdi-flag ms-2 flag-color"></i>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-block">
                                                            <div class="form-check w-100">
                                                                <label class="form-check-label">
                      <input class="checkbox" type="checkbox"> Lorem Ipsum is simply dummy text of the printing <i class="input-helper rounded"></i>
                    </label>
                                                                <div class="d-flex mt-2">
                                                                    <div class="ps-4 text-small me-3">23 June 2020</div>
                                                                    <div class="badge badge-opacity-success me-3">Done</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check w-100">
                                                                <label class="form-check-label">
                      <input class="checkbox" type="checkbox"> Lorem Ipsum is simply dummy text of the printing <i class="input-helper rounded"></i>
                    </label>
                                                                <div class="d-flex mt-2">
                                                                    <div class="ps-4 text-small me-3">24 June 2020</div>
                                                                    <div class="badge badge-opacity-success me-3">Done</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="border-bottom-0">
                                                            <div class="form-check w-100">
                                                                <label class="form-check-label">
                      <input class="checkbox" type="checkbox"> Lorem Ipsum is simply dummy text of the printing <i class="input-helper rounded"></i>
                    </label>
                                                                <div class="d-flex mt-2">
                                                                    <div class="ps-4 text-small me-3">24 June 2020</div>
                                                                    <div class="badge badge-opacity-danger me-3">Expired</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card card-rounded">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h4 class="card-title card-title-dash">Type By Amount</h4>
                                                </div>
                                                <canvas class="my-auto" id="doughnutChart" height="200"></canvas>
                                                <div id="doughnut-chart-legend" class="mt-5 text-center"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card card-rounded">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Leave Report</h4>
                                                    </div>
                                                    <div>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Month Wise </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                                <h6 class="dropdown-header">week Wise</h6>
                                                                <a class="dropdown-item" href="#">Year Wise</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <canvas id="leaveReport"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card card-rounded">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Top Performer</h4>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                                        <div class="d-flex">
                                                            <img class="img-sm rounded-10" src="images/faces/face1.jpg" alt="profile">
                                                            <div class="wrapper ms-3">
                                                                <p class="ms-1 mb-1 fw-bold">Brandon Washington</p>
                                                                <small class="text-muted mb-0">162543</small>
                                                            </div>
                                                        </div>
                                                        <div class="text-muted text-small">
                                                            1h ago
                                                        </div>
                                                    </div>
                                                    <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                                        <div class="d-flex">
                                                            <img class="img-sm rounded-10" src="images/faces/face2.jpg" alt="profile">
                                                            <div class="wrapper ms-3">
                                                                <p class="ms-1 mb-1 fw-bold">Wayne Murphy</p>
                                                                <small class="text-muted mb-0">162543</small>
                                                            </div>
                                                        </div>
                                                        <div class="text-muted text-small">
                                                            1h ago
                                                        </div>
                                                    </div>
                                                    <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                                        <div class="d-flex">
                                                            <img class="img-sm rounded-10" src="images/faces/face3.jpg" alt="profile">
                                                            <div class="wrapper ms-3">
                                                                <p class="ms-1 mb-1 fw-bold">Katherine Butler</p>
                                                                <small class="text-muted mb-0">162543</small>
                                                            </div>
                                                        </div>
                                                        <div class="text-muted text-small">
                                                            1h ago
                                                        </div>
                                                    </div>
                                                    <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                                        <div class="d-flex">
                                                            <img class="img-sm rounded-10" src="images/faces/face4.jpg" alt="profile">
                                                            <div class="wrapper ms-3">
                                                                <p class="ms-1 mb-1 fw-bold">Matthew Bailey</p>
                                                                <small class="text-muted mb-0">162543</small>
                                                            </div>
                                                        </div>
                                                        <div class="text-muted text-small">
                                                            1h ago
                                                        </div>
                                                    </div>
                                                    <div class="wrapper d-flex align-items-center justify-content-between pt-2">
                                                        <div class="d-flex">
                                                            <img class="img-sm rounded-10" src="images/faces/face5.jpg" alt="profile">
                                                            <div class="wrapper ms-3">
                                                                <p class="ms-1 mb-1 fw-bold">Rafell John</p>
                                                                <small class="text-muted mb-0">Alaska, USA</small>
                                                            </div>
                                                        </div>
                                                        <div class="text-muted text-small">
                                                            1h ago
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- To do section tab ends -->

                </div>
            </div>
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->

            <!-- Left Nav -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item ">
                        <a class="nav-link" href="admindashboard.php" >
                            <i class="mdi mdi-grid-large menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="admin_registration.php" target="_blank">
                            <i class="fa-sharp fa-solid fa-user-plus"  style="color: #283bb9;"></i>&nbsp;&nbsp;
                            <span class="menu-title" style="color: #283bb9;"><b>Add Admin Account</b></span>
                        </a>
                    </li>
                    <li class = "nav-item">
                        <a class="nav-link" href="#subscriptionTable">
                            <i class="fa-solid fa-file-pen" style="color: #283bb9;"></i>&nbsp;&nbsp;
                            <span class="menu-title" style="color: #283bb9;"><b>Edit Subscription</b></span>
                        </a>
                    </li>
                    <li class = "nav-item">
                        <a class="nav-link" href="#reportTable">
                            <i class="fa-solid fa-table" style="color: #283bb9;"></i>&nbsp;&nbsp;
                            <span class="menu-title" style="color: #283bb9;"><b>Report Tables</b></span>
                        </a>
                    </li>
                    <li class = "nav-item">
                        <a class="nav-link" href="#checkCustomerSubscription">
                            <i class="fa-solid fa-check" style="color: #283bb9;"></i></i>&nbsp;&nbsp;
                            <span class="menu-title" style="color: #283bb9;"><b>Check User Subscription</b></span>
                        </a>
                    </li>
                    <li class = "nav-item">
                        <a class="nav-link" href="#addStaff">
                        <i class="fa-solid fa-person-circle-plus fa-xl" style="color: #283bb9;"></i>&nbsp;&nbsp;
                            <span class="menu-title" style="color: #283bb9;"><b>Staff Registration</b></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="home-tab">
                                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                                    <div>
                                        <div class="btn-wrapper">
                                            <button  class="btn btn-otline-dark align-items-center" onclick="sendEmail()"><i class="icon-share"></i> Share</button>
                                            <button  class="btn btn-otline-dark text-dark me-0" id = "" onclick = "wprint()"><i class="icon-printer"></i> Print</button>
                                            <a href="contact_view.php" class = "ms-2" target="_blank"><button  class="btn btn-otline-dark text-dark me-0" ><i class="icon-printer"></i> Customer Contact</button></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content tab-content-basic">
                                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                                        
                                        <div class="row">
                                            <div class="col-lg-8 d-flex flex-column">
                                                <div class="row flex-grow">
                                                    <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                                        <div class="card card-rounded">
                                                            <div class="card-body">
                                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                                    <div>
                                                                        <h4 class="card-title card-title-dash">Performance Line Chart</h4>

                                                                    </div>
                                                                    <div id="performance-line-legend"></div>
                                                                </div>
                                                                <div class="chartjs-wrapper mt-5">
                                                                    <canvas id="performaneLine"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 d-flex flex-column">
                                                <div class="row flex-grow">
                                                    <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                                                        <div class="card bg-primary card-rounded">
                                                            <div class="card-body pb-0">
                                                                <h4 class="card-title card-title-dash text-white mb-4">Status Summary</h4>
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <p class="status-summary-ight-white mb-1">Closed Value</p>
                                                                        <h2 class="text-info">357</h2>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="status-summary-chart-wrapper pb-4">
                                                                            <canvas id="status-summary"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                                                        <div class="card card-rounded">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0">
                                                                            <div class="circle-progress-width">
                                                                                <div id="totalVisitors" class="progressbar-js-circle pr-2"></div>
                                                                            </div>
                                                                            <div>
                                                                                <p class="text-small mb-2">Total Visitors</p>
                                                                                <h4 class="mb-0 fw-bold">26.80%</h4>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <div class="circle-progress-width">
                                                                                <div id="visitperday" class="progressbar-js-circle pr-2"></div>
                                                                            </div>
                                                                            <div>
                                                                                <p class="text-small mb-2">Visits per day</p>
                                                                                <h4 class="mb-0 fw-bold">9065</h4>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <!-- Edit subscription type -->
                                        
                                        <div class="row">
                                            <div class="subTable col-sm-12 col-lg-12 col-xl-12">
                                                <form method = 'POST'  id = 'subscriptionTable'>
                                                    <table class= "table table-dark">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Price</th>
                                                                        <th>Access Content</th>
                                                                        <th>Validity</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                       
                                                                <?php
                                                                    include('connection.php');
                                                                    $query = "select * from `subscription`";
                                                                    $temp = "";
                                                                    $result = $conn->query($query);
                                                                    if ($result->num_rows>0) {
                                                                        $rowCount = $result->num_rows;                                                    
                                                                        for ($i=0; $i < $rowCount; $i++) { 
                                                                            $row = $result -> fetch_assoc();
                                                                            ?>
                                                                         <tr>
                                                                            <td><?php echo $row["s_name"]; ?></td>
                                                                            <td><?php echo $row["s_price"]; ?></td>
                                                                            <td><?php echo $row["s_accesscontent"]; ?></td>
                                                                            <td><?php echo $row["s_validity"]; ?></td>
                                                                            <td><button type = "submit" value = "<?php echo $row["s_id"]; ?>" name = "btnEdit" class = "btn btn-danger">
                                                                            <i class="fa-solid fa-pen-to-square" ></i>Edit</button></td>
                                                                        </tr>
                                                                           
                                                                        <?php
                                                                        }
                                                                        
                                                                    }
                                                                         ?>
                                                               
                                                                </tbody>
                                                        </table>
                                                </form>
                                            </div>
                                        </div> 

                                        <!-- Report Table -->
                                        
                                       <div class="row">
                                        <!-- Top Ranking Movie -->
                                        <div class="col-sm-12 col-lg-4 col-xl-4 text-center">
                                            <div class="card mt-3 bg-dark" >
                                                    <div class="card-body ">
                                                        <h2 class = " mb-2 text-white">Top Ranking Movie</h2>
                                                                <table class = "table table-dark ms-xl-4" id = "reportTable">
                                                                    
                                                                    <tbody>
                                                                        <tr id = 'main' ></tr>
                                                                    </tbody>
                                                                </table>
                                                            
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col">
                                            <!-- Monthly Report -->
                                            <div class="card bg-dark text-white mt-3">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        <h3 class = "text-white text-center mt-2">Monthly Reports</h3>
                                                    </div>
                                                    
                                                   <form action="" method="post">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary  dropdown-toggle text-dark px-5" role="button" id="dropdownMenuLink"  
                                                        data-bs-toggle="dropdown" aria-expanded="false"> Year </button>
                                                        <ul class="dropdown-menu  bg-secondary" aria-labelledby="dropdownMenuLink">
                                                           
                                                            <li class="dropdown dropend ">
                                                                <button class="dropdown-item dropdown-toggle bg-secondary "  id="multilevelDropdownMenu1"  data-bs-toggle="dropdown"
                                                                 aria-haspopup="true" aria-expanded="false">2021</button>
                                                                <ul class="dropdown-menu bg-secondary" aria-labelledby="multilevelDropdownMenu1">
                                                                    
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('1','21')" name = "btnJan">January</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('2','21')" name = "btnFeb">February</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('3','21')" name = "btnMar">March</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('4','21')" name = "btnApr">April</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('5','21')" name = "btnMay">May</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('6','21')" name = "btnJun">June</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('7','21')" name = "btnJul">July</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('8','21')" name = "btnAug">August</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('9','21')" name = "btnSep">September</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('10','21')" name = "btnOct">October</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('11','21')" name = "btnNov">November</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('12','21')" name = "btnDec">December</button></li>
                                                                    
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown dropend ">
                                                                <button class="dropdown-item dropdown-toggle bg-secondary "  id="multilevelDropdownMenu1" 
                                                                 data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">2022</button>
                                                                <ul class="dropdown-menu bg-secondary" aria-labelledby="multilevelDropdownMenu1">
                                                                    
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('1','22')" name = "btnJan">January</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('2','22')" name = "btnFeb">February</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('3','22')" name = "btnMar">March</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('4','22')" name = "btnApr">April</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('5','22')" name = "btnMay">May</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('6','22')" name = "btnJun">June</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('7','22')" name = "btnJul">July</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('8','22')" name = "btnAug">August</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('9','22')" name = "btnSep">September</button></li>
                                                                    <li><button class="dropdown-item text-white bg-secondary" type = "submit" onclick = "getData('10','22')" name = "btnOct">October</button></li>
                                                                    
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                   </form>
                                                   
                                                </div>
                                                <div class="card-body">
                                                    <?php
                                                        include ('connection.php');
                                                        $temp = "";
                                                        $r_month = 0;
                                                        $r_year = 0;
                                                        if (isset($_COOKIE['r_month']) && isset($_COOKIE['r_year'])) {
                                                            $r_month = $_COOKIE['r_month'];
                                                            $r_year = $_COOKIE['r_year'];
                                                            $query = "select * from `report` where `month` = '$r_month' and `year` = '$r_year'";
                                                            $result = $conn->query($query);
                                                            if ($result->num_rows > 0) { 
                                                                $row = $result->fetch_assoc();
                                                               
                                                                $temp .= "
                                                                <table class='table table-dark'>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Report ID</td>
                                                                            <td class = 'fw-bold'>{$row['report_id']}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Gain</td>
                                                                            <td class = 'fw-bold'>{$row['gain']}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Expense</td>
                                                                            <td class = 'fw-bold'>{$row['expense']}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Loss</td>
                                                                            <td class = 'fw-bold'>{$row['loss']}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Net-Profit</td>
                                                                            <td class = 'fw-bold'>{$row['net_profit']}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Month</td>
                                                                            <td class = 'fw-bold'>{$row['month']}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Year</td>
                                                                            <td class = 'fw-bold'>20{$row['year']}</td>
                                                                        </tr>                     
                                                                    </tbody>
                                                                </table>
                                                                ";
                                                                
                                                            }
                                                            
                                                            echo $temp;
                                                            echo "<script>document.cookie = 'r_month=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/m-paradise;'</script>";
                                                            echo "<script>document.cookie = 'r_year=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/m-paradise;'</script>";
                                                            
                                                        }else{
                                                            $month = (int)date('m');
                                                            $month = $month-1;
                                                            $year = (int)date('y');
                                                            $query = "select * from `report` where `month` = '$month' and `year` = '$year'";
                                                            $result = $conn->query($query);
                                                            if ($result->num_rows > 0) { 
                                                                $row = $result->fetch_assoc();
                                                               
                                                                $temp .= "
                                                                <table class='table table-dark'>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Report ID</td>
                                                                            <td class = 'fw-bold'>{$row['report_id']}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Gain</td>
                                                                            <td class = 'fw-bold'>{$row['gain']}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Expense</td>
                                                                            <td class = 'fw-bold'>{$row['expense']}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Loss</td>
                                                                            <td class = 'fw-bold'>{$row['loss']}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Net-Profit</td>
                                                                            <td class = 'fw-bold'>{$row['net_profit']}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Month</td>
                                                                            <td class = 'fw-bold'>{$row['month']}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class = 'fw-bold'>Year</td>
                                                                            <td class = 'fw-bold'>20{$row['year']}</td>
                                                                        </tr>                     
                                                                    </tbody>
                                                                </table>
                                                                ";
                                                                
                                                            }
                                                            
                                                            echo $temp;
                                                        }
                                                    ?>
                                                </div>
                                               
                                            </div>
                                            <!-- Staff Registration -->
                                            <div class="card  bg-dark text-white mt-4" id = "addStaff">
                                                <div class="card-header">
                                                    <div class="card-title text-white text-center mt-2">
                                                        <h3> Staff Registration Form</h3>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                <form action="" method = "POST">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="staff_name" name = "staff_name" class="form-control form-control-lg text-white bg-dark" placeholder="Staff Name" />
                                                        <label class="form-label text-white" for="staff_name">Enter Staff Name</label>
                                                    </div>   
                                                    <div class="form-floating mb-3">
                                                        <input type="email" id="staff_email" name = "staff_email" class="form-control form-control-lg text-white bg-dark" placeholder="Staff Email" />
                                                        <label class="form-label text-white" for="staff_email">Enter Staff Email</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="staff_phone" name = "staff_phone" class="form-control form-control-lg text-white bg-dark" placeholder="Staff Phone" />
                                                        <label class="form-label text-white" for="staff_phone">Enter Staff Phone</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="staff_dept" name = "staff_dept" class="form-control form-control-lg text-white bg-dark" placeholder="Staff Department" />
                                                        <label class="form-label text-white" for="staff_dept">Enter Staff Deptartment</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="staff_salary" name = "staff_salary" class="form-control form-control-lg text-white bg-dark" placeholder="Staff Salary" />
                                                        <label class="form-label text-white" for="staff_salary">Enter Staff Salary</label>
                                                    </div>
                                                    <button class="btn btn-secondary px-5 mt-2" name = "btnAddStaff" type = "submit">Submit</bu>
                                                </form>
                                                </div>
                                               
                                            </div>
                                        </div>
                                       </div>
                                       <div class="row">
                                            <!-- RemoveUser -->
                                            <div class="col-sm-12 col-lg-6 col-xl-6">
                                                <div class="card mt-3 mb-3 bg-dark" >
                                                    <div class="card-header ">
                                                        <div class="card-title text-center mt-3 text-white">Total Visitor Report</div>
                                                    </div>
                                                    <div class="card-body mb-3">
                                                        <table class = "table table-dark mt-2 mb-2">
                                                            <thead>
                                                                <tr>
                                                                    <th>Today</th>
                                                                    <th>This Week</th>
                                                                    <th>This Month</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>9,100</td>
                                                                    <td>63,500</td>
                                                                    <td>253,820</td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12 col-lg-6 col-xl-6">
                                            <div class="card mt-3 mb-3 bg-dark" id = "checkCustomerSubscription">
                                                    <div class="card-header ">
                                                        <div class="card-title text-center mt-3 text-white">Check User Subscription</div>
                                                    </div>
                                                    <div class="card-body mb">
                                                        <form action="" method="post">   
                                                            <div class="form-floating mb-4 mt-3">
                                                                <input type="text" id="form3Example3" name = "cus_id" class="form-control form-control-lg text-white bg-dark" placeholder="Customer Id" />
                                                                <label class="form-label text-white" for="form3Example3">Enter Customer ID</label>
                                                            </div>
                                                            <button name = "btnCheck" class = "btn btn-danger px-5">Check </button>
                                                        </form>
                                                    </div>
                                                </div>                                         
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js" integrity="sha512-aUhL2xOCrpLEuGD5f6tgHbLYEXRpYZ8G5yD+WlFrXrPy2IrWBlu6bih5C9H6qGsgqnU6mgx6KtU8TreHpASprw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
   
//         function getCookie(cname) {
//   let name = cname + "=";
//   let decodedCookie = decodeURIComponent(document.cookie);
//   let ca = decodedCookie.split(';');
//   for(let i = 0; i <ca.length; i++) {
//     let c = ca[i];
//     while (c.charAt(0) == ' ') {
//       c = c.substring(1);
//     }
//     if (c.indexOf(name) == 0) {
//       return c.substring(name.length, c.length);
//     }
//   }
//   return "";
// }
// sessionStorage.setItem("name", "Smith");


        const API_URL = 'https://api.themoviedb.org/3/movie/top_rated?api_key=fbbeb706c06538590401bc4a736873b1&language=en-US&page=1';
        const main = document.getElementById('main');
        var temp;
        let dropdowns = document.querySelectorAll('.dropdown-toggle');
        dropdowns.forEach((dd)=>{
            dd.addEventListener('click', function (e) {
                var el = this.nextElementSibling
                el.style.display = el.style.display==='block'?'none':'block'
            })
        })
        function deleteUser(){
            if (confirm('ARE YOU SURE WANT TO DELETE THIS USER ?')) {
                document.cookie = `status=true;` ;
            }
        }
        function showMovies(data) {
            
            data.forEach(movie => {
                const {
                    title,
                    vote_average
            } = movie;
            const movieElement = document.createElement('tbody');
            movieElement.innerHTML = `
           
                <td>${title}</td>
                <td>${vote_average}</td>
          
           `;  
           main.appendChild(movieElement);  
            });       
        }
        
        function getMovie(url) {
            fetch(url).then(res => res.json()).then(data => {
                showMovies(data.results);
            });
        }
        function getData(month,year){
            document.cookie = `r_month=${month}`;
            document.cookie = `r_year=${year}`;
        }
        getMovie(API_URL);
        // function edit(id){
        //     document.cookie = `sub_id=${id};` ;
        // }
        function wprint(){
            window.print();
        }
        function sendEmail() {
          Email.send({
          Host: "khnnyein1304@gmail.com",
          Username : "khnnyein1304@gmail.com",
          Password : "123456",
          To : 'omnilegentdora@gmail.com',
          From : "khnnyein1304@gmail.com",
          Subject : "Weekly Report",
          Body : "Report file",
          Attachments : [
            {
                name : "smtpjs.png",
                path:"https://drive.google.com/file/d/16ASo_Ny-9glmDkh1GYWlb-Kuamh6ddeU/view?usp=sharing"
            }]
          }).then(
            message => alert("mail sent successfully")
          );
        }
    </script>
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="vendors/progressbar.js/progressbar.min.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="js/jquery.cookie.js" type="text/javascript"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/Chart.roundedBarCharts.js"></script>
    <!-- End custom js for this page-->
</body>

</html>