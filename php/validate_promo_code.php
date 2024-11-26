<?php

include 'db_connection.php';
session_start();

$response = ["status" => "error", "message" => "Invalid promo code"];

if (isset($_POST['promo_code'])) {
    $promo_code = trim($_POST['promo_code']);

    // Verificar si el código de descuento es válido
    $stmt = $conn->prepare("SELECT discount_amount, is_active FROM PromoCodes WHERE code_name = ?");
    $stmt->bind_param('s', $promo_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $discount_amount = $row['discount_amount'];
        $is_active = $row['is_active'];

        if ($is_active == 0) {//verify if its already activated

            //we activate the code in the db
            $update_stmt = $conn->prepare("UPDATE PromoCodes SET is_active = 1 WHERE code_name = ?");
            $update_stmt->bind_param('s', $promo_code);
            $update_stmt->execute();
            $update_stmt->close();
        }

        // Responder con el descuento si el código es válido
        $response = [
            "status" => "success",
            "promo_code" => $promo_code,
            "discount_amount" => $discount_amount
        ];
        
    }
    $stmt->close();
}

echo json_encode($response);
