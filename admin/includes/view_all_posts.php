<?php
include "modal_delete.php";

if (isset($_POST["checkboxArray"])) {
    $checkboxesId = $_POST["checkboxArray"];

    foreach ($checkboxesId as $checkboxId) {
        $bulkOptions = $_POST["bulk_options"];

        switch ($bulkOptions) {
            case "published":
                $query = "UPDATE posts SET post_status = '$bulkOptions' WHERE post_id = $checkboxId";
                $update_status = mysqli_query($connection, $query);
                break;

            case "draft":
                $query = "UPDATE posts SET post_status = '$bulkOptions' WHERE post_id = $checkboxId";
                $update_status = mysqli_query($connection, $query);
                break;

            case "delete":
                $query = "DELETE from posts WHERE post_id = $checkboxId";
                $update_status = mysqli_query($connection, $query);
                break;

            case "clone":

                $query = "SELECT * FROM posts WHERE post_id = $checkboxId ";
                $select_post_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_title         = $row['post_title'];
                    $post_category_id   = $row['post_category_id'];
                    $post_date          = $row['post_date'];
                    $post_author        = $row['post_author'];
                    $post_status        = $row['post_status'];
                    $post_image         = $row['post_image'];
                    $post_tags          = $row['post_tags'];
                    $post_content       = $row['post_content'];
                }

                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date,post_image,post_content,post_tags,post_status) ";

                $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') ";

                $copy_query = mysqli_query($connection, $query);

                break;

            default:
                echo "there is an error";
        }
    }
}
?>

<form action="" method="POST">
    <table class="table table-bordered table-hover">

        <div id="bulkOptionContainer" class="col-xs-4">

            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>

        </div>

        <div class="col-xs-4 form-group">

            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>

        </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Post Views</th>
            </tr>
        </thead>
        <tbody>

            <?php
            // $query = "SELECT * FROM posts ORDER BY post_id DESC";

            $query = "SELECT posts.post_id, posts.post_title, posts.post_author, posts.post_user, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC ";

            $select_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_posts)) {
                $post_id = $row["post_id"];
                $post_title = $row["post_title"];
                $post_author = $row["post_author"];
                $post_user = $row["post_user"];
                $post_category_id = $row["post_category_id"];
                $post_status = $row["post_status"];
                $post_image = $row["post_image"];
                $post_tags = $row["post_tags"];
                $post_comment_count = $row["post_comment_count"];
                $post_date = $row["post_date"];
                $post_views_count = $row["post_views_count"];
                $category_id = $row['cat_id'];
                $category_title = $row["cat_title"];

                echo "<tr>";
            ?>
            <td><input type="checkbox" class="checkBoxes" name="checkboxArray[]" value="<?php echo $post_id; ?>"></td>
            <?php
                echo "<td>$post_id</td>";
                echo "<td>$post_title</td>";

                if (!empty($post_author)) {
                    echo "<td>$post_author</td>";
                } elseif (!empty($post_user)) {
                    echo "<td>$post_user</td>";
                }

                // $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                // $select_category = mysqli_query($connection, $query);

                // while ($row = mysqli_fetch_array($select_category)) {
                //     $cat_id = $row["cat_id"];
                //     $cat_title = $row["cat_title"];

                echo "<td>$category_title</td>";
                // }

                echo "<td>$post_status</td>";
                echo "<td><img src='../images/$post_image' width='100' alt='image'/></td>";
                echo "<td>$post_tags</td>";

                $sql = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $send_sql = mysqli_query($connection, $sql);

                $row = mysqli_fetch_array($send_sql);
                $comment_id = isset($row["comment_id"]);

                $comment_count = mysqli_num_rows($send_sql);

                echo "<td><a href='post_comments.php?id=$post_id'>$comment_count</a></td>";
                echo "<td>$post_date</td>";
                echo "<td><a href='../post.php?p_id={$post_id}'>Post</a></td>";
                echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                echo "<td><a href='javascript:void(0)' rel='$post_id' class='delete_link'>Delete</a></td>";
                // echo "<td><a onClick=\"javascript: return confirm('are you sure you want to delete this post?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
                echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
                echo "</tr>";
            }

            ?>



        </tbody>
    </table>
</form>


<?php
if (isset($_GET["delete"])) {

    $the_post_id = $_GET["delete"];
    $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";

    $delete_post_query = mysqli_query($connection, $query);
    header("Location: posts.php");
}

if (isset($_GET["reset"])) {
    $the_post_id = $_GET["reset"];
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $the_post_id";

    $reset_post_query = mysqli_query($connection, $query);
    header("Location: posts.php");
}
?>

<script>
$(document).ready(function() {
    $(".delete_link").on("click", function() {
        var id = $(this).attr('rel');
        console.log(id);
        var delete_url = "posts.php?delete=" + id + " ";

        $(".modal_delete_link").attr("href", delete_url);

        $("#myModal").modal('show');

    })
})
</script>