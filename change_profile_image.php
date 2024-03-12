<?php

session_start();
include("classes/connect.php");
include("classes/login.php");
include("classes/user.php");
include("classes/post.php");
include("classes/image.php");

// Check User Login:
$login = new Login();
$user_data = $login->check_login($_SESSION['mybook_userid']);

if ($_SERVER['REQUEST_METHOD'] == "POST") {


    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
        //Debugging:

        // echo "<pre>";
        // print_r($_FILES);
        // echo "</pre>";
        // die;

        //Validating type of File being uploaded;
        if ($_FILES['file']['type'] == "image/jpeg") {

            $allowed_size = (1024 * 1024) * 7;
            // Validating size of file:
            if ($_FILES['file']['size'] < $allowed_size) {
                //Everything is Valid:

                //Rediredt the file location:
                $filename = "uploads/" . $_FILES['file']['name'];
                move_uploaded_file($_FILES['file']['tmp_name'], $filename);

                //Check Mode with URL Query:
                $image = new Image();
                $change = "profile";
                if (isset($_GET['change'])) {
                    $change = $_GET['change'];
                }

                if ($change == "cover") {
                    $image->crop_image($filename, $filename, 1366, 488);

                } else {
                    $image->crop_image($filename, $filename, 800, 800);
                }


                if (file_exists($filename)) {

                    $userid = $user_data['userid'];


                    if ($change == "cover") {
                        $query = "update users set cover_image = '$filename' where userid = '$userid' limit 1";

                    } else {
                        $query = "update users set profile_image = '$filename' where userid = '$userid' limit 1";

                    }

                    //Checking if File exists then save to path
                    $DB = new Database();
                    $DB->save($query);

                    header(("Location: profile.php"));
                    die;
                }

            } else {
                echo "<div style='text-align: center;font-size:12px;color:white;background-color:grey'>";
                echo "<br>The following errors occured<br><br>";
                echo "Only images of size 7Mb or lower are allowed!";
                echo "</div>";
            }

        } else {
            echo "<div style='text-align: center;font-size:12px;color:white;background-color:grey'>";
            echo "<br>The following errors occured<br><br>";
            echo "Only images allowed (jpeg)!";
            echo "</div>";
        }

    } else {
        echo "<div style='text-align: center;font-size:12px;color:white;background-color:grey'>";
        echo "<br>The following errors occured<br><br>";
        echo "Please add a valid image!";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Change Profile Image | Mybook</title>
</head>
<style type="text/css">
    #blue_bar {
        height: 50px;
        background-color: #405d9b;
        color: #d9dfeb;
    }

    #search_box {
        width: 200px;
        height: 20px;
        border-radius: 5px;
        border: none;
        padding: 4px;
        font-size: 14px;
        background-image: url(search.png);
        background-repeat: no-repeat;
        background-position: right;
    }

    #post_button {
        float: right;
        background-color: #405d9b;
        border: none;
        color: white;
        padding: 4px;
        font-size: 14px;
        border-radius: 2px;
        width: 100px;
    }

    #post_bar {
        margin-top: 20px;
        background-color: white;
        padding: 10px;
    }

    #post {
        padding: 4px;
        font-size: 13px;
        display: flex;
        margin-bottom: 20px;

    }
</style>

<body style="font-family: tahoma; background-color:#d0d8e4;">
    <br>
    <!--Top Bar-->

    <?php include("header.php"); ?>

    <!-- Cover Area -->
    <div style="width: 800px; margin:auto; min-height: 400px;">

        <!-- Below Cover Area -->
        <div style="display: flex;">

            <!-- Post Area -->
            <div style="min-height:400px;flex:2.5;padding: 20px;padding-right: 0px;">

                <form method="post" enctype="multipart/form-data">
                    <div style="border:solid thin #aaa; padding: 10px;background-color:white;">
                        <input type="file" name="file">
                        <input id="post_button" type="submit" value="Change">
                        <br>
                    </div>
                </form>

            </div>
        </div>

    </div>

</body>

</html>