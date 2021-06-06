<?php
include 'dbconnect.php';
$showError = "FALSE";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password0 = $_POST["password"];
    $password1 = $_POST["password1"];
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user WHERE email='$email'")) > 0 && $email <> "") {
        $showError = "User-already-exists";
    } else {
        if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password0)) {
            $showError = "Strong-password-required";
        } else {
            if ($password0 == $password1) {
                $hash = password_hash($password0, PASSWORD_DEFAULT);
                $sql = "INSERT INTO user 
        VALUES('$email','$hash',current_timestamp()) ";

                $result = mysqli_query($conn, $sql);
                if ($result) {
                    session_start();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['email'] = $email;
                    $sql22 = "SELECT * FROM user WHERE email='$email'";
                    $result22 = mysqli_query($conn, $sql22);
                    if (mysqli_num_rows($result) == 1) {
                        while ($row22 = mysqli_fetch_assoc($result22)) {
                            $_SESSION['sno'] = $row22['sno'];
                        }
                    }
                    header("Location: /forum/index.php?signupsuccess=true");
                    exit;
                } else {

                    $showError = "fill-in";
                }
            } else {
                $showError = "passwords-dont-match";
            }
        }
    }
    header("location:/FORUM/index.php?signupsuccess=FALSE&error=$showError");
}


?>
<div class="modal fade" id="signupmodal" aria-labelledby="signupmodalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signupmodalLabel">Sign up to Code talks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="form" action="/FORUM/partials/signupmodal.php" method="post">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" maxlength="30" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" maxlength="30" class="form-control" id="password" name="password">
                    </div>

                    <div class="mb-3">
                        <label for="password1" class="form-label">Confirm password:</label>
                        <input type="password" maxlength="30" class="form-control" id="password1" name="password1">
                    </div>

                    <button type="submit" class="btn btn-primary ">Submit</button>



                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>