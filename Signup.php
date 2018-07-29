        <?php
            session_start();        
        $NameError = "";
        $PassError = "";
        $Pass2Error = "";
        $EmailError = "";
            if(isset($_POST["Submit"])){
               //require './connection.php';
                //$connection = mysqli_connect('localhost', 'root', '', 'fundme');
                require 'config.php';
                if($connection){
                
                    $user = $_POST["Username"];
                    $pass = $_POST["Password"];
                    $pass2 = $_POST["Password2"];
                    $email = $_POST["Email"];
                    $chk1 = test_name($user);
                    $chk2 = test_pass($pass, $pass2);
                    $chk3 = test_email($email);
                
                    if($chk1 && $chk2 && $chk3){
                        $query = "INSERT INTO users(name,password,email)"
                                    ."VALUES('$user','$pass','$email')";
                            $execute = mysqli_query($connection, $query);
                            if($execute){
                                echo "<h2>Success! </h2>";
                                $_SESSION['login_user'] = $user;

                                header("location: index.php");
                            }else{
                                echo "<h2>Failed to register user </h2>";
                            }
                        }else{
                            echo "<h2>Failed to register user </h2>";
                        }
                    
                }else{
                    echo "no connection to database<br>";
                }
                    
            }else{
                echo "<h2>Login Required </h2>";
            }
            
            function test_name($data){
                global $NameError;
                if(empty($data)){
                    $NameError = "Name is required";
                    return false;
                }else{
                    if(!preg_match("/^[a-zA-Z. ]*$/", $data)){
                        $NameError = "Name is not vaild";
                        return false;
                    }else{
                        return true;
                    }
                    
                }
            }
            function test_pass($pass1, $pass2){
                global $PassError;
                global $Pass2Error;
                
                if(empty($pass1)){
                    $PassError = "Password is required";
                    
                    if(empty($pass2)){
                        $Pass2Error = "Password is required";
                        return false;
                    }
                    return false;
                }else{
                    if($pass1 != $pass2){
                        $Pass2Error = "Passwords mismatch";
                        return false;
                    }else{
                        return true;
                    }
                }
            }
            
            
            function test_email($data){
                global $EmailError;
                global $connection;
                if(empty($data)){
                    $EmailError = "Email is required";
                    return false;
                }elseif(!preg_match("/^[a-zA-Z._0-9]+@[a-zA-Z]+[.A-Za-z]{2,}[.]{1}[.A-Za-z]{2,}/", $data)){
                        $EmailError = "Email is not vaild";
                        return false;
                }else{
                        $checkUser = "SELECT * FROM users WHERE email='".$data."'";
                        $execute = mysqli_query($connection, $checkUser);
                        if (!$execute) {
                            //printf("Error: %s\n", mysqli_error($connection));
                            return false;
                        }elseif($data = mysqli_fetch_array($execute)){
                                $EmailError = "Email already exists";           
                                return false;
                            }else{
                                return true;
                            }
                        }
                    }
                
            
        ?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Registration</title>
    </head>
    <style type="text/css">
        input{
            border: 1px solid black;
            background-color: rgb(240,240,240);
            width: 300px;
            padding: .5em;
            font-size: 1em;
            
        }
        input[type="Submit"]{
            border: 1px solid black;
            background-color: rgb(50,150,20);
            width: 250;
            padding: .2em;
            font-size: 1em;
            
        }
        label{
            display: inline-block;
            width: 100px;
        }
        
        .Error{
            color: red;
        }
        .center {
            position: absolute;
            left: 25%;
            top: 10%;
            width: 50%;
            text-align: left;
            font-size: 18px;
        }

    </style>
    <body>
        <div id="register_form" class="center">
        <fieldset>
            <legend>Simple Form</legend>
            <form action="" method="POST">
                <label for="Username">Username: </label>
                <input id="Username" type="text" name="Username"><span class="Error">*<?php echo $NameError;?></span><br><br>
                <label for="Password">Password: </label>
                <input id="Password" type="Password" name="Password"><span class="Error">*<?php echo $PassError;?></span><br><br>
                <label for="Password2">Password: </label>
                <input id="Password2" type="Password" name="Password2"><span class="Error">*<?php echo $Pass2Error;?></span><br><br>
                <label for="Email">Email: </label>
                <input id="Email" type="Email" name="Email"><span class="Error">*<?php echo $EmailError;?></span><br><br>
                <input type="Submit" name="Submit" value="Submit Info">
            </form>
        </fieldset>
        </div>

    </body>
</html>
