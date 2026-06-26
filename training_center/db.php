<?php
/*كود الاتصال بملف قاعدة البيانات*/
$conn= new mysqli ("localhost", "root","", "training_center");/*متغير اسمه اختصار لكونيكت يعني اتصال */
if($conn->connect_error){
    die("connection failed".$conn->connect_error );
}
/*else{
 echo "connection success";
}*/
?>
