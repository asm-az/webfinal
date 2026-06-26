<?php
// صفحة المسؤول

session_start();

// التحقق من تسجيل الدخول + الصلاحية
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<title>لوحة التحكم</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2 class="mb-4">لوحة تحكم الأدمن</h2>

    <div class="list-group">

        <a href="add_course.php" class="list-group-item list-group-item-action">
            إضافة دورة
        </a>

        <a href="students.php" class="list-group-item list-group-item-action">
            الطلاب المسجلين
        </a>

        <a href="users.php" class="list-group-item list-group-item-action">
            إدارة المستخدمين
        </a>

        <a href="courses_manage.php" class="list-group-item list-group-item-action">
            إدارة الدورات
        </a>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>