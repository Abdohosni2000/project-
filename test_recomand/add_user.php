<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <input type="text" name="username" >
            <input type="submit" name="submit">
        </form>
    </div>
</body>
</html>

<?php 
include "connect.php";
$con  = connectDB();

if (isset($_POST['submit'])){
    $username = $_POST['username'];

    // echo $username  ;
    $sql = "INSERT INTO `users` (`id`, `username`) VALUES (NULL, '$username')";

    $res = mysqli_query($con,$sql);

    if ($res){
        echo "good";
    }else {
        echo "bad";
    }


}

?>