<?php
// حذف الطلاب المسجلين بالدورة
include("../db.php");
session_start();

/* حماية الأدمن */
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../home.php");
    exit();
}

/* التحقق من id */
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("معرف غير صحيح");
}

$id = intval($_GET['id']);

/* تنفيذ الحذف */
$sql = "DELETE FROM enrollments WHERE id = ?";
$stmt = $conn->prepare($sql);

if(!$stmt){
    die("خطأ في تجهيز الاستعلام");
}

$stmt->bind_param("i", $id);

if($stmt->execute()){

 header("Location: students.php");
 exit();

}else{

    echo "فشل الحذف";
}

$stmt->close();
$conn->close();
?>