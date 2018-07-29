<?php
include('session.php');
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Fund Me Home Page</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/my_styles.css" rel="stylesheet">
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

    </head>
    <body>
        <h1>Fund Me!</h1>

        <div class="row">
            <div id="search_div" class="homepage">
                <input type="text" name="search_input">
                <button type="button" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span> Search
                </button>
                <?php include('header.php'); ?>

            </div>

        </div>
        <div class="row">
            <div class="col-sm-2">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li><a href="explore.php">Explore</a></li>
                    <li><a href="create_project.php">Create a Project</a></li>
                    <?php
                    if (isset($_SESSION['login_user_id'])) {
                        echo '<li><a href="manage_project.php">Manage Projects</a></li>';
                        echo '<li><a href="logout.php">Logout</a></li>';
                    } else {
                        echo '<li><a href="login.php">Login / Register</a></li>';
                    }
                    ?>
                </ul>

            </div>
            <div class="col-sm-10">
                <?php
                if (isset($_SESSION['login_user_id'])) {
                    $getUserProjects = "SELECT * FROM project where user_id = " . $_SESSION['login_user_id'];
                    $execute = mysqli_query($connection, $getUserProjects);
                    if (!$execute) {
                        return false;
                    } else {
                        //echo mysqli_num_rows($execute);
                        echo "<br><table>";
                        while ($data = mysqli_fetch_array($execute)) {
                            $id = $data['id'];
                            $p_name = $data['name'];
                            $p_desc = $data['description'];
                            $date_uploaded = $data['date_uploaded'];
                            $date_due = $data['date_due'];
                            $target_fund = $data['target_fund'];
                            $current_fund = $data['current_fund'];
                            $user_id = $data['user_id'];

                            $getUser = "SELECT name FROM users WHERE id=" . $user_id;
                            $user_query = mysqli_query($connection, $getUser);
                            if (!$user_query) {
                                $user_name = "";
                            } else {
                                $result = mysqli_fetch_array($user_query);
                                $user_name = $result['name'];
                            }
                            $progress = floor($current_fund / $target_fund * 100);
                            if ($progress < 100) {
                                $progressinfo = $progress . '% Complete';
                            } else {
                                $progress = 100;
                                $progressinfo = "Funded!";
                            }
                            ?>


                            <div class='col-sm-2 card' style="height: 400px; border-style: solid; border-color: black; border-width: 2px; margin: 5px">
                                <h2> <?php echo $p_name ?> </h2>
                                <img src="pics/no_image.png" alt="No-Image" style="height: 30%; width: 100% ; margin-left: auto; margin-right: auto; display: block;">
                                <p> <?php echo $p_desc ?> </p>

                                <?php
                                echo '<div style="width:90%; position: absolute;right:0; bottom:0; margin:15px; margin-bottom: 35px" >';
                                echo "$current_fund / $target_fund";
                                echo'<div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="' . $progress . '"
                                        aria-valuemin="0" aria-valuemax=100 style="width:' . $progress . '%">
                                          ' . $progressinfo . '</div></div></div>';

                                if (isset($_SESSION['login_user_id'])) {
                                    if ($_SESSION['login_user_id'] === $user_id) {
                                        echo '<input style="width:90%; position: absolute;right:0; bottom:0; margin:15px;" class="btn btn-primary btn-block" type="submit" value="Edit"/>';
                                    } else {

                                        echo '<input style="width:90%; position: absolute;right:0; bottom:0; margin:15px;" class="btn btn-success btn-block" type="submit" value="Fund It"/>';
                                    }
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>

    </body>
</html>
