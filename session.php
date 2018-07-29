<?php

include('config.php');
session_start();

if (isset($SESSION)) {

    $user_check = $_SESSION['login_user'];

    $ses_sql = mysqli_query($connection, "select name from users where name = '$user_check' ");

    $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);

    $login_session = $row['name'];
}
?>