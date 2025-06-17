<?php
session_start();
if (!isset($_SESSION["loggedin"]) || !in_array($_SESSION["role"], ["Faculty", "HOD"])) {
    header("Location: /dept/login.php");
    exit();
}

include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $faculty = $_SESSION["username"];

    $session = $_POST["session"];
    $semester = $_POST["semester"];
    $section = $_POST["section"];
    $subject = $_POST["subject"];
    $attendance_date = $_POST["attendance_date"];

    $stmt = $conn->prepare("SELECT rollno, name, status FROM attendance WHERE session=? AND semester=? AND section=? AND subject=? AND date=? AND faculty_name=?");
    $stmt->bind_param("ssssss", $session, $semester, $section, $subject, $attendance_date, $faculty);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Set CSV headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="attendance_' . $attendance_date . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Roll No', 'Name', 'Status', 'Date', 'Subject', 'Faculty']);

        while ($row = $result->fetch_assoc()) {
            fputcsv($output, [
                $row['rollno'],
                $row['name'],
                $row['status'],
                $attendance_date,
                $subject,
                $faculty
            ]);
        }

        fclose($output);
        exit();
    } else {
        $_SESSION['attendance_update_success'] = "No attendance data found to export.";
        header("Location: view_attendance.php"); // change to your actual page name
        exit();
    }
} else {
    header("Location: view_attendance.php");
    exit();
}
?>
