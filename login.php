<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "gradeify");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get role from URL
$role = isset($_GET["role"]) ? $_GET["role"] : "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST["id"];
    $password = $_POST["pass"];
    $role = $_POST["role"];

    // Authenticate user using ID
    $stmt = $conn->prepare("SELECT name, pass FROM authenticate WHERE id = ? AND role = ?");
    $stmt->bind_param("ss", $userid, $role);
    $stmt->execute();
    $stmt->bind_result($username, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    if ($hashed_password) {
        if ($password === $hashed_password || password_verify($password, $hashed_password)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $userid;
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;

            if ($role == "Faculty") {
                header("Location: /dept/Faculty/Faculty.php");
            } elseif ($role == "Student") {
                // Get rollno and email using ID
                $stmt = $conn->prepare("SELECT rollno, email FROM user WHERE id = ?");
                $stmt->bind_param("s", $userid);
                $stmt->execute();
                $stmt->bind_result($rollno, $email);
                $stmt->fetch();
                $stmt->close();

                $_SESSION["email"] = $email;
                $_SESSION["rollno"] = $rollno;

                header("Location: /dept/User/User.php");
            } elseif ($role == "HOD") {
                header("Location: /dept/hod/hod.php");
            }
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Invalid ID or role!";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($role) ?> Login</title>
    <link rel="stylesheet" href="/dept/css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="/dept/img/jaipur_engineering_college_and_research_centre_jecrc__logo__1_-removebg-preview.png" alt="JECRC Logo">
        </div>
        <h2><?= htmlspecialchars($role) ?> Login</h2>

        <?php if (!$role): ?>
            <p style="color:red; text-align:center;">Invalid or missing role in URL (e.g., ?role=Student)</p>
        <?php else: ?>
            <form method="post" action="">
                <input type="hidden" name="role" value="<?= htmlspecialchars($role) ?>">

                <input type="text" name="id" placeholder="Enter Your ID" required><br>
                <input type="password" name="pass" placeholder="Password" required><br>
                <button type="submit">Login</button>

                <?php if ($error) { echo "<p class='error'>$error</p>"; } ?>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
