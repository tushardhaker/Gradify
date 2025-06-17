<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "Faculty") {
    header("Location: /dept/login.php");
    exit();
}
$facultyName = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Panel</title>
    <link rel="stylesheet" href="/dept/CSS/Faculty.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

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
    <img src="/dept/img/jaipur_engineering_college_and_research_centre_jecrc__logo__1_-removebg-preview.png" alt="JECRC Logo" class="logo-img">
</div>

<div class="main-content">
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($facultyName); ?> </h1>
    </header>

    <section class="dashboard">
        <div class="card">
            <h2><i class="fas fa-book-open"></i> My Courses</h2>
            <p>Currently handling courses</p>
            <a href="course.php"><button><i class="fas fa-arrow-right"></i> View Courses</button></a>
        </div>
        <div class="card">
            <h2><i class="fas fa-bell"></i> Notification</h2>
            <p>New Announcement from Department</p>
            <a href="notification.php"><button><i class="fas fa-arrow-right"></i> View Notification</button></a>
        </div>
        <div class="card">
            <h2><i class="fas fa-pen-nib"></i> Exam Marks</h2>
            <p>Add and delete marks</p>
            <a href="mid_term_filter.php"><button><i class="fas fa-arrow-right"></i> Edit here</button></a>
        </div>
        <div class="card">
            <h2><i class="fas fa-calendar-alt"></i> Upcoming Events</h2>
            <p>Send message to students</p>
            <a href="ExamNotice.php"><button><i class="fas fa-arrow-right"></i> Click here</button></a>
        </div>
        <div class="card">
            <h2><i class="fas fa-book"></i> View Syllabus</h2>
            <p>Browse syllabus by semester</p>
            <a href="view_syllabus.php"><button><i class="fas fa-arrow-right"></i> Click here</button></a>
        </div>
        <div class="card">
            <h2><i class="fas fa-bullhorn"></i> Broadcasts</h2>
            <p>Latest updates from HOD</p>
            <a href="faculty_dashboard.php"><button><i class="fas fa-arrow-right"></i> View Broadcast</button></a>
        </div>
        <div class="card">
            <h2><i class="fas fa-clock"></i> Timetable</h2>
            <p>View class schedule</p>
            <a href="timetable_view.php"><button><i class="fas fa-arrow-right"></i> View Timetable</button></a>
        </div>
        <div class="card">
            <h2><i class="fas fa-clock"></i> Mark Attendance</h2>
            <p>Marks Attendance of Students</p>
            <a href="faculty_attendance_filter.php"><button><i class="fas fa-arrow-right"></i> click here </button></a>
        </div>

        <div class="card">
            <h2><i class="fas fa-clipboard-list"></i> View Attendance</h2>
            <p>View Attendance of Students</p>
            <a href="view_attendance.php"><button><i class="fas fa-arrow-right"></i> Click here</button></a>
        </div>
    </section>
</div>

<footer class="footer">
    <div class="footer-left">
        <p>&copy; <?php echo date("Y"); ?> Computer Science and Engineering (AI) Department</p>
    </div>
    <div class="footer-right">
        <p>Designed & Developed by Tushar Dhaker || Puneet Agrawal</p>
    </div>
</footer>

</body>
</html>
