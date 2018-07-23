        <?php
            if(isset($_POST["Submit"])){
                $user = $_POST["Username"];
                $pass = $_POST["Password"];
                
                if($user == "Asaf" && $pass == "1234"){
                    echo "<h2>Welcome<br></h2>";
                }else{
                    echo "<h2>Try again<br>Unknown user {$user} and password {$pass} combination<br></h2>";
                }
                
            }else{
                echo "<h2>Login Required </h2>";
            }
        ?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <fieldset>
            <legend>Simple Form</legend>
            <form action="" method="POST">
                <label for="Username">Username: </label>
                <input id="Username" type="text" name="Username"><br><br>
                <label for="Password">Password: </label>
                <input id="Password" type="Password" name="Password"><br><br>
                <input type="Submit" name="Submit" value="Submitted">
            </form>
               
        </fieldset>

    </body>
</html>
