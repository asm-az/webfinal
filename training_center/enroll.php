<?php
//صفحة التسجيل بالدورة 
include("db.php");
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    die("الدورة غير موجودة");
}

$user_id = (int)$_SESSION['user_id'];
$course_id = (int)$_GET['id'];

$course_check = mysqli_query($conn,
"SELECT * FROM courses WHERE id='$course_id'");

if(mysqli_num_rows($course_check)==0){
    die("الدورة غير موجودة");
}

$course = mysqli_fetch_assoc($course_check);

// عدد المسجلين
$count_query = mysqli_query($conn,"SELECT COUNT(*) AS total FROM enrollments WHERE course_id='$course_id'");

$count = mysqli_fetch_assoc($count_query);

if($count['total'] >= $course['capacity']){
    echo "<script>
    alert('عذراً، المقاعد المتاحة في هذه الدورة اكتملت');
    window.location='courses.php';
    </script>";
    exit();
}

// التحقق من التسجيل المسبق
$check = mysqli_query($conn,"SELECT * FROM enrollments WHERE user_id='$user_id' AND course_id='$course_id'");

if(mysqli_num_rows($check) > 0){

    echo "<script>
    alert('أنت مسجل بالفعل في هذه الدورة');
    window.location='courses.php';
    </script>";

}else{

    mysqli_query($conn,"INSERT INTO enrollments(user_id,course_id,enrollment_date)
    VALUES('$user_id','$course_id',CURDATE())");

    echo "<script>
    alert('تم التسجيل بالدورة بنجاح');
    window.location='courses.php';
    </script>";
}
?>