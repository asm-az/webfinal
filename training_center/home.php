<?php
include("db.php");

/* جلب الدورات من قاعدة البيانات مع اسم المدرب والتصنيف */

$courses = mysqli_query($conn,"SELECT courses.*,categories.name AS category_name,trainers.name AS trainer_name FROM courses
LEFT JOIN categories ON courses.category_id = categories.id
LEFT JOIN trainers ON courses.trainer_id = trainers.id
ORDER BY courses.id DESC");

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>مركز صافي للتدريب والتطوير</title>
  <!-- رابط مكتبة البوتستراب -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
  <!-- ربط ملف الcssالخارجي -->
  <link rel="stylesheet" href="style.css">
  <!-- Font Awesome -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

     <!-- NAVBAR -->

     <nav class="navbar navbar-expand-lg custom-navbar sticky-top">
        <div class="container">

          <!-- LOGO -->
          <a class="navbar-brand d-flex align-items-center gap-3" href="index.php">
            <img src="images/logo.jpg.jpeg" alt="logo" width="50" height="50" class="rounded-circle shadow-sm">
            <span>مركز صافي للتدريب والتطوير</span>
         </a>

          <!-- TOGGLE -->

         <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
           <span class="navbar-toggler-icon"></span>
         </button>

    <!-- NAV LINKS -->

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

        <li class="nav-item"><a class="nav-link active" href="index.php"> الرئيسية </a></li>
        <li class="nav-item"><a class="nav-link" href="courses.php"> الدورات</a></li>
        <!-- LOGIN -->
        <li class="nav-item"><a class="nav-link btn btn-warning text-dark px-3" href="login.php"> تسجيل الدخول</a></li>
        <!-- logout-->
        <li class="nav-item"><a class="nav-link btn btn-warning text-dark px-3"  href="logout.php"> تسجيل الخروج</a></li>
        <!-- REGISTER -->
        <li class="nav-item"><a class="nav-link btn btn-outline-warning px-3" href="register.php"> إنشاء حساب</a></li>

      </ul>

    </div>

  </div>

</nav>

<main>

<!-- HERO -->

<section class="hero">

  <h2>مرحبا بك في</h2>

  <h1>مركز صافي للتدريب والتطوير</h1>

  <p> نساعدك على تطوير مهاراتك وبناء مستقبلك</p>

  <a href="courses.php" class="btn btn-warning mt-3"> ابدأ الآن</a>

</section>

<!-- STATS -->

<section class="stats">

  <div class="stat-box">

    <h2 class="counter" data-target="500">0</h2>

    <p>طالب</p>

  </div>

  <div class="stat-box">

    <h2 class="counter" data-target="20">0</h2>

    <p>دورة تدريبية</p>

  </div>

  <div class="stat-box">

    <h2 class="counter" data-target="15">0</h2>

    <p>مدرب محترف</p>

  </div>

  <div class="stat-box">

    <h2 class="counter" data-target="95">0</h2>

    <p>% رضا الطلاب</p>

  </div>

</section>

<!-- COURSES -->

<section class="projects">

  <h2 class="title"> الدورات التدريبية المميزة</h2>

  <div class="content">
     <!--طالما يوجد دورة جديدة في الاستعلام اعرضها -->
    <?php while($course = mysqli_fetch_assoc($courses)){ ?>

    <div class="project-card">

      <!-- IMAGE -->

      <div class="project-image">

        <img src="images/<?php echo $course['image']; ?>" alt="course image"> <!-- عرض الصورة -->

      </div>

      <!-- INFO -->

      <div class="project-info">
        
        <p class="project-category"> <?php echo $course['description']; ?></p> <!-- عرض الوصف -->

        <!-- TITLE -->

        <div class="project-title">

          <span>
            <?php echo $course['title']; ?>  <!-- عرض اسم الدورة  -->
          </span>
          <a href="course_details.php?id=<?php echo $course['id']; ?>" class="more-details"> عرض الدورة </a>

        </div>

        <br>

        <!-- TRAINER -->

        <small>
          <i class="fa-solid fa-user"></i>
          المدرب: <?php echo $course['trainer_name']; ?>   <!-- عرض المدرب -->
       </small>

        <br><br>

        <!-- CATEGORY -->

        <small>
          <i class="fa-solid fa-layer-group"></i>
          التصنيف:<?php echo $course['category_name']; ?>   <!-- عرض التصنيف -->

        </small>

        <br><br>

        <!-- PRICE -->

        <small>
          <i class="fa-solid fa-money-bill"></i>
          السعر:<?php echo $course['price']; ?>$    <!-- عرض السعر -->

        </small>

      </div>

    </div>

    <?php } ?>

  </div>

  

</section>

<!-- FOOTER -->

<footer class="footer text-center bg-dark text-white">

  <p>
    © 2026 مركز صافي للتدريب والتطوير
  </p>

  <!-- CONTACT -->

  <div class="cont-col">

    <div>

      <i class="fa fa-home"></i>

      <div>

        <h5>شارع جلال</h5>

        <p>غزة - خانيونس</p>

      </div>

    </div>

    <div>

      <i class="fa fa-phone"></i>

      <div>

        <h5>+970598785653</h5>

        <p>9 صباحاً - 4 مساءاً</p>

      </div>

    </div>

    <div>

      <i class="fa fa-envelope"></i>

      <div>

        <h5>
          saficenter26@gmail.com
        </h5>

        <p>البريد الإلكتروني</p>

      </div>

    </div>

  </div>

  <!-- SOCIAL -->

  <div class="social-icons">

    <a href="#">
      <i class="fab fa-whatsapp"></i>
    </a>

    <a href="#">
      <i class="fab fa-instagram"></i>
    </a>

    <a href="#">
      <i class="fab fa-facebook-f"></i>
    </a>

  </div>

</footer>

<!-- WhatsApp -->

<a href="https://wa.me/970598785653"
class="whatsapp-float">

  <i class="fab fa-whatsapp"></i>

</a>

<!-- Bootstrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS -->

<script src="script.js"></script>

</body>
</html>