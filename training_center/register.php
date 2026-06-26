<?php
include "db.php";
require_once "validate.php";

$message = "";
if(isset($_POST['register'])){

    // الاسم
    $name = validate($_POST['name']);
    if(empty($name)){
        header("Location: register.php?error=invalidname");
        exit();
    }

    // الإيميل
    $email = validate_email(validate($_POST['email']));
    if(!$email){
        header("Location: register.php?error=invalidemail");
        exit();
    }

    // الجوال
    $phone = validate_phone($_POST['phone']);
    if(!$phone){
        header("Location: register.php?error=invalidphone");
        exit();
    }

    // الجنس
    $gender = $_POST['gender'] ?? '';
    if(!in_array($gender, ['male', 'female'])){
        header("Location: register.php?error=invalidgender");
        exit();
    }

    // العمر
    $age = filter_var($_POST['age'], FILTER_VALIDATE_INT);
    if($age === false || $age < 1 || $age > 120){
        header("Location: register.php?error=invalidage");
        exit();
    }

    // العنوان
    $address = validate($_POST['address']);
    if(empty($address)){
        header("Location: register.php?error=invalidaddress");
        exit();
    }

    // كلمة المرور
    $password = validate_password($_POST['password']);
    if(!$password){
        header("Location: register.php?error=invalidpassword");
        exit();
    }

    // تأكيد كلمة المرور
    $confirm = $_POST['confirm_password'];

    if($password !== $confirm){

        $message = "<div class='alert alert-danger'>
        كلمات المرور غير متطابقة ❌
        </div>";

    }else{

        // التحقق من وجود الإيميل مسبقاً
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){

            $message = "<div class='alert alert-danger'>
            الإيميل موجود مسبقاً ❌
            </div>";

        }else{

            // تشفير كلمة المرور مرة واحدة فقط
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $image_name = "";

            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){

                $allowed = ['jpg','jpeg','png','gif'];

                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

                if(!in_array($ext, $allowed)){

                    $message = "<div class='alert alert-danger'>
                    يسمح فقط بصور JPG, JPEG, PNG, GIF
                    </div>";

                }else{

                $image_name = uniqid('user_', true) . "." . $ext;

                move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $image_name);
                
                $stmt = $conn->prepare("INSERT INTO users(name,email,password,phone,gender,age,address,image)
                VALUES (?,?,?,?,?,?,?,?)");
                $stmt->bind_param("sssssiss",$name, $email, $hashed_password, $phone, $gender, $age, $address, $image_name);

                    if($stmt->execute()){

                        $message = "<div class='alert alert-success'>
                        تم إنشاء الحساب بنجاح ✅
                        </div>";

                    }else{

                        $message = "<div class='alert alert-danger'>
                        فشل إنشاء الحساب ❌
                        </div>";
                    }
                }

            }else{

                $message = "<div class='alert alert-danger'>
                يرجى رفع صورة شخصية ❌
                </div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>صفحة التسجيل</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>

<body>
 <div class="container mt-5">
       <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow p-4">
                     <?php echo $message; ?>
                    <h2 class="text-center mb-4">تسجيل حساب جديد </h2>

                  <form method="POST" enctype="multipart/form-data">
                     <?php if(isset($_GET["error"])) echo validate($_GET["error"])."<br>";?>
                       <div class="mb-3">
                          <label for="name">الاسم الكامل : </label>
                          <input type="text" name="name" class="form-control" placeholder="الاسم الكامل" required>
                       </div>

                      <div class="mb-3">
                           <label for="email">الايميل:</label>
                           <input type="email" name="email" class="form-control" placeholder="الايميل" required>
                      </div>

                       <div class="mb-3">
                           <label for="phone">رقم الجوال:</label>
                           <input type="text" name="phone" class="form-control" placeholder="رقم الجوال" required>
                      </div>
           
                      <div class="mb-3">
                           <label for="age">العمر:</label><br>
                           <input type="text" name="age" placeholder="العمر"><br>
                     </div>

                       <div class="mb-3">
                         <label for="gender">الجنس:</label><br>
                         <input type="radio" name="gender" value="male"  > ذكر 
                          <input type="radio" name="gender" value="female" > أنثى
                          <br>
                      </div>

                      <div class="mb-3">
                         <label for="address">العنوان:</label><br>
                         <input type="text" name="address" placeholder="العنوان" class="form-control"><br>
                      </div>

                      <div class="mb-3">
                         <label for="password">كلمة السر :</label><br>
                          <input type="password" name="password" required pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{6,}"
                          title="يجب ان تحتوي كلمة السر على حرف كبير وصغير ورقم واحد على الاقل وان تكون 6 احرف او اكتر" 
                          placeholder="كلمة السر " class="form-control"><br>
                      </div>

                      <div class="mb-3">
                         <label for="confirm_password">تاكيد كلمة المرور  :</label><br>
                          <input type="password" name="confirm_password" required placeholder="كلمة السر " class="form-control"><br>
                      </div>

                      <div class="mb-3">
                         <label for="image">الصورة الشخصية  :</label><br>
                          <input type="file" name="image" required placeholder="الصورة الشخصية" class="form-control" required><br>
                      </div>

                      <button type="submit" name="register" class="btn btn-primary w-100">تسجيل </button>

                      <div class="text-center mt-3">
                          <a href="login.php" class="btn btn-link"> لديك حساب؟ تسجيل الدخول </a><br>
                          <a href="home.php" class="btn btn-secondary btn-sm mt-2"> الرجوع للصفحة الرئيسية</a>
                       </div>
                   </form>
             </div>
          </div>
       </div>
  </div>


   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

