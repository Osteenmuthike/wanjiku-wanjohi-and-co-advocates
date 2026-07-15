<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contact.php?error=1");
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');

if ($name === '' || $email === '' || $subject === '') {
    header("Location: contact.php?error=1");
    exit;
}

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=sandra-test;charset=utf8mb4",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    $stmt = $pdo->prepare(
        "INSERT INTO contact_inquiries (name, email, subject)
         VALUES (:name, :email, :subject)"
    );

    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':subject' => $subject
    ]);

    header("Location: contact.php?success=1");
    exit;

} catch (Exception $e) {
    header("Location: contact.php?error=1");
    exit;
}
