<?php
// تعديل الدورات

include("../db.php");
session_start();
/* حماية الأدمن */
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../home.php");
    exit();
}

/* التحقق من id */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("معرف غير صحيح");
}

$id = (int)$_GET['id'];

/* جلب بيانات الدورة */
$stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("الدورة غير موجودة");
}

/* جلب التصنيفات */
$categories = mysqli_query($conn, "SELECT * FROM categories");

/* جلب المدربين */
$trainers = mysqli_query($conn, "SELECT * FROM trainers");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>تعديل الدورة</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>

<body>

<div class="container mt-5">
<div class="card p-4 shadow">

    <h2 class="mb-4">تعديل الدورة</h2>

    <form action="update_course.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">

        <!-- اسم الدورة -->
        <div class="mb-3">
          <label>اسم الدورة</label>
          <input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>">
        
        </div>

        <!-- الوصف -->
        <div class="mb-3">
         <label>الوصف</label>
         <textarea name="description" class="form-control" required><?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        
        </div>

        <!-- السعر -->
        <div class="mb-3">
            <label>السعر</label>
            <input type="number" name="price" class="form-control" required step="0.01" min="0"
            value="<?php echo htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8'); ?>">
        
        </div>

        <!-- الصورة -->
        <div class="mb-3">
          <label>الصورة</label>
          <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.gif">
        </div>

        <!-- التصنيف -->
        <div class="mb-3">
          <label>التصنيف</label>
          <select name="category_id" class="form-control" required>
              <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>

                    <option value="<?php echo (int)$cat['id']; ?>"
                        <?php if ($cat['id'] == $row['category_id']) echo "selected"; ?>>

                        <?php echo htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8'); ?>

                    </option>

                <?php } ?>

            </select>
        </div>

        <!-- المدرب -->
        <div class="mb-3">
            <label>المدرب</label>

            <select name="trainer_id" class="form-control" required>

                <?php while ($tr = mysqli_fetch_assoc($trainers)) { ?>

                    <option value="<?php echo (int)$tr['id']; ?>"
                        <?php if ($tr['id'] == $row['trainer_id']) echo "selected"; ?>>

                        <?php echo htmlspecialchars($tr['name'], ENT_QUOTES, 'UTF-8'); ?>

                    </option>

                <?php } ?>

            </select>
        </div>

        <button type="submit" class="btn btn-success w-100">
            تحديث الدورة
        </button>

    </form>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>