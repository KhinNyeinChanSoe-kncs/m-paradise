<?php
    include ('connection.php');
    error_reporting(E_ERROR | E_PARSE);
    
    if (isset($_COOKIE['email'])) {
        if (isset($_POST['logout'])) {
            $userEmail = $_COOKIE['email'];
            $userPassword = $_COOKIE['password'];
            setcookie("email",$userEmail,time()-3600*12);
            setcookie("password",password_hash($userPassword,PASSWORD_BCRYPT),time()-3600*12);
           
            // echo "<script>window.location.href = 'user_login.php'</script>";
        }
        if (isset($_POST['btnDownload'])) {
            include ('connection.php');
            $email = $_COOKIE['email'];
            $query = "select `s_id` from `customer` where `email` = '$email'";
            $result = $conn->query($query);
            if ($result->num_rows>0) {
                $row = $result->fetch_assoc();
                $sId = $row['s_id'];
                if ( $sId == "0") {
                    echo "<script>alert('You don\'t have access to this feature!!');</script>";
                }else{
                    $sts = 1;
                    $title = $_COOKIE['img_title'];
                    $url_to_image = $_COOKIE['img_path'];
                    $ch = curl_init($url_to_image);

                    $my_save_dir = 'downloadImage/';

                    $filename = $title.'.jpg';
                    $complete_save_loc = $my_save_dir.$filename;
                    $fp = fopen($complete_save_loc,'wb');
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_exec($ch);
                    curl_close($ch);
                    fclose($fp); 
                    
                    setcookie("img_title","",time()-1200);
                    setcookie("img_path","",time()-1200);
                    if ($sts== 1) {
                        echo "<script>alert('Download Successful!!');</script>";
                       
                    }
                    
                }
            }
            $sts = 0;
        } 
    }
    else {
        if (isset($_COOKIE['img_path'])) {
            $url = $_COOKIE['img_path'];
            setcookie("img_path",$url,time()-3600);
        }
        if (isset($_COOKIE['img_title'])) {
            $title = $_COOKIE['img_title'];
            setcookie("img_title",$title,time()-3600);
        }
        if (isset($_POST['btnDownload'])){
            echo "<script>alert('Be a subscriber and watch unlimited movies');</script>";
        }
        
    }
    
    $conn->close();
?>
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
        * {
            font-family: 'Lato', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
       
        .navbarLogo {
            width: 40px;
            height: 9%;
            border-radius: 50%;
        }
        #search-input {
            width: 100px;
        }
        .poster {
            width: 100%;
            height: 450px;
            object-fit: contain;
        }
        .navbar {
            font-size: 18px;
        }
        .cardImg{
            width: 80%;
            height: 250px;
            object-fit : contain; 
        }

        .detailsImg{
            width : 100%;
            height : 450px;
            object-fit : contain;
        }
        .movieDiv{
            width : 25%;
        }
        .movieCard{
            width: 100%;
            transition: 0.5s;
        }
        .movieCard:hover{
            transform: scale(1.025);
            filter: drop-shadow(1px 1px 20px #757575);
        }
        @media only screen and (max-width: 768px){
            .movieDiv{
                width : 80%;
                margin-end : 50px;
            }
            .movieCard{
                width: 100%;
            }
        }
        @media only screen and (max-width: 992px){
            .movieDiv{
                width: 50%;
                margin-end: 50px;
            }
        }
        @media only screen and (max-width: 604px){
            .movieDiv{
                width : 80%;
                margin-end : 50px;
            }
            .movieCard{
                width: 100%;
            }
            .modal{
                width : 100%;
                /* margin-start : 20px; */
            }
            .card{
                height : 350px;
            }
            .cardImg{
                width: 80%;
                height: 150px;
                object-fit : contain; 
            }
            .poster {
                width: 100%;
                height: 200px;
                object-fit: contain;
            }
            #search-input {
                width: 80px;
            }
        }
        .search:focus{
            background-color : #000;
        }
        
    </style>
</head>

