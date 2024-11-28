<?php 


//lay id goi edit
$id = $_GET['id'];

//ket noi csdl
require('../db/conn.php');

$sql_str = "select 
products.id as pid,
summary,
description,
stock,
price,
disscounted_price,
products.name as pname,
images,
categories.name as cname,
brands.name as bname,
products.status as pstatus
from products, categories, brands 
where products.category_id=categories.id 
and products.brand_id = brands.id 
and products.id=$id";
// echo $sql_str; exit;   //debug cau lenh

$res = mysqli_query($conn, $sql_str);

$product = mysqli_fetch_assoc($res);

if (isset($_POST['btnUpdate'])){

    $name = $_POST['name'];
    $slug = $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $summary = $_POST['summary'];
    $description = $_POST['description'];
    $stock = (int) $_POST['stock']; // Ép kiểu stock thành số nguyên
    $price = (float) $_POST['price'];
    $discountedprice = (float) $_POST['discountedprice'];
    $category = (int) $_POST['category'];
    $brand = (int) $_POST['brand'];

   //xu ly hinh anh
   $countfiles = count($_FILES['anhs']['name']);


   if (!empty($_FILES['anhs']['name'][0])){//có chọn hình ảnh mới - xóa các ảnh cũ
    //xoa anh cu
    $images_arr = explode(';', $product['images']);
    foreach($images_arr as $img){
        unlink($img);
    }
    
    //them anh moi 
    $imgs = '';
    for($i=0;$i<$countfiles;$i++){
        $filename = $_FILES['anhs']['name'][$i];

        ## Location
        $location = "uploads/".uniqid().$filename;
                    //pathinfo ( string $path [, int $options = PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME ] ) : mixed
        $extension = pathinfo($location,PATHINFO_EXTENSION);
        $extension = strtolower($extension);

        ## File upload allowed extensions
        $valid_extensions = array("jpg", "jpeg", "png","avif");

        $response = 0;
        ## Check file extension
        if(in_array(strtolower($extension), $valid_extensions)) {

            // them vao CSDL - them thah cong moi upload anh len
            ## Upload file
                                //$_FILES['file']['tmp_name']: $_FILES['file']['tmp_name'] - The temporary filename of the file in which the uploaded file was stored on the server.
            if(move_uploaded_file($_FILES['anhs']['tmp_name'][$i],$location)){

                $imgs .= $location . ";";
            }
        }

    }
    $imgs = substr($imgs, 0, -1);

    // echo substr($imgs, 0, -1); exit;
    
    // cau lenh them vao bang
    $sql_str = "UPDATE `products` 
        SET `name`='$name', 
        `slug`='$slug', 
        `description`='$description', 
        `summary`='$summary', 
        `stock`=$stock, 
        `price`=$price, 
        `disscounted_price`=$discountedprice, 
        `images`='$imgs', 
        `category_id`=$category, 
        `brand_id`=$brand 
        WHERE `id`=$id
        ";
   } else {
    $sql_str = "UPDATE `products` 
        SET `name`='$name', 
        `slug`='$slug', 
        `description`='$description', 
        `summary`='$summary', 
        `stock`=$stock, 
        `price`=$price, 
        `disscounted_price`=$discountedprice, 
        `images`='$imgs', 
        `category_id`=$category, 
        `brand_id`=$brand 
        WHERE `id`=$id
        ";
   }
   

//    echo $sql_str; exit;

   //thuc thi cau lenh
   mysqli_query($conn, $sql_str);

   //tro ve trang 
   header("location: ./listproducts.php");
} else {
    require('includes/header.php');
?>

<div class="container">

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Update Product</h1>
                    </div>
                    <form class="user" method="post" action="#" enctype="multipart/form-data">
                            <!-- Form nhập sản phẩm -->
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" 
                                id="name" name="name"
                                aria-describedby="emailHelp" 
                                placeholder="Name Product" 
                                value="<?=$product['pname']?>"
                                required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Images for products</label>
                                <input type="file" class="form-control form-control-user" 
                                id="anhs" name="anhs[]"
                                multiple>

                                <!-- <?php
                                    $arr = explode(';', $product['images']);
                                    foreach($arr as $img)
                                    echo "<img src='$img' height='$height' />";
                                ?> -->
                            </div>

                            <div class="form-group">
                                <label class="form-label">Product Summary:</label>
                            <textarea 
                                name="summary" 
                                class="form-control" 
                                placeholder="Enter..." 
                                value="<?=$product['summary']?>"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Product Description:</label>
                                <textarea 
                                    name="description" 
                                    class="form-control" 
                                    placeholder="Enter..."
                                    value="<?=$product['description']?>"></textarea>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" 
                                        id="stock" name="stock"
                                        aria-describedby="emailHelp" 
                                        placeholder="Enter Quantity:"
                                        value="<?=$product['stock']?>"
                                        required>
                                </div>
                                <div class="col-sm-4 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" 
                                        id="price" name="price"
                                        aria-describedby="emailHelp" 
                                        placeholder="Price: "
                                        value="<?=$product['price']?>"
                                        required>
                                </div>
                                <div class="col-sm-4 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" 
                                        id="discountedprice" name="discountedprice"
                                        aria-describedby="emailHelp" 
                                        placeholder="Discounted Price: "
                                        value="<?=$product['disscounted_price']?>"
                                        required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Category:</label>
                                <select class="form-control" name="category">
                                    <option>Choose Category</option>
                                    <?php
                                    // require('../db/conn.php');
                                    $sql_str = "select * from categories order by name";
                                    $result = mysqli_query($conn, $sql_str);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row['id']; ?>"
                                        <?php 
                                        if($row['name'] == $product['cname'])

                                            echo "selected";
                                        ?>
                                        ><?php echo $row['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Brand:</label>
                                <select class="form-control" name="brand">
                                    <option>Choose Brand</option>
                                    <?php
                                    $sql_str = "select * from brands order by name";
                                    $result = mysqli_query($conn, $sql_str);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row['id']; ?>">
                                            
                                        <?php 
                                        if($row['name'] == $product['bname'])

                                            echo "selected=true";
                                        ?>
                                        
                                        <?php echo $row['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button class="btn btn-primary" name="btnUpdate">Add</button>
                        </form>
                    <hr>
                    
                </div>
            </div>
        </div>
    </div>
</div>

</div>

      
<?php
require('includes/footer.php');
}
?>