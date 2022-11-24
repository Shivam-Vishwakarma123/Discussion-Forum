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
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
         $title = $row['thread_title'];
         $desc = $row['thread_desc'];
         $thread_user_id = $row['thread_user_id'];
         $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
         $result2 = mysqli_query($conn,$sql2);
         $row2 = mysqli_fetch_assoc($result2);
         $posted_by = $row2['user_email'];
        }
    
    ?>

    <?php
        $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if($method=='POST'){
            $comment = $_POST['comment'];

            $comment = str_replace("<","&lt;",$comment);
            $comment = str_replace(">","&gt;",$comment);

            $sno = $_POST['sno'];
            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            if($showAlert){
                echo'
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success !</strong> Your Comment has been added Successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
        }
    ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title;?></h1>
            <p class="lead"><?php echo $desc;?></p>
            <hr class="my-4">
            <p>Maintain the Dignity Here.</p>
            <p>Posted By : <b><?php echo $posted_by; ?></b></p>
        </div>
    </div>
    <hr>

    <?php
    
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=="true"){
        echo '
        <div class="container my-3">
            <h2 class="py-2">Post Comment :</h2>
            <form action=" ' . $_SERVER["REQUEST_URI"] . ' " method="post">
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Comment Here</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    <input type="hidden" name="sno" value="' . $_SESSION['sno'] . '">
                </div>
            <button type="submit" class="btn btn-primary">Comment</button>
            </form>
        </div>';
    }
    else{
        echo '
        <div class="container">
            <h2 class="py-2">Post a Comment :</h2>
            <p class="lead">You are not loggedin. Please Login to post a comment</p>
        </div>
        ';
    }
  ?>


    <div class="container my-3">
        <h1 class="py-2">Comment :</h1>

        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn,$sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
         $noResult = false;
         $id = $row['comment_id'];
         $content = $row['comment_content'];
         $comment_time = $row['comment_time'];
         $thread_user_id = $row['comment_by'];
         $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
         $result2 = mysqli_query($conn,$sql2);
         $row2 = mysqli_fetch_assoc($result2);

             
            echo
            '<div class="media my-3">
                <img src="img/user.png" width="34px" class="mr-3" alt="...">
                <div class="media-body">
                <p class="fw-bolder">' . $row2['user_email'] . ' at ' . $comment_time . ' </p>
                    ' . $content . '
                </div>
            </div>';

        }
        // echo var_dump($noResult);
        if($noResult){
            echo' 
            <div class="container-fluid">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <h1 class="display-4">No Comment Found</h1>
                        <p class="lead">Be the 1st member to Comment.</p>
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