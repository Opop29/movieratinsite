<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo "Unauthorized access!";
    exit;
}

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $field = $_POST["field"];
    $value = $_POST["value"];

    // Check that the field is valid
    if (in_array($field, ["nickname", "email", "phone", "address"])) {
        $sql = "UPDATE users SET $field = :value WHERE id = :id";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":value", $value, PDO::PARAM_STR);
            $stmt->bindParam(":id", $_SESSION["id"], PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "Error updating information.";
            }

            unset($stmt);
        }
    } else {
        echo "Invalid field.";
    }
    unset($pdo);
}
?>
