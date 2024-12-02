<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../db_connection.php';

session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = isset($_POST['firstName']) ? mysqli_real_escape_string($conn, trim($_POST['firstName'])) : '';
    $lastName = isset($_POST['lastName']) ? mysqli_real_escape_string($conn, trim($_POST['lastName'])) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, trim($_POST['email'])) : '';
    $address = isset($_POST['address']) ? mysqli_real_escape_string($conn, trim($_POST['address'])) : '';
    $country = isset($_POST['country']) ? mysqli_real_escape_string($conn, trim($_POST['country'])) : '';
    $state = isset($_POST['state']) ? mysqli_real_escape_string($conn, trim($_POST['state'])) : '';
    $zip = isset($_POST['zip']) ? mysqli_real_escape_string($conn, trim($_POST['zip'])) : '';
    $shippingMethod = isset($_POST['shippingMethod']) ? mysqli_real_escape_string($conn, trim($_POST['shippingMethod'])) : '';
    $dataProtection = isset($_POST['dataProtection']) && $_POST['dataProtection'] === 'on' ? true : false;
    $totalPrice = isset($_POST['totalPrice']) ? floatval(trim($_POST['totalPrice'])) : 0.00;

    //We have to transform the string format to an array valid in php
    $cartArticles = [];
    if (isset($_POST['cartArticles'])) {

        parse_str($_POST['cartArticles'], $cartArticles);

        if (is_array($cartArticles)) {
            echo "<pre>";
            print_r($cartArticles['cartArticles']); // Verify that it's an array
            echo "<pre>";
            
        } else {
            echo "<p style='color: red;'>Error: cartArticles is not a valid array.</p>";
        }
    } else {
        echo "<p style='color: red;'>Error: cartArticles is not set in POST data.</p>";
    }
    

    }

    $errors = [];

    if (empty($firstName)) $errors[] = 'First name is required.';
    if (empty($lastName)) $errors[] = 'Last name is required.';
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';
    if (empty($address)) $errors[] = 'Address is required.';
    if (empty($country)) $errors[] = 'Country is required.';
    if (empty($state)) $errors[] = 'State is required.';
    if (empty($zip) || !preg_match('/^[0-9]{5}$/', $zip)) $errors[] = 'Invalid zip code.';
    if (empty($shippingMethod)) $errors[] = 'Shipping method is required.';
    if (!($dataProtection)) $errors[] = 'You must accept the data protection policy.';
    if ($totalPrice <= 0) $errors[] = 'Total price must be greater than zero.';
    if (empty($cartArticles)) $errors[] = 'Cart can not be empty';
   

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        echo "<p style='color: green;'>Order Validated.\nNow, let´s create the order</p>";
            
        // We fetch user_id from the Users table based on the email
        $stmt = $conn->prepare("SELECT user_id FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($userId);
        $stmt->fetch();
        $stmt->close();
            
            // Check if user_id was found
        if ($userId) {
            $stmt = $conn->prepare("INSERT INTO Orders(user_id, first_name, last_name, email, address, shipping_method, total_price ) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssd", $userId, $firstName, $lastName, $email, $address,$shippingMethod, $totalPrice );
            // Execute the statement
            if ($stmt->execute()) {

                echo "<p style='color: green;'>Order Created.\nNow, let´s create the order Items</p>";

                $orderId = $conn->insert_id; 
                if (!$orderId) {
                    echo "<p style='color: red;'>Error: Unable to retrieve the last order ID.</p>";
                }
                //cartArticles is passed as a nested array, so we have to access its nested array
                foreach ($cartArticles['cartArticles'] as $article) {
                    echo "<pre>";
                    print_r($article); // Verify that it's an array
                    echo "<pre>";
                    if (isset($article['name'], $article['quantity'], $article['price'], $article['image_url'])) {
                        
                        echo "<p style='color: green;'>Inserting Order Item ".$article['name']." </p>";
                        $stmt = $conn->prepare("INSERT INTO OrderItems(order_id, article_name, quantity, price, image_url) VALUES(?,?,?,?,?)");
                        $stmt->bind_param("isids", $orderId, $article['name'], $article['quantity'], $article['price'], $article['image_url']);
                        $stmt->execute();
                        $stmt->close();


                    
                    } else{
                        echo "<p style='color: red;'>Error creating order items details:</p>";
                    }
                }

                header('Location: ../../thanks.html');
                exit();

            } else {
                echo "<p style='color: red;'>Error creating order login details: " . $stmt->error . "</p>";
            } 
        } else{

            echo "<p style='color: red;'>User not found for the given email.</p>";
        }

       
    }