<body class="bg-black">
    <div class="container">
        <div class="nav mb-3">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark hover-shadow  w-100">
                <!-- Container wrapper -->
                <div class="container">
                    <!-- Toggle button -->
                    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                  </button>
                    <!-- Collapsible wrapper -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Navbar brand -->
                        <a class="navbar-brand mt-2 mt-lg-0" href="index.html">
                            <img src="img/logo.jpg" class="navbarLogo mt5" alt="Brand Logo" loading="lazy">
                        </a>
                        <label class="text-light ms-1">M-Paradise</label>
                        <!-- Left links -->
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-2">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="index.php">Home</a>
                            </li>

                            <li class="nav-item ms-2">
                                <a href="subscription.php" class="nav-link text-light">Subscription</a>
                            </li>
                        </ul>

                    </div>
                    <!-- Right elements -->
                    <div class="d-flex align-items-center">
                        <!-- Search Bar -->
                        <div class="form input-group me-2" id = "form">
                            <div class="form-outline">
                                <input id="search" type="text"  class="form-control text-light" />
                                <label class="form-label text-white" for="search">Search</label>
                            </div>
                            <button id="searchButton" type="button" class="btn btn-outline-light">
                              <i class="fas fa-search text-light"></i>
                            </button>
                        </div>
                        <!-- Avatar -->
                        <div class="dropdown ms-xl-3 ms-lg-2">
                            <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                <img src="img/avatar.jpg" class="rounded-circle" height="25" alt="Black and White Portrait of a Man" loading="lazy" />
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                                <li>
                                    <a class="dropdown-item" href="profile.php">My profile</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Setting -->
                        <div class="dropdown ms-xl-2 ms-lg-2 ">
                            <a class="text-reset me-3 dropdown-toggle hidden-arrow " href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-gear text-white"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                                <li>
                                    <a class="dropdown-item" href="user_subscription_history.php" target = "_blank"><button class = "btn btn-link text-dark">History</button></a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="contactus.php" target = "_blank"><button class = "btn btn-link text-dark">Contact</button></a>
                                </li>
                                <li>
                                    <a class="dropdown-item " href="#" id = "logout">
                                      <form action="" method = "POST"><button class = "btn btn-link text-dark" name = "logout">Logout</button></form>
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    <!-- Right elements -->
                </div>
                <!-- Container wrapper -->
            </nav>
            <!-- Navbar -->
        </div>
    </div>
    <div class="container ">
        <div class="row">
            <div class="d-sm-block col-lg-1 col-xl-1"></div>
            <div class="col-sm-12 col-lg-10 col-xl-10">
                <div id="carouselExampleControls" class="slideshow carousel slide my-5  w-100" data-mdb-ride="carousel">
                    <div class="carousel_images carousel-inner w-100 ">
                        <div class="carousel-item active rounded">
                            <img src="img/the-sandman-what-we-know-so-far.avif" class="poster  w-100  rounded" />
                        </div>
                        <div class="carousel-item rounded">
                            <img src="img/Luck.jpeg" class="poster  w-100  rounded" />
                        </div>
                        <div class="carousel-item rounded">
                            <img src="img/toalltheboy.png" class="poster  w-100  rounded" />
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleControls" data-mdb-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleControls" data-mdb-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="d-sm-block col-lg-1 col-xl-1"></div>
        </div>
        <div class="row mb-3" id = "main">
        </div>
        <div class='modal fade mt-xl-5 mt-lg-5 mt-sm-2  mx-xl-2 mx-lg-2 mb-5' id='detailsModal'   tabindex='-1' aria-labelledby='detailsModalLabel' aria-hidden='true'>
           <div class='modal-dialog'>
             <div class='modal-content'>
                  <div class='modal-header'>
                    <h5 class='modal-title fw-bolder' id='title_modal'></h5>
                    <button type='button' class="btn-close" data-mdb-dismiss='modal' aria-label='Close'></button>
                  </div>
                  <div class='modal-body' id = "modal_body">
                    <div id="image_modal" class ="mb-2"></div>
                    <small id = "overview_modal" class = "fw-bold mt-2">Overview : &nbsp;&nbsp;
                    
                    </small>
                  </div>
                  <form method = "POST" class = "mb-sm-2 mt-sm-2 mb-xl-3 mb-lg-3">
                    <div  class='modal-footer '>
                        <button type='button' class='btn btn-secondary' data-mdb-dismiss='modal'>Close</button>
                        <button  id = 'btnDownload' name = 'btnDownload' type = "submit" class='btn btn-dark'>Download</button>
                    </div>
                  </form>
                </div>
              </div>
    </div>
    <script>  
            const API_KEY = 'api_key=fbbeb706c06538590401bc4a736873b1';
            const BASE_URL = 'https://api.themoviedb.org/4';
            const API_URL = BASE_URL + '/discover/movie?sort_by=popularity.desc&' + API_KEY;
            const SEARCH_URL = BASE_URL + '/search/movie?'+ API_KEY;
            const MODAL_URL = 'https://api.themoviedb.org/3/movie/';
            const IMG_URL = 'https://image.tmdb.org/t/p/w500';
            const main = document.getElementById('main');
            const searchInput = document.getElementById('search');
            const searchBtn = document.getElementById('searchButton');
        
            searchBtn.addEventListener('click',(e) => {
                e.preventDefault();
                const searchTerm = searchInput.value;
                if (searchTerm) {
                    searchMovie(SEARCH_URL + '&query=' + searchTerm);
                }
            });
            function showMovies(data) {
                main.innerHTML = ''; 
                data.forEach(movie => {
                    const {
                    id,
                    title,
                    poster_path,
                    original_language,
                    overview,
                    release_date,
                    genre_ids
                } = movie;
               
               const movieElement = document.createElement('div');
               movieElement.className = "movieDiv";
               movieElement.innerHTML = `
                        <div class="movieCard card mb-3 col-sm-10 col-lg-3 col-xl-3 ms-5 mt-xl-3 mt-lg-3 mt-sm-1">
                            <div class="card-header text-center">
                                   <img src="${IMG_URL+poster_path}"   class="cardImg img-fluid rounded " />
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold" id = "title"> ${title}</h5>
                                <p class="card-text mb-2">
                                   <small> Release Date : ${release_date}<br>
                                       Language : ${original_language}
                                   </small>
                                </p>
                    
                                    <button type="button" class="btn btn-dark btn-rounded px-5 me-2" data-mdb-toggle="modal" data-mdb-target="#detailsModal" 
                                   id= "viewMore" name = "btnViewMore" style = "float: right;" onclick = "passData(${id})" >View More
                                    </button>
                            </div>
                        </div>
               `;
               
               main.appendChild(movieElement);  
                });       
            }
            function getMovie(url) {
                fetch(url).then(res => res.json()).then(data => {
                    showMovies(data.results);
                });
            }
            function searchMovie(url){
                fetch(url).then(res => res.json()).then(data => {
                    showMovies(data.results);
                });
            }
            function passData(id){
                const DETAIL_MOVIE =   MODAL_URL + id + '?' + API_KEY;
                fetch(DETAIL_MOVIE).then(res=> res.json()).then(data=>{
                    showModal(data);
                });
            }
            function showModal(data){
                var title = document.getElementById('title_modal');
                var overview = document.getElementById('overview_modal');
                var img = document.getElementById('image_modal');
                var btnDownload = document.getElementById('btnDownload');

                //add data into modal
                title.innerHTML = data.title;
                overview.innerHTML = 'Overview : ' + data.overview;
                img.innerHTML = `<img src='${IMG_URL + data.poster_path}' id = 'poster'  class='detailsImg img-fluid rounded ' />`;  
                document.cookie = `img_path = ${IMG_URL + data.poster_path}; `;
                document.cookie = `img_title = ${data.title};`;
            }
            getMovie(API_URL);
    </script>
  
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.15/plugins/export/libs/FileSaver.js/FileSaver.min.js"></script>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
</body>

</html>