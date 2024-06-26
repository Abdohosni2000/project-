<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <th>movie_name</th>
            <th>movie_rating</th>

        </thead>
        <tbody>
            <?php 
            include "connect.php";
            $con  = connectDB();
            $id = $_GET['id'];
            $sql = "SELECT * from users_movies where user_id= $id ";
            $res = mysqli_query($con , $sql);
            while($row = mysqli_fetch_assoc($res)){?>
            <tr>
                <td><?php echo $row['moive_name']; ?></td>
                <td><?php echo $row['moive_rateing']; ?></td>

                
               
            </tr>

            <?php }
            ?>
        </tbody>
    </table>
</body>
</html>