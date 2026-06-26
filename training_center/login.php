<?php
//صفحة تسجيل الدخول
include("db.php");
require_once("validate.php");

session_start();

$error = "";

if(isset($_POST['login'])){

    $email = validate_email(validate($_POST['email']));

    if(!$email){
        $error = "البريد الإلكتروني غير صالح";
    }else{

        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if($user){

            if(password_verify($password, $user['password'])){

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                if($user['role'] == 'admin'){
                    header("Location: admin/dashboard.php");
                    exit();
                }else{
                    header("Location: home.php");
                    exit();
                }

            }else{

                $error = "كلمة المرور غير صحيحة";

            }

        }else{

            $error = "هذا الإيميل غير موجود";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تسجيل الدخول</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>

<body class="bg-light">

   <div class="container mt-5">
      <div class="row justify-content-center">
           <div class="col-md-5">

              <div class="card p-4 shadow">

                   <h3 class="text-center mb-3">تسجيل الدخول</h3>

                    <?php if(!empty($error)){ ?>
                     <div class="alert alert-danger">
                       <?php echo $error; ?>
                     </div>
                   <?php } ?>

                   <form method="POST" enctype="multipart/form-data">
                      <div class="mb-3">
                          <label for="email">الإيميل:</label>
                          <input type="email" name="email" class="form-control" required>
                       </div>
                        <br>
                      <div class="mb-3">
                           <label for="password">كلمة المرور:</label>
                           <input type="password" name="password" class="form-control" >
                      </div>
                       <br>
                      <button type="submit" name="login" class="btn btn-primary w-100">دخول</button>
                   </form>
               </div>
          </div> 
        </div>
   </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>