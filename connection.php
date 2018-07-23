<?php


$connection = mysqli_connect('localhost', 'root', '', 'fundme');
if($connection){
    echo "database connected<br>";
    $selected = mysqli_select_db($connection,'users');
    
    if($selected)
        echo $selected. "<br>";
    else 
        echo "failed<br>";
}else
    mysqli_connect_error ();
    
mysqli_close($connection);


