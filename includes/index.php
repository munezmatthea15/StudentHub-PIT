<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require __DIR__ . '/includes/connection.php';

$totalStudents = $pdo->query(
    "SELECT COUNT(*) FROM students"
)->fetchColumn();

$totalCourses = $pdo->query(
    "SELECT COUNT(*) FROM courses"
)->fetchColumn();

$totalDepartments = $pdo->query(
    "SELECT COUNT(*) FROM departments"
)->fetchColumn();

$totalActive = $pdo->query(
    "SELECT COUNT(*) FROM students WHERE status = 'Active'"
)->fetchColumn();

$students = $pdo->query(
    "SELECT students.*, courses.course_code
     FROM students
     JOIN courses ON students.course_id = courses.id
     ORDER BY students.id DESC LIMIT 5"
)->fetchAll();

$page = 'Dashboard';
require __DIR__ . '/includes/header.php';
?>

<h1>Dashboard</h1>
<p class="subtitle">Welcome back, <?= htmlspecialchars($_SESSION['full_name']) ?>!</p>

<div class="stats">

    <div class="stat-card purple">
        <span>Total Students</span>
        <h2><?= (int)$totalStudents ?></h2>
    </div>

    <div class="stat-card blue">
        <span>Total Courses</span>
        <h2><?= (int)$totalCourses ?></h2>
    </div>

    <div class="stat-card green">
        <span>Departments</span>
        <h2><?= (int)$totalDepartments ?></h2>
    </div>

    <div class="stat-card orange">
        <span>Active Students</span>
        <h2><?= (int)$totalActive ?></h2>
    </div>

</div>

<div class="panel">
    <h2>Recent Students</h2>

    <div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Student Number</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['student_number']) ?></td>
                <td><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></td>
                <td><?= htmlspecialchars($student['course_code']) ?></td>
                <td><?= (int)$student['year_level'] ?></td>
                <td><?= htmlspecialchars($student['status']) ?></td>
            </tr>
        <?php endforeach; ?>

        <?php if (!$students): ?>
            <tr>
                <td colspan="5">No student records yet.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
