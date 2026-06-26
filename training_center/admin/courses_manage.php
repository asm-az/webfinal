<?php
//صفحة ادارة الدورات من قبل الادمن
include("../db.php");
session_start();

/* حماية الأدمن*/
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../home.php");
    exit();
}

/* جلب الدورات */
$query = mysqli_query($conn,"SELECT courses.*, categories.name AS category_name,
trainers.name AS trainer_name FROM courses
LEFT JOIN categories ON courses.category_id = categories.id
LEFT JOIN trainers ON courses.trainer_id = trainers.id
ORDER BY courses.id DESC
");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>إدارة الدورات</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>

<body>

<div class="container mt-5">

    <h2 class="mb-4">إدارة الدورات</h2>

    <table class="table table-bordered text-center">

        <tr class="table-dark">
            <th>الصورة</th>
            <th>اسم الدورة</th>
            <th>التصنيف</th>
            <th>المدرب</th>
            <th>السعر</th>
            <th>تعديل</th>
            <th>حذف</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($query)) { ?>

            <?php
                $image = !empty($row['image']) ? $row['image'] : 'default.png';
            ?>

            <tr>

                <td>
                    <img src="../images/<?php echo $image; ?>"
                         width="80"
                         onerror="this.src='../images/default.png'">
                </td>

                <td>
                    <?php echo htmlspecialchars($row['title']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['category_name']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['trainer_name']); ?>
                </td>

                <td>
                    <?php echo number_format($row['price'], 2); ?> $
                </td>

                <td>
                    <a href="edit_course.php?id=<?php echo $row['id']; ?>"
                       class="btn btn-warning">
                       تعديل
                    </a>
                </td>

                <td>
                    <a href="delete_course.php?id=<?php echo $row['id']; ?>"
                       class="btn btn-danger"
                       onclick="return confirm('هل تريد حذف الدورة؟')">
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