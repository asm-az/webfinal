<?php

include("../db.php");
session_start();

/* حماية الصفحة */
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../home.php");
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM users");

if (!$query) {
    die("خطأ في الاستعلام: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>إدارة المستخدمين</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2 class="mb-4">إدارة المستخدمين</h2>

    <table class="table table-bordered text-center">

        <tr class="table-dark">
            <th>الرقم</th>
            <th>الاسم</th>
            <th>الإيميل</th>
            <th>الهاتف</th>
            <th>الصلاحية</th>
            <th>تعديل</th>
            <th>حذف</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($query)) { ?>

        <tr>

            <td><?php echo (int)$row['id']; ?></td>

            <td>
                <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['role'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

            <td>
                <a href="edit.php?id=<?php echo (int)$row['id']; ?>"
                   class="btn btn-warning">
                    تعديل
                </a>
            </td>

            <td>
                <a href="delete.php?id=<?php echo (int)$row['id']; ?>"
                   class="btn btn-danger"
                   onclick="return confirm('هل أنت متأكد من الحذف؟')">
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