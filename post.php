<?php include "includes/header.php"; ?>
<?php include "includes/database.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">Post</h1>

            <?php

            if (isset($_GET["p_id"])) {
                $the_post_id = $_GET["p_id"];

                $sql = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = {$the_post_id}";
                $send_query = mysqli_query($connection, $sql);

                if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                } else {
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published'";
                }
                $select_all_posts = mysqli_query($connection, $query);

                if (mysqli_num_rows($select_all_posts) < 1) {
                    echo "<h1 class='text-center'>No post available</h1>";
                } else {



                    while ($row = mysqli_fetch_assoc($select_all_posts)) {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
            ?>

            <!-- First Blog Post -->
            <h2>
                <a href="#"><?php echo $post_title ?></a>
            </h2>
            <p class="lead">
                by <a href="index.php"><?php echo $post_author ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
            <hr>
            <p><?php echo $post_content ?></p>

            <hr>
            <?php   } ?>

            <!-- Blog Comments -->

            <?php
                    if (isset($_POST["create_comment"])) {
                        $the_post_id = $_GET["p_id"];

                        $comment_author = $_POST["comment_author"];
                        $comment_email = $_POST["comment_email"];
                        $comment_content = $_POST["comment_content"];

                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                            $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                            $query .= "VALUES($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now())";

                            $create_comment_query = mysqli_query($connection, $query);

                            if (!$create_comment_query) {
                                die('FAILED QUERY' . mysqli_error($connection));
                            }
                        } else {
                            echo "<script>alert('Error! field cannot be empty!')</script>";
                        }
                    }

                    ?>

            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="POST" role="form">
                    <div class="form-group">
                        <label for="Author">Author</label>
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <div class="form-group">
                        <label for="comment">Your Comment</label>
                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                </form>
            </div>

            <hr>

            <?php
                    $query = "SELECT * FROM comments WHERE comment_post_id = $the_post_id AND comment_status = 'approved' ORDER BY comment_id DESC";
                    $select_comment_query = mysqli_query($connection, $query);

                    if (!$select_all_posts) {
                        die("QUERY FAILED" . mysqli_error($connection));
                    }

                    while ($row = mysqli_fetch_array($select_comment_query)) {
                        $comment_date = $row["comment_date"];
                        $comment_author = $row["comment_author"];
                        $comment_content = $row["comment_content"];

                    ?>
            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $comment_author; ?>
                        <small><?php echo $comment_date; ?></small>
                    </h4>
                    <?php echo $comment_content; ?>
                </div>
            </div>

            <?php }
                }
            } else {
                header("Location: index.php");
            }

            ?>

            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>

            </ul>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->

    <?php include "includes/footer.php"; ?>
</div>

<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>