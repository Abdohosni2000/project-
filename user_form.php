<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
        }

        form h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input[type="text"] {
            width: calc(100% - 20px); /* 20px padding */
            padding: 10px;
            margin: 5px 0 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="text"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        input[type="submit"]:active {
            background-color: #004494;
        }
    </style>
</head>
<body>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = $_POST['amount'];
            $user_id = $_POST['user_id'];
        }
    ?>
    <form action="api_test.php"  method="post">
        <h1>Payment Form</h1>
        <input type="text" style="display: none;" id="user_id" name="user_id" value="<?php echo $user_id; ?>" required>

        <label for="amount">Price :</label>
        <input type="text" id="amount" name="amount"  value="<?php echo $amount; ?>" >
        <label for="name">Name :</label>
        <input type="text" id="name" name="name" placeholder="Name" required>
        <label for="phone">Phone :</label>
        <input type="text" id="phone" name="phone" placeholder="Phone" required>
        <label for="address">Address :</label>
        <input type="text" id="address" name="address" placeholder="Address" required>
        <input type="submit" name="submit" value="Pay Now">
    </form>
</body>
</html>

