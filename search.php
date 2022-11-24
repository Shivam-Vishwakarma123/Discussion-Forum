<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">


    <style>
    /* .container {
        min-height: 70vh;
    } */
    </style>

    <title>Discuss Forum</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'?>
    <?php include 'partials/_header.php'?>




    <div class="container my-4">
        <h1 class="py-3">Search Result for <em>"<?php echo $_GET['search']?>"</em></h1>
        <?php 
            $noResult = true;
            $query = $_GET['search'];
            $sql = "SELECT * FROM `threads` WHERE MATCH (thread_title,thread_desc) against ('$query')";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $thread_id = $row['thread_id'];
                $url = "thread.php?threadid=". $thread_id;
                $noResult = false;
                echo '
                    <div class="result">
                        <h3><a href="' . $url . '" class="text-dark text-decoration-none">' . $title . '</a></h3>
                        <p>' . $desc . '</p>
                    </div>
                ';
            }
            if($noResult){
                echo '<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <h1 class="display-4"> Not Result Found </h1>
                        <p class="lead">
                          <ul>
                            <li>Your search did not match any documents.</li>
                            <li>Suggestions :</li>
                            <li>Make sure that all words are spelled correctly.</li>
                            <li>Try different keywords.</li>
                          </ul>
                        </p>
                    </div>
                </div>';
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
    <!--     
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
</body>

</html>