<?php 
include "connect.php";
include "recomand.php";

$con = connectDB();
$movies = mysqli_query($con , "SELECT * from users_movies");
$id = $_GET['id'];
$matrix = array();
// echo $id ;
while($movie =mysqli_fetch_array($movies)){
    $users = mysqli_query($con,"SELECT name from users where id = $movie[user_id]");

    $username = mysqli_fetch_array($users);

    $matrix[$username['name']][$movie['moive_name']]= $movie['moive_rateing'];
}

// echo "<pre>";
// print_r($matrix);
// echo "</pre>";
$users = mysqli_query($con,"SELECT name from users where id = $id ");

$username = mysqli_fetch_array($users);

var_dump( getRecommantion($matrix,$username['name']));
?>
