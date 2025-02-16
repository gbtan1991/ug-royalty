<?php
require '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $created_at = date('Y-m-d H:i:s');
    $modified_at = date('Y-m-d H:i:s');

    // Generate customer_id
    $year = date('Y');
    $stmt = $pdo->prepare("SELECT customer_id FROM customers WHERE customer_id LIKE ? ORDER BY customer_id DESC LIMIT 1");
    $stmt->execute(["ug-$year-%"]);
    $lastCustomerId = $stmt->fetchColumn();

    if ($lastCustomerId) {
        $lastIncrement = (int)substr($lastCustomerId, -3);
        $newIncrement = str_pad($lastIncrement + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newIncrement = '001';
    }

    $customer_id = "ug-$year-$newIncrement";

    // Insert data into the database
    $sql = "INSERT INTO customers (customer_id, nickname, first_name, last_name, created_at, modified_at) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customer_id, $name, $first_name, $last_name, $created_at, $modified_at]);

    echo "Registration successful. Your customer ID is: $customer_id";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="post" action="">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" required><br>
        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>