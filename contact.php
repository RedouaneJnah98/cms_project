<?php include "includes/database.php"; ?>
<?php include "includes/header.php"; ?>

<!-- Navigation -->

<?php include "includes/navigation.php"; ?>

<?php

if (isset($_POST["submit"])) {
    $to = "jnahtech@gmail.com";
    $subject = wordwrap($_POST["subject"], 70);
    $message = $_POST["message"];
    $header = "From:" . $_POST["email"] . "\r\n";

    mail($to, $subject, $message, $header);
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
                        <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">

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
                                <textarea name="message" id="message" class="form-control" cols="50"
                                    rows="10"></textarea>
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