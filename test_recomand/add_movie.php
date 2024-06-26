<!DOCTYPE html>
<?php 
include "connect.php";
$userid = $_GET['id'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form  method="post">
        <input type="text" name="id" value="<?php echo $userid;?>" >

            <input type="text" name="movie_name" placeholder="movie_name" >
            <input type="text" name="rating"  placeholder="rating">

            <input type="submit" value="add_movie" name="submit">
        </form>
    </div>
</body>
</html>
<?php 
$con  = connectDB();

if (isset($_POST['submit'])){
    $userid = $_POST['id']; 

    $movie_name = $_POST['movie_name'];
    $rating = $_POST['rating'];


    // echo $movie_name ."<br>". $rating;
    // echo $username  ;
    $sql = "INSERT INTO `users_movies` (`id`, `user_id`, `moive_name`, `moive_rateing`) VALUES (NULL, ' $userid ', '$movie_name', '$rating ')";

    $res = mysqli_query($con,$sql);

    // if ($res){
    //     echo "good";
    // }else {
    //     echo "bad";
    // }


}

?>

