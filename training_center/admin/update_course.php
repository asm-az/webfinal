<?php
include("../db.php");
require_once("../validate.php");

// تحديث الدورة
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = (int)$_POST['id'];
    $title = validate($_POST['title']);
    $description = validate($_POST['description']);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);

    if ($price === false || $price < 0) {
        die("السعر غير صالح");
    }

    $category_id = (int)$_POST['category_id'];
    $trainer_id = (int)$_POST['trainer_id'];

    // في حال تم رفع صورة جديدة
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            die("صيغة الصورة غير مسموحة");
        }

        // الحد الأقصى 2MB
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            die("حجم الصورة كبير جداً");
        }

        $image = uniqid('course_', true) . "." . $ext;

        if (!move_uploaded_file(
            $_FILES['image']['tmp_name'],"../images/" . $image)) {
            die("فشل رفع الصورة");
        }

        $sql = "UPDATE courses SET title=?, description=?, price=?, image=?, category_id=?, trainer_id=? WHERE id=?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("sdssiii",$title,$description,$price,$image,$category_id,$trainer_id,$id);

    } else {

        $sql = "UPDATE courses SET title=?, description=?, price=?, category_id=?, trainer_id=? WHERE id=?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssdiii",$title,$description,$price,$category_id,$trainer_id,$id);
    }

    if ($stmt->execute()) {

        $stmt->close();
        $conn->close();

        header("Location: courses.php");
        exit();

    } else {

        echo "حدث خطأ أثناء التحديث: " . $stmt->error;
    }
}
?>