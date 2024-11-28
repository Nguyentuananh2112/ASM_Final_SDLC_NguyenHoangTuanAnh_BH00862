<?php
// Kết nối CSDL
require_once("./models/connectDB.php");

$sql = "select * from products";
$statement = $conn->query($sql);
$products = $statement->fetchAll();

echo "<pre>";
print_r($products);

// Dữ liệu
// $products = [
//     "sp1" => [
//         "name" => "Sản phẩm 1",
//         "price" => 100000,
//         "quantity" => 5
//     ],
//     "sp2" => [
//         "name" => "Sản phẩm 2",
//         "price" => 200000,
//         "quantity" => 3
//     ]
// ];
if (isset($_POST['addProduct'])) {
    // echo "Form duoc kich hoat";
    // print_r($_POST['productID']);
    // Luu du lieu => Them san pham vao trong mang
    if (!isset($products[$_POST['productID']])) {
        $products[$_POST['productID']] = [
            "name" => $_POST['name'],
            "price" => $_POST['price'],
            "quantity" => $_POST['quantity'],
        ];
    } else {
        echo "The product was existed!!!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ứng dụng quản lý sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="container">
    <h1>Danh sách sản phẩm</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Giá</th>
                <th scope="col">Số lượng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $key => $product) {

            ?>
                <tr>
                    <th scope="row"><?= $key ?></th>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['price'] ?></td>
                    <td><?= $product['quantity'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="row">
        <div class="col-6">
            <h3>Form thêm sản phẩm</h3>
            <form action="#" method="POST">
                <div class="mb-3">
                    <label for="" class="form-label">Mã sản phẩm</label>
                    <input type="text" class="form-control" name="productID">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Giá sản phẩm</label>
                    <input type="text" class="form-control" name="price">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Số lượng</label>
                    <input type="text" class="form-control" name="quantity">
                </div>

                <button type="submit" name="addProduct" class="btn btn-primary">Thêm sản phẩm</button>
            </form>
        </div>
        <div class="col-6">
            <h3>Form sửa sản phẩm</h3>
        </div>
    </div>

</body>

</html>