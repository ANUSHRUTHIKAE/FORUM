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

    <title>Code-Talks!</title>
    <style>
    @media(min-height:300px){
    #ques{
      min-height: 86vh;
    }}
    </style>
</head>

<body>
    <?php include 'partials/header.php'; 
    include "partials/dbconnect.php";
    $id=$_GET['threadsid'];
    $sql="SELECT * FROM threads WHERE threads_id=$id";
    $res=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($res)){
        $cat=$row['threads_tittle'];
        $desc=$row['threads_desc'];
        $threads_user_id=$row['threads_user_id'];
        $sql22="SELECT email FROM user WHERE sno='$threads_user_id'";
        $res22=mysqli_query($conn,$sql22);
        $row22=mysqli_fetch_assoc($res22);
        echo'<div class="container my-4">
        <div class="jumbotron">
                <h1 class="display-4"><em>'.$cat.'</em></h1>
                <p class="lead">'.$desc.'</p>
                <hr class="my-4">
                <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post questions. Remain respectful of other members at all times.</p>
                <p>Posted by: <b>'.$row22['email'].'</b></p>
            </div>';
    }
    
    ?>
    <?PHP 
    $method=$_SERVER['REQUEST_METHOD'];
    $sno=$_SESSION['sno'];
    if($method=='POST'){
        $content=$_POST['desc'];
        
        $sql = "INSERT INTO comments 
        VALUES(NULL,$content,$id,$sno,current_timestamp()) ";
        $resl=mysqli_query($conn,$sql);
        
        
      }
      
      
    ?>

   

    

        
    </div>
    <div class="container" id="ques">
    <h3>
    Comments:</h3>
    <?php
    if($loggedin){
    echo'<form action="'.$_SERVER['REQUEST_URI'].'"method="post"> 
            <div class="mb-3">


                <textarea class="form-control" aria-label="With textarea" placeholder="Your comments..."id="desc" name="desc"></textarea>
                
            </div>
            <button type="submit" class="btn btn-primary">Comment</button>
        </form>';}
        else{echo'<div class="alert alert-light" role="alert">
            login to comment....
          </div>';}
        ?>
    <?php 
    $id=$_GET['threadsid'];
    $sql="SELECT * FROM comments WHERE thread_id=$id";
    $res=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($res)){
        $id=$row['comments_id'];
        $cat=$row['comments_content'];
        $cat=str_replace("<","&lt;",$cat);
        $cat=str_replace(">","&gt;",$cat);
        $time=$row['timestamp'];
        $comby=$row['comments_by'];
        $sql2="SELECT email FROM user WHERE sno='$comby'";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        
        echo '<div class="d-flex">
        <div class="flex-shrink-0">
          <img src="img/avatar.jpg" width="59px"alt="...">
        </div>
        <div class="flex-grow-1 ms-3 mb-3">
         <p class="my-0"><b>'.$row2['email'].' </b>'.$time.'</p>
          ' . $cat . '
        </div>
      </div>';
    }
    ?>
    
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