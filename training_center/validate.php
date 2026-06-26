<?php

//التحقق من المدخلات
function validate($data){
$data = trim($data);  
$data = stripslashes($data);
$data = htmlspecialchars($data, ENT_QUOTES ,"UTF-8"); 
return $data;
}

//التحقق من الايميل
function validate_email($email){
 $email = filter_var($email,FILTER_SANITIZE_EMAIL); //تفلتر الايميل من اي رموز
 //تتحقق من صيغة الايميل 
 if(filter_var($email, FILTER_VALIDATE_EMAIL)){
  return $email;
} else{
return false;
}
}

//التحقق من رقم الجوال

function validate_phone($phone){
    $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);   
    $phone = str_replace("-","",$phone);
    if(preg_match("/^05[69][0-9]{7}$/",$phone)){
        return $phone;
    }else{
        return false;
    }

}

//التحقق من كلمة المرور 

function validate_password($pass){
  $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).{6,}$/" ;  
  if(preg_match($pattern , $pass)){
    return $pass;
  }else{
    return false;
  }

}

?>