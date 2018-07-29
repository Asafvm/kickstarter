<?php


$connection = mysqli_connect('localhost', 'root', '', 'fundme');
if($connection){
    echo "database connected<br>";
}else
    mysqli_connect_error ();
    



