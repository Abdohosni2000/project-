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
            <th>username</th>
            <th>add_movie</th>
            <th>show_movie</th>
            <th>show_recommandition</th>


        </thead>
        <tbody>
            <?php 
            include "connect.php";
            $con  = connectDB();
            $sql = "SELECT * from users ";
            $res = mysqli_query($con , $sql);
            while($row = mysqli_fetch_assoc($res)){?>
            <tr>
                <td><?php echo $row['username']; ?></td>
                <td>
                    <form action="add_movie.php" method="get">
                        <input type="text" style="display: none;" name="id" value="<?php echo $row['id']; ?>">
                        <input type="submit"  value="add_movie">
                    </form>
                </td>
                <td>
                    <form action="show_movie.php" method="get">
                        <input type="text" style="display: none;" name="id" value="<?php echo $row['id']; ?>">
                        <input type="submit"  value="show_movie">
                    </form>
                </td>
                <td>
                    <form action="user_recommandition.php" method="get">
                        <input type="text" style="display: none;" name="id" value="<?php echo $row['id']; ?>">
                        <input type="submit"  value="show_recommandition">
                    </form>
                </td>
               
            </tr>

            <?php }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php 
session_start();

echo $_SESSION['user_id'];

?>