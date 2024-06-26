<!DOCTYPE html>
<html>
<head>
    <title>Stripe Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
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

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
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

        #card-element {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
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

        button:hover {
            background-color: #0056b3;
        }

        button:active {
            background-color: #004494;
        }

        #payment-message {
            margin-top: 20px;
            font-size: 14px;
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- 4254 5464 6767 6885 -->
    <h1>Stripe Payment</h1>
    <?php 
include('includes/config.php');

if (isset($_POST['submit'])){
    $amount = $_POST['amount'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $user_id = $_POST['user_id'];
    // $sql = "INSERT INTO pay_user ('user_id','name', 'phone', 'address','price') VALUES ($user_id,$name, $phone, $address,$amount)";
    $sql = "INSERT INTO pay_user (`user_id`, `name`, `phone`, `address`, `price`) VALUES ('$user_id', '$name', '$phone', '$address', '$amount')";

// echo $amount ." " .$name ." ".$phone  ." ". $user_id ;
    $res = mysqli_query($con,$sql);
    if($res == true){
    //    header("Location:api_test.php");
    }else {
        echo "no";
    }


}

?>
    <?php
    // Capture the amount from the previous form submission
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     $amount = $_POST['amount'];
    // }
    // echo $amount;
    ?>

    <form id="payment-form">
        <div id="card-element"><!-- Stripe.js injects the Card Element --></div>
        <button type="submit" onclick="alert('thank you for payment')">Pay</button>
        <div id="payment-message"></div>
    </form>

    <script>
        const stripe = Stripe('pk_test_51MlTknJYCs1aiZ2mYVPVu9AEYHMICn6uAmwtvO4xi6xDM1OZi4qSHJbj6Xmk7PTyLkHYeFoWWiZdQ5zllxeGsRPl00trQqKaF6');

        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            // Call your backend to create the PaymentIntent
            const response = await fetch('stripe_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    amount: <?php echo $amount; ?>, // Amount in cents
                    currency: 'usd',
                }),
            });

            const { clientSecret, error } = await response.json();

            if (error) {
                document.getElementById('payment-message').textContent = error;
                return;
            }

            // Confirm the payment with Stripe.js
            const { paymentIntent, error: stripeError } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardElement,
                },
            });

            if (stripeError) {
                document.getElementById('payment-message').textContent = stripeError.message;
            } else if (paymentIntent.status === 'succeeded') {
                document.getElementById('payment-message').textContent = 'Payment succeeded!';
            }
        });
    </script>
</body>
</html>
