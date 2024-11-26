<?php
include '../db_connection.php';
session_start();

// clean the variable
unset($_SESSION['promo_codes_deactivated']);

// verify if its the first time we open the page or we refresh
if (!isset($_SESSION['promo_codes_deactivated'])) {

    $stmt = $conn->prepare("UPDATE PromoCodes SET is_active = 0");

    if ($stmt->execute()) {
        $_SESSION['promo_codes_deactivated'] = true;

        echo json_encode(["status" => "success", "message" => "Promo codes reset successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error resetting promo codes"]);
    }

    $stmt->close();
} else {//if the variabkle is already defined, it means we have already reseted the codes
    echo json_encode(["status" => "error", "message" => "Promo codes have already been reset for this session."]);
}

?>
