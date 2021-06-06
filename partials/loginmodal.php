<?php
include 'dbconnect.php';
$showError ="False";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = $_POST["email"];
  $password0 = $_POST["password"];
  $sql = "SELECT * FROM user WHERE email='$email'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result)==1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password0, $row['password'])) {
        
        session_start();
        $_SESSION['loggedin'] =TRUE;
        $_SESSION['email'] = $email;
        $_SESSION['sno']=$row['sno'];
        header("location:/forum/index.php");
        
        exit();
      } else {
        $showError ="TRUE";
      }
    }
  } else {
    $showError = "TRUE";
  }
 header("location:/FORUM/index.php?signupsuccess=FALSE&error=$showError");
}


?> 

<div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="loginmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginmodalLabel">login to Code talks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
          
  <form id="form" action="/FORUM/partials/loginmodal.php" method="post">
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" maxlength="30" class="form-control" id="email" name="email" aria-describedby="emailHelp">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" maxlength="30" class="form-control" id="password" name="password">
      </div>



      <button type="submit" class="btn btn-primary mb-3">Submit</button>
    </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>