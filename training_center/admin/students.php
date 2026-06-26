<?php
include("../db.php");
session_start();

// التحقق من صلاحية الأدمن
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../home.php");
    exit();
}

$sql = "SELECT enrollments.id,users.name AS user_name,courses.title AS course_title,trainers.name AS trainer_name,
enrollments.enrollment_date FROM enrollments
JOIN users ON enrollments.user_id = users.id
JOIN courses ON enrollments.course_id = courses.id
JOIN trainers ON courses.trainer_id = trainers.id";

$query = mysqli_query($conn, $sql);

if (!$query) {
    die("خطأ في الاستعلام: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>الطلاب المسجلين</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2 class="mb-4">الطلاب المسجلين بالدورات</h2>

    <table class="table table-bordered text-center">

        <tr class="table-dark">
            <th>رقم التسجيل</th>
            <th>اسم الطالب</th>
            <th>الدورة</th>
            <th>المدرب</th>
            <th>تاريخ التسجيل</th>
            <th>حذف</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($query)) { ?>

        <tr>
            <td><?php echo (int)$row['id']; ?></td>

            <td>
                <?php echo htmlspecialchars($row['user_name'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['course_title'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['trainer_name'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['enrollment_date'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

            <td>
                <a href="delete_enroll.php?id=<?php echo (int)$row['id']; ?>"
                   class="btn btn-danger"
                   onclick="return confirm('هل تريد حذف التسجيل؟')">
                    حذف
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>