<?php

$loggedin = FALSE;
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {
  $loggedin = TRUE;
}?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Code-talks</title>
    <style>
        @media(min-height:300px) {
            #ques {
                min-height: 86vh;
            }
        }
    </style>
</head>

<body>
    <?php include 'partials/header.php';
    include "partials/dbconnect.php";
    $id = $_GET['catid'];
    $sql = "SELECT * FROM categories WHERE category_id=$id";
    $res = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        $cat = $row['catergory_name'];
        $desc = $row['category_description'];
    }
    ?>
    <?PHP 
    ;
    if($_SERVER['REQUEST_METHOD']=='POST'){
        //INSERT
        $th_title=$_POST['tittle'];
        $th_desc=$_POST['desc'];
        $th_desc=str_replace("<","&lt;",$th_desc);
        $th_desc=str_replace(">","&gt;",$th_desc);
        $th_title=str_replace("<","&lt;",$th_title);
        $th_title=str_replace(">","&gt;",$th_title);
        $sno=$_SESSION['sno'];
        echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your question has been posted......
        Wait for community to respond.. 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        $sql = "INSERT INTO threads 
        VALUES(NULL,'$th_title','$th_desc','$id','$sno',current_timestamp()) ";
        $resl=mysqli_query($conn,$sql);
        
    }
    
        
    ?>



    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><em><?php echo $cat ?></em></h1>
            <p class="lead"><?php echo $desc ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post questions. Remain respectful of other members at all times.</p>
        </div>


    </div>
    <div class="container" id="ques">
        <h3>
            Browse questions:</h3>
            <?php 
            if($loggedin){
            echo'<form action="'.$_SERVER['REQUEST_URI'].'" method="post"> 
            <div class="mb-3">
                <h5>Post your question</h5>
                <input type="text" class="form-control mb-2" aria-describedby="emailHelp" placeholder="Title" id="tittle" name="tittle">


                <textarea class="form-control" aria-label="With textarea" placeholder="Descripition..."id="desc" name="desc"></textarea>

            </div>
            <button type="submit" class="btn btn-primary">Post</button>
        </form>';}
        else{
            echo'<div class="alert alert-light" role="alert">
            login to post a question....
          </div>';
        }
        ?>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM threads WHERE threads_cat_id=$id";
        $res = mysqli_query($conn, $sql);
        $got = TRUE;
        while ($row = mysqli_fetch_assoc($res)) {
            $got = FALSE;
            $title = $row['threads_tittle'];
            $desc = $row['threads_desc'];
            $time=$row['timestamp'];
            $id = $row['threads_id'];
            $th_id=$row['threads_user_id'];
            $sql2="SELECT email FROM user WHERE sno='$th_id'";
            $result2=mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);
            echo '<div class="d-flex">
        <div class="flex-shrink-0">
          <img src="img/avatar.jpg" width="59px"alt="...">
        </div>
        <div class="flex-grow-1 ms-3 mb-3">
        <p class="my-0"><b>'.$row2['email'].'  </b>'.$time.'</p>
          <h5><a href="threadsexp.php?threadsid=' . $id . '">' . $title . '</a></h5>
          ' . $desc . '
        </div>
      </div>';
        }
        if ($got) {
            echo '<div class="alert alert-dark" role="alert">
  Be the first person to post a question..
</div>';
        } ?>
        
    </div>


    </div>



    <?php include 'partials/footer.php'; ?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
</body>

</html>