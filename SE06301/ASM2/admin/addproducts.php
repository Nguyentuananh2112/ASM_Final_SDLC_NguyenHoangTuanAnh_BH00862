<?php
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
                            <h1 class="h4 text-gray-900 mb-4">Add Product</h1>
                        </div>
                        <form class="user" method="post" action="addproduct.php" enctype="multipart/form-data">
                            <!-- Form nhập sản phẩm -->
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" 
                                id="name" name="name"
                                aria-describedby="emailHelp" 
                                placeholder="Name Product" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Images for products</label>
                                <input type="file" class="form-control form-control-user" 
                                id="anhs" name="anhs[]"
                                multiple>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Product Summary:</label>
                            <textarea 
                                name="summary" 
                                class="form-control" 
                                placeholder="Enter..." ></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Product Description:</label>
                                <textarea 
                                    name="description" 
                                    class="form-control" 
                                    placeholder="Enter..."></textarea>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" 
                                        id="stock" name="stock"
                                        aria-describedby="emailHelp" 
                                        placeholder="Enter Quantity:"
                                        required>
                                </div>
                                <div class="col-sm-4 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" 
                                        id="price" name="price"
                                        aria-describedby="emailHelp" 
                                        placeholder="Price: "
                                        required>
                                </div>
                                <div class="col-sm-4 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" 
                                        id="discountedprice" name="discountedprice"
                                        aria-describedby="emailHelp" 
                                        placeholder="Discounted Price: "
                                        required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Category:</label>
                                <select class="form-control" name="category">
                                    <option>Choose Category</option>
                                    <?php
                                    require('../db/conn.php');
                                    $sql_str = "select * from categories order by name";
                                    $result = mysqli_query($conn, $sql_str);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
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
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button class="btn btn-primary">Add</button>
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
?>

<!-- Kiểm tra và hiển thị thông báo bằng JavaScript -->
<?php if (isset($_GET['message']) && $_GET['message'] == 'success') : ?>
<script>
    alert("Product added successfully!");
</script>
<?php endif; ?>
