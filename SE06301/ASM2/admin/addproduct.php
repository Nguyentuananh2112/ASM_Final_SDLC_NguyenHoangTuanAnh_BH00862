<?php


require('../db/conn.php');

// Lấy dữ liệu từ form
$name = $_POST['name'];
$slug = $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
$summary = $_POST['summary'];
$description = $_POST['description'];
$stock = (int) $_POST['stock']; // Ép kiểu stock thành số nguyên
$price = (float) $_POST['price'];
$discountedprice = (float) $_POST['discountedprice'];
$category = (int) $_POST['category'];
$brand = (int) $_POST['brand'];

// Tạo slug từ tên sản phẩm (có thể tùy chỉnh nếu cần)
// $slug = strtolower(str_replace(' ', '-', $name));


// xử lý hình ảnh
$countfiles = count($_FILES['anhs']['name']);
$imgs = []; // Khởi tạo mảng
for ($i = 0; $i < $countfiles; $i++) {
    $filename = $_FILES['anhs']['name'][$i];

    $location = "uploads/" . uniqid() . $filename;
    $extension = pathinfo($location, PATHINFO_EXTENSION);
    $extension = strtolower($extension);

    // File upload allowed extensions
    $valid_extensions = array("jpg", "jpeg", "png","avif");

    if (in_array($extension, $valid_extensions)) {
        // Upload file
        if (move_uploaded_file($_FILES['anhs']['tmp_name'][$i], $location)) {
            $imgs[] = $location; // Lưu vào mảng
        }
        
    }
}

// Nối các đường dẫn ảnh thành chuỗi, phân tách bằng dấu ';'
$imgs = implode(";", $imgs);

// echo substr($imgs, 0, -1);


// Câu lệnh thêm vào bảng
// $sql_str = "INSERT INTO `products` (
//     `name`, `slug`, `description`, `summary`, `stock`, `price`, `disscounted_price`, `images`, `category_id`, `brand_id`, `status`) 
// VALUES (
//     '$name', '$slug', '$description', '$summary', $stock, $price, $discountedprice, '$imgs', $category, $brand, 'Active'
// );";
$sql_str = "INSERT INTO `products` (`id`, `name`, `slug`, `description`, `summary`, `stock`, `price`, `disscounted_price`, `images`, `category_id`, `brand_id`, `status`, `created_at`, `updated_at`) VALUES 
    (NULL, '$name', 
    '$slug', 
    '$description', '$sumary', $stock, $price, $discountedprice,'$imgs', $category, $brand, 'Active', NULL, NULL);";

echo $sql_str; // Dòng debug (xóa khi đưa vào sản phẩm)

// Thực thi câu lệnh
if (mysqli_query($conn, $sql_str)) {
    header("Location: addproducts.php?message=success"); // Truyền thông báo qua URL
    exit();
} else {
    echo "Lỗi: " . mysqli_error($conn); // Hiển thị lỗi nếu có
}

?>