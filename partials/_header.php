<?php
    session_start();
    echo'
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Shivam Forum</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.php">About</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Top Categories
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
    
              $sql = "SELECT categories_name,categories_id FROM `categories`";
              $result = mysqli_query($conn,$sql);
              while($row = mysqli_fetch_assoc($result)){
                echo '<li><a class="dropdown-item" href="threads.php?catid=' . $row['categories_id'] . '">' . $row['categories_name'] . '</a></li>';
              }
    
                
              echo '</ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact</a>
            </li>
          </ul>';
    
          
          if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=="true"){
          echo '<form class="d-flex" action="search.php" method="get">
            <div class="text-light my-2 mx-0 container">' . $_SESSION['useremail'] . ' </div>
            <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Search</button>
            <a href="partials/_logout.php"> <button type="button" class="btn btn-outline-success mx-2">Logout</button>
          </a>';
          }
          else{
          echo '<form class="d-flex" action="search.php" method="get">
            <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Search</button>
            <button type="button" class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button>
          </form>';
          }
    
        echo '</div>
      </div>
    </nav>
    ';
    
    include 'partials/_loginModals.php';
    include 'partials/_signupModals.php';
    
    if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
      echo '
      <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Success !</strong> You can Login.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      ';
    }
?>