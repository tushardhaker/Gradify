<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: /dept/login.php");
    exit();
}

include("../db.php");

$role = $_SESSION["role"];
$userId = $_SESSION["username"];
$link = null;
$message = "";
$selectedSemester = "";

// Fetch all distinct semesters for faculty and HOD
$semesters = [];
if ($role === "Faculty" || $role === "HOD") {
    $semesterQuery = "SELECT DISTINCT semester FROM user ORDER BY semester";
    $semesterResult = mysqli_query($conn, $semesterQuery);
    while ($row = mysqli_fetch_assoc($semesterResult)) {
        $semesters[] = $row['semester'];
    }
}

// Syllabus links mapped by semester
$syllabusLinks = [
    '6th' => 'https://rtu.ac.in/index/Adminpanel/Images/Media/Syllabus%203rd%20Year%20CSE(AI)%20V%20&%20VI%20Sem..pdf',
    '4th' => 'https://rtu.ac.in/home/wp-content/uploads/2018/11/Syllabus-CS.pdf'
];

// Form submission handler
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($role === "Faculty" || $role === "HOD") {
        $selectedSemester = $_POST['semester'];
    } elseif ($role === "Student") {
        // Get semester from DB
        $studentQuery = "SELECT semester FROM user WHERE id = '$userId' LIMIT 1";
        $studentResult = mysqli_query($conn, $studentQuery);
        if ($row = mysqli_fetch_assoc($studentResult)) {
            $selectedSemester = $row['semester'];
        }
    }

    // Check if syllabus link exists
    if (isset($syllabusLinks[$selectedSemester])) {
        $link = $syllabusLinks[$selectedSemester];
    } else {
        $message = "No syllabus link available for Semester: $selectedSemester.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Syllabus</title>
    <link rel="stylesheet" href="/dept/CSS/User.css">
</head>
<body>
<style>
    
</style>

<nav class="navbar">
    <div class="logo">CSE(AI) Department</div>
    <ul class="nav-links">
        <li><a href="/dept/home.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="/dept/logout.php" class="logout-btn">Logout</a></li>
    </ul>
</nav>

<div class="logo-container">
    <img src="/dept/img/jaipur_engineering_college_and_research_centre_jecrc__logo__1_-removebg-preview.png" alt="JECRC Logo" class="logo">
</div>

<div class="main-content">
    <h2>View Syllabus</h2>

    <?php if ($role === "Faculty" || $role === "HOD") { ?>
        <form method="POST" action="view_syllabus.php">
            <label for="semester">Select Semester:</label>
            <select name="semester" id="semester" required>
                <option value="" disabled selected>Select Semester</option>
                <?php foreach ($semesters as $sem) { ?>
                    <option value="<?php echo $sem; ?>" <?php if ($selectedSemester === $sem) echo 'selected'; ?>>
                        <?php echo $sem; ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit">View</button>
        </form>
    <?php } elseif ($role === "Student") { ?>
        <form method="POST" action="view_syllabus.php">
            <input type="hidden" name="student_view" value="1">
            <p><strong>Your Semester:</strong>
                <?php
                $studentQuery = "SELECT semester FROM user WHERE id = '$userId' LIMIT 1";
                $studentResult = mysqli_query($conn, $studentQuery);
                if ($row = mysqli_fetch_assoc($studentResult)) {
                    echo $row['semester'];
                }
                ?>
            </p>
            <button type="submit">View Syllabus</button>
        </form>
    <?php } ?>

    <?php if ($link): ?>
        <div class="syllabus-link">
            <h3>Syllabus Link:</h3>
            <a href="<?php echo $link; ?>" target="_blank"><?php echo $link; ?></a>
        </div>
    <?php elseif (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</div>

</body>
</html>
