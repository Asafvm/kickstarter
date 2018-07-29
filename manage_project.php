<?php
include('session.php');
$NameError = "";
$DateError = "";
$FundError = "";
$DescError = "";

$p_name = "";
$p_date = "";
$p_fund = "";
$p_desc = "";
$p_uploaded = "";
if (isset($_SESSION['login_user_id'])) {
    if (isset($_GET["p_id"])) {
        if ($connection) {
            $getUserProjects = "SELECT * FROM project WHERE id = " . $_GET['p_id'] . " and user_id = " . $_SESSION['login_user_id'];
            $execute = mysqli_query($connection, $getUserProjects);
            if (!$execute) {
                return false;
            } else {
                $count = mysqli_num_rows($execute);
                if ($count != 1) {
                    echo "not your project";
                } else {
                    $data = mysqli_fetch_array($execute);
                    $p_name = $data['name'];
                    $p_date = $data['date_due'];
                    $p_fund = $data['target_fund'];
                    $p_desc = $data['description'];
                    $p_uploaded = $data['date_uploaded'];
                    $p_main_img = $data['img'];
                }
            }
            if (isset($_POST["Submit"])) {
                echo 'saving';
                $p_name = $_POST['projectname'];
                $p_date = $_POST['datedue'];
                $p_fund = $_POST['targetfund'];
                $p_desc = $_POST['description'];
                $userid = $_SESSION['login_user_id'];
                $p_main_img = $_POST['pic'];
                $p_id = $_GET['p_id'];
                $query = "UPDATE project SET name='$p_name',description='$p_desc',date_due='$p_date',target_fund='$p_fund',img='$p_main_img' WHERE id='$p_id'";
                $execute = mysqli_query($connection, $query);
                if ($execute) {
                    echo "<script> alert('Success'); </script>";
                } else {
                    echo "<script> alert('Failed'); </script>";
                    print_r(mysqli_error($connection));
                }
            }
        }
    }
} else {
    echo "User logged out";
}
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="explore.php">Explore</a></li>
                    <li><a href="create_project.php">Create a Project</a></li>
                    <?php
                    if (isset($_SESSION['login_user_id'])) {
                        echo '<li class="active"><a href="manage_project.php">Manage Projects</a></li>';
                        echo '<li><a href="logout.php">Logout</a></li>';
                    } else {
                        echo '<li><a href="login.php">Login / Register</a></li>';
                    }
                    ?>
                </ul>

            </div>

            <div class="col-sm-6">
                <fieldset>
                    <form action="" method="POST">
                        <div class='row'>
                            <div class='col-sm-3'>
                                <label for="projectname">Project Name: </label>
                            </div>
                            <div class="col-sm-3">
                                <input id="projectname" type="text" name="projectname" value="<?php echo $p_name; ?>"><span class="Error">*<?php echo $NameError; ?></span><br><br>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-3'>
                                <label for="datedue">Date Due: </label>
                            </div>
                            <div class="col-sm-3">
                                <input id="datedue" type="date" name="datedue" value="<?php echo $p_date; ?>"><span class="Error">*<?php echo $DateError; ?></span><br><br>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-3'>
                                <label for="targetfund">Target Fund: </label>
                            </div>
                            <div class="col-sm-3">
                                <input id="targetfund" type="number" name="targetfund" value="<?php echo $p_fund; ?>"><span class="Error">*<?php echo $FundError; ?></span><br><br>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-3'>
                                <label for="description">Description: </label>
                            </div>
                            <div class="col-sm-3">
                                <textarea id="description" type="text" rows="5" cols="50 "name="description" value="<?php echo $p_desc; ?>"></textarea><span class="Error">*<?php echo $DescError; ?></span><br><br>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-3'>
                                <label for="description">Main Image: </label>
                            </div>
                            <div class="col-sm-3">
                                <input type="file" name="pic" accept="image/*">
                            </div>
                        </div>
                        <input type="Submit" name="Submit" value="Save">
                    </form>
                </fieldset>







            </div>
        </div>

    </body>
</html>
