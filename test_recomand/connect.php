<?php 

function connectDB(){
    $localhost = "localhost";
    $username = "root";
    $password = '';
    $dbname ="recommandition";

    $con = mysqli_connect($localhost,$username,$password,$dbname);

    return $con ;
}

?>