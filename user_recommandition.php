<?php
// include "connect.php";
// include "recomand.php";
// session_start();

// $con = connectDB();
// $movies = mysqli_query($con, "SELECT * FROM users_movies");
// $id = $_SESSION['user_id'];
// $matrix = array();

// // Fetch all movie ratings
// while ($movie = mysqli_fetch_array($movies)) {
//     $users = mysqli_query($con, "SELECT name FROM users WHERE id = " . $movie['user_id']);
//     $username = mysqli_fetch_array($users);

//     // Check if user and movie data are being fetched correctly
//     if ($username && isset($username['name'])) {
//         $matrix[$username['name']][$movie['moive_name']] = $movie['moive_rateing'];
//     } else {
//         echo "User not found for user_id: " . $movie['user_id'] . "<br>";
//     }
// }

// // Debug: Print the matrix to verify data population
// echo "<pre>";
// print_r($matrix);
// echo "</pre>";

// // Fetch current user's name
// $users = mysqli_query($con, "SELECT name FROM users WHERE id = " . $id);
// $username = mysqli_fetch_array($users);

// if ($username && isset($username['name'])) {
//     echo "Calculating recommendations for user: " . $username['name'] . "<br>";

//     // Get recommendations
//     $recommendations = getRecommantion($matrix, $username['name']);
    
//     // Debug: Print the recommendations
//     echo "<pre>";
//     print_r($recommendations);
//     echo "</pre>";
// } else {
//     echo "User not found for user_id: " . $id;
// }
?>

<?php
// include "connect.php";
// include "recomand.php";
// session_start();

// $con = connectDB();
// $movies = mysqli_query($con, "SELECT * FROM users_movies");
// $id = $_SESSION['user_id'];
// $matrix = array();

// // Fetch all movie ratings
// while ($movie = mysqli_fetch_array($movies)) {
//     $users = mysqli_query($con, "SELECT name FROM users WHERE id = " . $movie['user_id']);
//     $username = mysqli_fetch_array($users);

//     // Check if user and movie data are being fetched correctly
//     if ($username && isset($username['name'])) {
//         $matrix[$username['name']][$movie['moive_name']] = $movie['moive_rateing'];
//     } else {
//         echo "User not found for user_id: " . $movie['user_id'] . "<br>";
//     }
// }

// // Debug: Print the matrix to verify data population
// echo "<pre>";
// print_r($matrix);
// echo "</pre>";

// // Fetch current user's name
// $users = mysqli_query($con, "SELECT name FROM users WHERE id = " . $id);
// $username = mysqli_fetch_array($users);

// if ($username && isset($username['name'])) {
//     // echo "Calculating recommendations for user: " . $username['name'] . "<br>";

//     // Get recommendations
//     $recommendations = getRecommantion($matrix, $username['name']);
    
//     // Debug: Print the recommendations
//     // echo "<pre>";
//     // print_r($recommendations);
//     // echo "</pre>";
// } else {
//     echo "User not found for user_id: " . $id;
// }
?>
<?php
include "connect.php";
include "recomand.php";
session_start();

$con = connectDB();
$movies = mysqli_query($con, "SELECT * FROM users_movies");
$id = $_SESSION['user_id'];
$matrix = array();

// Fetch all movie ratings
while ($movie = mysqli_fetch_array($movies)) {
    $users = mysqli_query($con, "SELECT name FROM users WHERE id = " . $movie['user_id']);
    $username = mysqli_fetch_array($users);

    // Check if user and movie data are being fetched correctly
    if ($username && isset($username['name'])) {
        $matrix[$username['name']][$movie['moive_name']] = $movie['moive_rateing'];
    } else {
        echo "User not found for user_id: " . $movie['user_id'] . "<br>";
    }
}

// Debug: Print the matrix to verify data population
// echo "<pre>";
// print_r($matrix);
// echo "</pre>";

// Fetch current user's name
$users = mysqli_query($con, "SELECT name FROM users WHERE id = " . $id);
$username = mysqli_fetch_array($users);

if ($username && isset($username['name'])) {
    // Get recommendations
    $recommendations = getRecommantion($matrix, $username['name']);
    
    // Calculate Total and SimSum
    $total = array();
    $simsum = array();
    $different_data = array();
    
    foreach ($matrix as $otherperson => $value) {
        if ($otherperson != $username['name']) {
            $sim = similarity_distance($matrix, $username['name'], $otherperson);

            foreach ($matrix[$otherperson] as $key => $value) {
                if (!array_key_exists($key, $matrix[$username['name']]) || $matrix[$username['name']][$key] == 0) {
                    if (!array_key_exists($key, $total)) {
                        $total[$key] = 0;
                    }
                    $total[$key] += $matrix[$otherperson][$key] * $sim;

                    if (!array_key_exists($key, $simsum)) {
                        $simsum[$key] = 0;
                    }
                    $simsum[$key] += $sim;
                    
                    // Collect different data
                    $different_data[$otherperson][$key] = $matrix[$otherperson][$key];
                }
            }
        }
    }
} else {
    echo "User not found for user_id: " . $id;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommendation System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .post {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
}

.data-container {
    background-color: #f9f9f9;
    border-radius: 8px;
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
}

.data-container h3 {
    margin-top: 0;
    color: #333;
}

.data-container ul {
    list-style: none;
    padding: 0;
}

.data-container ul li {
    margin-bottom: 5px;
    color: #666;
}

    </style>
</head>
<body>
    

<div class="post">
    <h2>Recommendations and ratings from other users </h2>
    <div class="content">
        <?php
        if (isset($different_data)) {
            foreach ($different_data as $name => $movies) {
                echo "<div class='data-container'>";
                echo "<h3>$name</h3>";
                echo "<ul>";
                foreach ($movies as $movie => $rating) {
                    echo "<li>$movie: $rating</li>";
                }
                echo "</ul>";
                echo "</div>";
            }
        } else {
            echo "Different data is not available.";
        }
        ?>
    </div>
</div>

</body>
</html>
