<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Discuss Forum</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'?>
    <?php include 'partials/_header.php'?>
    <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE categories_id=$id";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
         $catname = $row['categories_name'];
         $catdesc = $row['categories_description'];
        }
    
    ?>

    <?php
        $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if($method=='POST'){
            $th_title = $_POST['title'];
            $th_desc = $_POST['desc'];

            $th_title = str_replace("<","&lt;",$th_title);
            $th_title = str_replace(">","&gt;",$th_title);

            $th_desc = str_replace("<","&lt;",$th_desc);
            $th_desc = str_replace(">","&gt;",$th_desc);

            $sno = $_POST['sno'];
            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            if($showAlert){
                echo'
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success !</strong> Your Thread are added Successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
        }
    ?>

    <div class="container my-4">
        <div class="card mb-3">
            <img src="img/card-<?php echo $id;?>.jpg" height="350px" class="card-img-top" alt="...">
            <div class="card-body">
                <h3 class="card-title">Welcome to <?php echo $catname;?></h3>
                <p class="card-text"><?php echo $catdesc;?></p>
                <p class="card-text"><small class="text-muted">Develoved By : <b>Shivam Vishwakarma</b></small></p>
            </div>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=="true"){
    echo '<div class="container">
        <h2 class="py-2">Start A Discussion :</h2>
        <form action=" ' . $_SERVER["REQUEST_URI"] . ' " method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We\'ll never share your email with anyone else.</div>
            </div>
            <input type="hidden" name="sno" value="' . $_SESSION['sno'] . '">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Problem Description</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>';
    }
    else{
        echo '
        <div class="container">
        <h2 class="py-2">Start A Discussion :</h2>
            <p class="lead">You are not loggedin. Please Login to Start a Discussion</p>
        </div>
        ';
    }
    ?>


    <div class="container my-3">
        <h1 class="py-2">Browse Questions :</h1>

        <?php
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
            $result = mysqli_query($conn,$sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);

                
                echo
                '<div class="media container my-3">

                    <img src="img/user.png" width="34px" class="mr-3" alt="...">
                    <div class="fw-bolder my-0">Asked By : ' . $row2['user_email'] . ' .   at ' . $thread_time . ' 
                    </div>
                        <h5  class="mt-0"><a class="text-dark text-decoration-none" href="thread.php?threadid=' . $id .'">' . $title . '</a></h5>
                        ' . $desc . '
                </div>';
            }


            // echo var_dump($noResult);
            if($noResult){
                echo' 
                <div class="container-fluid">
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <h1 class="display-4">No Data Found</h1>
                            <p class="lead">Be the 1st member of the Discussion.</p>
                        </div>
                    </div>
                </div>'
                ;
            }
            
        ?>

    </div>


    <?php include 'partials/_footer.php'?>



    <!-- <h1>Welcome to Online Forum</h1> -->





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script> -->

</body>

</html>