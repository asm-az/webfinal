<?php
include "../db.php";

// التحقق من وجود id
if (!isset($_GET['id'])) {
    die("رقم المستخدم غير موجود");
}

$id = intval($_GET['id']);

// جلب بيانات المستخدم
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("المستخدم غير موجود");
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل مستخدم</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <div class="card p-4 shadow">

        <h2 class="mb-4 text-center">
            تعديل بيانات المستخدم
        </h2>

        <form action="update.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="mb-3">
                <label>الاسم</label>
                <input type="text" name="name" class="form-control" required
                value="<?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>">
            
            </div>

            <div class="mb-3">
                <label>الإيميل</label>
                <input type="email" name="email" class="form-control" required
                value="<?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>">
            
            </div>

            <div class="mb-3">
                <label>رقم الجوال</label>
                <input type="text" name="phone" class="form-control" required
                value="<?php echo htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8'); ?>">
            
            </div>

            <div class="mb-3">
                <label>العمر</label>
                <input type="number" name="age" class="form-control" required
                value="<?php echo $row['age']; ?>">
            
            </div>

            <div class="mb-3">

                <label>العنوان</label>
                <input type="text" name="address" class="form-control" required
                value="<?php echo htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8'); ?>">
            
            </div>

            <div class="mb-3">

                <label>الجنس</label><br>
                <input type="radio" name="gender" value="male" <?php if ($row['gender'] == "male") echo "checked"; ?>> ذكر
                <input type="radio" name="gender" value="female" <?php if ($row['gender'] == "female") echo "checked"; ?>> أنثى

            </div>

            <div class="mb-3">
                <label>الصورة</label>
                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
            </div>

            <button type="submit" class="btn btn-success w-100"> تحديث البيانات</button>

        </form>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>