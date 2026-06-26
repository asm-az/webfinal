<?php
// إضافة دورة
include("../db.php");

if(isset($_POST['add'])){

    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $price = $_POST['price'];

    $capacity = (int)$_POST['capacity'];

    $category_id = (int)$_POST['category_id'];

    $trainer_id = (int)$_POST['trainer_id'];

    $image = $_FILES['image']['name'];

    $tmp = $_FILES['image']['tmp_name'];

    // التحقق من نوع الصورة
    $allowed = ['jpg','jpeg','png','webp'];

    $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));

    if(!empty($image) && !in_array($ext, $allowed)){
        die("يسمح فقط بصور JPG, JPEG, PNG, WEBP");
    }

    // رفع الصورة
    if(!empty($image)){
        move_uploaded_file($tmp, "../images/".$image);
    }

    mysqli_query($conn,"INSERT INTO courses
    (title,description,price,image,category_id,trainer_id,capacity)
    VALUES
    ('$title','$description','$price','$image','$category_id','$trainer_id','$capacity')");

    echo "<script>alert('تم إضافة الدورة بنجاح');</script>";
}

$categories = mysqli_query($conn,"SELECT * FROM categories");

$trainers = mysqli_query($conn,"SELECT * FROM trainers");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إضافة دورة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h4>إضافة دورة جديدة</h4>
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                  <label class="form-label">اسم الدورة:</label>
                  <input type="text" class="form-control" name="title"  placeholder="أدخل اسم الدورة" required>
                </div>


                <div class="mb-3">
                  <label class="form-label">الوصف:</label>
                  <textarea  class="form-control"  name="description" rows="4" placeholder="اكتب وصف الدورة" required></textarea>
                </div>


                <div class="row">

                    <div class="col-md-6 mb-3">
                      <label class="form-label">سعر الدورة:</label>
                      <input type="number" class="form-control" name="price" min="0" step="0.01" placeholder="مثال: 99.99" required>
                    </div>


                    <div class="col-md-6 mb-3">
                      <label class="form-label">عدد المقاعد:</label>
                      <input type="number" class="form-control" name="capacity" min="1" placeholder="عدد المقاعد" required>
                    </div>

                </div>


                <div class="mb-3">
                  <label class="form-label">صورة الدورة:</label>
                  <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png,.webp">
                </div>


                <div class="mb-3">
                    <label class="form-label">التصنيف</label>
                    <select class="form-select" name="category_id" required>
                        <option selected disabled>
                            اختر التصنيف
                        </option>

                        <?php while($cat = mysqli_fetch_assoc($categories)){ ?>

                            <option value="<?php echo $cat['id']; ?>">
                                <?php echo $cat['name']; ?>
                            </option>

                        <?php } ?>

                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label">المدرب</label>
                    <select class="form-select" name="trainer_id" required>
                        <option selected disabled>
                            اختر المدرب
                        </option>

                        <?php while($tr = mysqli_fetch_assoc($trainers)){ ?>

                            <option value="<?php echo $tr['id']; ?>">
                                <?php echo $tr['name']; ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>


                <div class="text-center">
                    <button type="submit"  name="add"  class="btn btn-success px-5">
                        إضافة الدورة
                    </button>
                </div>


            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>