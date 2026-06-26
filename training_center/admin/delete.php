<?php
//صفحة الحذف
include "../db.php";
session_start();

/* حماية الأدمن */
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../dashboard.php");
    exit();
}

/* التحقق من id */
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("معرف غير صحيح");
}

$id = intval($_GET['id']);

/*  حذف المستخدم */
$sql = "DELETE FROM users WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if($stmt->execute()){

    header("Location: dashboard.php");
    exit();

}else{

    echo "فشل الحذف";
}

?>