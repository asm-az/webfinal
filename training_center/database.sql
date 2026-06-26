
/* جدول المستخدمين*/

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    gender ENUM("male","female"),
    address VARCHAR(200) NOT NULL,
    age INT,
    image VARCHAR(255),
    role ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


/* جدول التصنيفات*/
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);


/* جدول المدربين*/

CREATE TABLE trainers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialty VARCHAR(150),
    email VARCHAR(150),
    phone VARCHAR(20)
);


/* جدول الدورات*/

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2),
    image VARCHAR(255),
    category_id INT,
    trainer_id INT,
    capacity INT NOT NULL DEFAULT 20,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (trainer_id) REFERENCES trainers(id) ON DELETE CASCADE
);


/* جدول التسجيل بالدورات*/

CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    course_id INT,
    enrollment_date DATE,
    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

/* بيانات تجريبية*/

INSERT INTO users (name, email, password,address, role)
VALUES('Admin', 'admin@gmail.com', '123admin','gaza' ,'admin'),
('User', 'user@gmail.com', '123user','rafah', 'user');

INSERT INTO categories (name)
VALUES('Programming'),('Design'),('Marketing');

INSERT INTO trainers (name, specialty, email, phone)
VALUES('Ahmad Ali', 'Web Development', 'ahmad@gmail.com', '0599999999'),
('Sara Khaled', 'Graphic Design', 'sara@gmail.com', '0598888888');

INSERT INTO courses (title, description, price, image, category_id, trainer_id)
VALUES('PHP Course','Learn PHP from scratch',150,'php.jpg',1,1),
('Photoshop Course','Professional Photoshop training',120,'photoshop.jpg',2,2);

INSERT INTO enrollments (user_id, course_id, enrollment_date) VALUES(2,1,CURDATE());