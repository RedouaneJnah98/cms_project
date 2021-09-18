<?php include "includes/database.php"; ?>
<?php include "includes/header.php"; ?>

<!-- Navigation -->

<?php include "includes/navigation.php"; ?>

<?php

if (isset($_POST["submit"])) {
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);

    if (!empty($username) && !empty($email) && !empty($password)) {

        $password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);

        $query = "INSERT INTO users (username, user_email, user_password, user_role) VALUES ('{$username}', '{$email}', '{$password}', 'subscriber')";
        $register_query = mysqli_query($connection, $query);

        $message = "Your registration has been submitted";
    } else {
        $message = "Fields cannot be empty";
    }
} else {
    $message = "";
}

?>

<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Contact Us</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">

                            <h6 class="text-center"><?php echo $message; ?></h6>

                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" name="subject" class="form-control" id="subject"
                                    placeholder="Enter your subject">
                            </div>
                            <div class="form-group">
                                <textarea name="body" id="body" class="form-control" cols="50" rows="10"></textarea>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block"
                                value="Submit">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>

    <hr>

    <?php include "includes/footer.php"; ?>