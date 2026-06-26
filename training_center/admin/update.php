<?php
// صفحة التحديث

include "../db.php";
require_once "../validate.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = (int)$_POST['id'];

    $name = validate($_POST['name']);

    $email = validate_email(validate($_POST['email']));
    if (!$email) {
        die("البريد الإلكتروني غير صالح");
    }

    $phone = validate_phone($_POST['phone']);
    if (!$phone) {
        die("رقم الهاتف غير صالح");
    }

    $gender = $_POST['gender'];

    if (!in_array($gender, ['male', 'female'])) {
        die("الجنس غير صالح");
    }

    $address = validate($_POST['address']);

    $age = filter_var($_POST['age'], FILTER_VALIDATE_INT);

    if ($age === false || $age < 1 || $age > 120) {
        die("العمر غير صالح");
    }

    // التأكد من وجود المستخدم
    $check = $conn->prepare("SELECT id FROM users WHERE id=?");
    $check->bind_param("i", $id);
    $check->execute();

    if ($check->get_result()->num_rows == 0) {
        die("المستخدم غير موجود");
    }

    // رفع الصورة
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        $ext = strtolower(
            pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)
        );

        if (!in_array($ext, $allowed)) {
            die("صيغة الصورة غير مسموحة");
        }

        // التحقق من حجم الصورة (2MB)
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            die("حجم الصورة كبير جداً");
        }

        $image_name = uniqid('user_', true) . "." . $ext;

        if (!move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../uploads/" . $image_name
        )) {
            die("فشل رفع الصورة");
        }

        $sql = "UPDATE users 
                SET name=?, email=?, phone=?, gender=?, address=?, age=?, image=? 
                WHERE id=?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("sssssisi",$name,$email,$phone,$gender,$address,$age,$image_name,$id);

    } else {

        $sql = "UPDATE users SET name=?, email=?, phone=?, gender=?, address=?, age=?  WHERE id=?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("sssssii",$name, $email, $phone, $gender, $address, $age, $id);
    }

    if ($stmt->execute()) {

        $stmt->close();
        $conn->close();

        header("Location: dashboard.php");
        exit();

    } else {

        echo "حدث خطأ أثناء التحديث: " . $stmt->error;
    }
}
?>