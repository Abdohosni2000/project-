<?php
// stripe_api.php

// Load configuration and Stripe PHP library
require 'stripe_config.php';

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Set content type to JSON
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Check if the required parameters are provided
    if (isset($data['amount']) && isset($data['currency'])) {
        $amount = $data['amount'];
        $currency = $data['currency'];

        // Create a PaymentIntent
        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
            ]);

            // Return the client secret
            echo json_encode([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid parameters.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed.']);
}
?>
