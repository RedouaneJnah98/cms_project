<?php include "includes/admin_header.php"; ?>
<?php include "./functions.php"; ?>

<?php
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];

    $query = "SELECT * FROM users WHERE username = '$username' ";
    $select_user_profile_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($select_user_profile_query)) {
        $user_id = $row["user_id"];
        $username = $row["username"];
        $user_password = $row["user_password"];
        $user_firstname = $row["user_firstname"];
        $user_lastname = $row["user_lastname"];
        $user_email = $row["user_email"];
        $user_image = $row["user_image"];
        $user_role = $row["user_role"];
    }
}
?>
<?php
if (isset($_POST["edit_user"])) {

    $firstname = $_POST["user_firstname"];
    $lastname = $_POST["user_lastname"];
    $role = $_POST["user_role"];
    $username = $_POST["username"];
    $email = $_POST["user_email"];
    $password = $_POST["user_password"];

    $query = "UPDATE users SET user_firstname = '{$firstname}', user_lastname = '{$lastname}', user_role = '{$role}', username = '{$username}', user_email = '{$email}', user_password = '{$password}' WHERE username = '{$username}' ";

    $edit_user_query = mysqli_query($connection, $query);

    confirmQuery($edit_user_query);
}


?>

<div id="wrapper">


    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small><?php echo $username; ?></small>
                    </h1>
                    <form action="" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="firstname">User Firstname</label>
                            <input type="text" class="form-control" name="user_firstname"
                                value="<?php echo $user_firstname; ?> ">
                        </div>

                        <div class="form-group">
                            <label for="lastname">User Lastname</label>
                            <input type="text" class="form-control" name="user_lastname"
                                value="<?php echo $user_lastname; ?>  ">
                        </div>

                        <div class=" form-group">

                            <select name="user_role" id="">
                                <option value="subscriber"><?php echo $user_role; ?></option>

                                <?php
                                if ($user_role === "admin") {
                                    echo " <option value='subscriber'>Subscriber</option>";
                                } else {
                                    echo "<option value='admin'>Admin</option>";
                                }
                                ?>
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                        </div>


                        <div class=" form-group">
                            <label for="user_email">User Email</label>
                            <input type="email" class="form-control" name="user_email"
                                value="<?php echo $user_email; ?>">
                        </div>

                        <div class=" form-group">
                            <label for="password">User Password</label>
                            <input type="password" class="form-control" name="user_password"
                                value="<?php echo $user_password; ?>">
                        </div>

                        <div class=" form-group">
                            <input class="btn btn-primary" type="submit" name="edit_user" value="Edit Profile">
                        </div>

                    </form>


                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>


    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php" ?>