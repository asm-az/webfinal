<?php
// صفحة  جميع الدورات
include "db.php";

$courses = mysqli_query($conn,"SELECT courses.*, categories.name AS category_name, trainers.name AS trainer_name
FROM courses
LEFT JOIN categories ON courses.category_id = categories.id
LEFT JOIN trainers ON courses.trainer_id = trainers.id
ORDER BY courses.id DESC
");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>الدورات</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

</head>

<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">جميع الدورات</h2>

    <div class="row">

        <?php while($course = mysqli_fetch_assoc($courses)) { ?>

            <?php
                // معالجة الصورة
                $image = !empty($course['image']) ? $course['image'] : 'default.png';
            ?>

            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">

                    <img 
                        src="images/<?php echo $image; ?>" 
                        class="card-img-top" 
                        height="200"
                        onerror="this.src='images/default.png'"
                    >

                    <div class="card-body">

                        <h5>
                            <?php echo htmlspecialchars($course['title']); ?>
                        </h5>

                        <p>
                            <?php echo mb_substr(htmlspecialchars($course['description']), 0, 100); ?>...
                        </p>

                        <p>
                            <strong>السعر:</strong>
                            <?php echo number_format($course['price'], 2); ?> $
                        </p>

                        <p>
                            <strong>المدرب:</strong>
                            <?php echo htmlspecialchars($course['trainer_name']); ?>
                        </p>

                        <a href="course_details.php?id=<?php echo $course['id']; ?>" class="btn btn-primary">
                            تفاصيل الدورة
                        </a>

                    </div>
                </div>
            </div>

        <?php } ?>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>