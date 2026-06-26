<?php
// صفحة عرض تفاصيل الدورة
include("db.php");
session_start();

// التحقق من id
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("معرف الدورة غير صحيح");
}

$id = intval($_GET['id']);

$query = mysqli_query($conn,"SELECT courses.*, categories.name AS category_name, trainers.name AS trainer_name FROM courses
LEFT JOIN categories ON courses.category_id = categories.id
LEFT JOIN trainers ON courses.trainer_id = trainers.id
WHERE courses.id = $id
");

$course = mysqli_fetch_assoc($query);

// إذا الدورة غير موجودة
if(!$course){
    die("الدورة غير موجودة");
}

// معالجة الصورة
$image = !empty($course['image']) ? $course['image'] : 'default.png';
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<title>تفاصيل الدورة</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>

<body>

<div class="container mt-5">

    <div class="card shadow p-4">

        <img src="images/<?php echo $image; ?>"
             height="300"
             class="mb-3"
             onerror="this.src='images/default.png'">

        <h2><?php echo htmlspecialchars($course['title']); ?></h2>

        <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>

        <p><strong>السعر:</strong> <?php echo number_format($course['price'], 2); ?> $</p>

        <p><strong>التصنيف:</strong> <?php echo htmlspecialchars($course['category_name']); ?></p>

        <p><strong>المدرب:</strong> <?php echo htmlspecialchars($course['trainer_name']); ?></p>

        <?php if(isset($_SESSION['user_id'])){ ?>
            <a href="enroll.php?id=<?php echo $course['id']; ?>" class="btn btn-success">
                التسجيل بالدورة
            </a>
        <?php }else{ ?>
            <a href="login.php" class="btn btn-warning">
                سجل دخول أولاً
            </a>
        <?php } ?>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>