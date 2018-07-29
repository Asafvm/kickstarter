<?php
session_start();
$NameError = "";
$DateError = "";
$FundError = "";
$DescError = "";

if (!isset($_SESSION['login_user_id'])) {
    header("location: login.php");
} else {
    if (isset($_POST["Submit"])) {
        require 'config.php ';
        if ($connection) {

            $p_name = $_POST["projectname"];
            $p_date = $_POST["datedue"];
            $p_fund = $_POST["targetfund"];
            $p_desc = $_POST["description"];

            //$chk1 = test_name($p_name);
            //$chk2 = test_date($p_date);
            //$chk3 = test_fund($p_fund);
            $today = date("Y-m-d");
            $userid = $_SESSION['login_user_id'];
            //if($chk1 && $chk2 && $chk3){
            $query = "INSERT INTO project(name,description,date_uploaded,date_due,target_fund,current_fund,user_id,img)"
                    . "VALUES('$p_name','$p_desc','$today','$p_date','$p_fund','0','$userid','NULL')";
            $execute = mysqli_query($connection, $query);
            if ($execute) {
                echo "<script> alert('Success'); </script>";
                header("location: index.php");
            } else {
                echo "<script> alert('Failed'); </script>";
                print_r(mysqli_error($connection));
            }
        } else {
            echo "<h2>Failed to register user </h2>";
        }
    }
}

function test_name($data) {
    global $NameError;
    if (empty($data)) {
        $NameError = "Name is required";
        return false;
    } else {
        if (!preg_match("/^[a-zA-Z. ]*$/", $data)) {
            $NameError = "Name is not vaild";
            return false;
        } else {
            return true;
        }
    }
}

function test_pass($pass1, $pass2) {
    global $PassError;
    global $Pass2Error;

    if (empty($pass1)) {
        $PassError = "Password is required";

        if (empty($pass2)) {
            $Pass2Error = "Password is required";
            return false;
        }
        return false;
    } else {
        if ($pass1 != $pass2) {
            $Pass2Error = "Passwords mismatch";
            return false;
        } else {
            return true;
        }
    }
}

function test_email($data) {
    global $EmailError;
    global $connection;
    if (empty($data)) {
        $EmailError = "Email is required";
        return false;
    } elseif (!preg_match("/^[a-zA-Z._0-9]+@[a-zA-Z]+[.A-Za-z]{2,}[.]{1}[.A-Za-z]{2,}/", $data)) {
        $EmailError = "Email is not vaild";
        return false;
    } else {
        $checkUser = "SELECT * FROM users WHERE email='" . $data . "'";
        $execute = mysqli_query($connection, $checkUser);
        if (!$execute) {
            //printf("Error: %s\n", mysqli_error($connection));
            return false;
        } elseif ($data = mysqli_fetch_array($execute)) {
            $EmailError = "Email already exists";
            return false;
        } else {
            return true;
        }
    }
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
                    <li  class="active"><a href="create_project.php">Create a Project</a></li>
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
            <div  id="register_project" class="col-sm-6">
                <fieldset>
                    <form action="" method="POST">
                        <div class='row'>
                            <div class='col-sm-3'>
                                <label for="projectname">Project Name: </label>
                            </div>
                            <div class="col-sm-3">
                                <input id="projectname" type="text" name="projectname"><span class="Error">*<?php echo $NameError; ?></span><br><br>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-3'>
                                <label for="datedue">Date Due: </label>
                            </div>
                            <div class="col-sm-3">
                                <input id="datedue" type="date" name="datedue"><span class="Error">*<?php echo $DateError; ?></span><br><br>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-3'>
                                <label for="targetfund">Target Fund: </label>
                            </div>
                            <div class="col-sm-3">
                                <input id="targetfund" type="number" name="targetfund"><span class="Error">*<?php echo $FundError; ?></span><br><br>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-3'>
                                <label for="description">Description: </label>
                            </div>
                            <div class="col-sm-3">
                                <textarea id="description" type="text" rows="5" cols="50 "name="description"></textarea><span class="Error">*<?php echo $DescError; ?></span><br><br>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-3'>
                                <label for="description">Description: </label>
                            </div>
                            <div class="col-sm-3">
                                <textarea id="description" type="text" rows="5" cols="50 "name="description"></textarea><span class="Error">*<?php echo $DescError; ?></span><br><br>
                            </div>
                        </div>
                        <input type="Submit" name="Submit" value="Submit Info">
                    </form>
                </fieldset>

            </div>
        </div>



    </body>
</body>
</html>
