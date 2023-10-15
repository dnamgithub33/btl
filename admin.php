<?php
session_start();
if (!isset($_SESSION['user']))
    header("location: index.php?Message=Login To Continue");
elseif ($_SESSION['user']!="admin")
    header("location: index.php?Message=You are not admin");
include "dbconnect.php";
if (isset($_GET['Message'])) {
        print '<script type="text/javascript">
                   alert("' . $_GET['Message'] . '");
               </script>';
    }
?>
<?php
if (isset($_POST["submit_product"])) {
    $target_dir = "img/books/"; // Thư mục lưu trữ file sau khi upload
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // Đường dẫn lưu trữ file

    // Kiểm tra xem file đã tồn tại chưa
    if (file_exists($target_file)) {
        header("location: admin.php?Message=File already exists");
    } else {
        // Kiểm tra kích thước tệp (giới hạn kích thước tệp theo nhu cầu của bạn)
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            header("location: admin.php?Message=File is too large");
        } else {
            // Di chuyển tệp đã tải lên vào thư mục đích
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " uploaded successfully";
            } else {
                echo "Error";
            }
        }
        $PID = mysqli_real_escape_string($con, $_POST["PID"]);
        $Title = mysqli_real_escape_string($con, $_POST["Title"]);
        $Author = mysqli_real_escape_string($con, $_POST["Author"]);
        $MRP = mysqli_real_escape_string($con, $_POST["MRP"]);
        $Price = mysqli_real_escape_string($con, $_POST["Price"]);
        $Discount = mysqli_real_escape_string($con, $_POST["Discount"]);
        $Available = mysqli_real_escape_string($con, $_POST["Available"]);
        $Publisher = mysqli_real_escape_string($con, $_POST["Publisher"]);
        $Edition = mysqli_real_escape_string($con, $_POST["Edition"]);
        $Description = mysqli_real_escape_string($con, $_POST["Description"]);
        $Language = mysqli_real_escape_string($con, $_POST["Language"]);
        $Page = mysqli_real_escape_string($con, $_POST["Page"]);
        $Weight = mysqli_real_escape_string($con, $_POST["Weight"]);

        $sql = "select * from products where PID = '$PID'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE products
                    SET Title = '$Title', Author = '$Author', MRP = '$MRP', Price = '$Price', Discount = '$Discount', Available = '$Available', Publisher = '$Publisher', Edition = '$Edition', Description = '$Description', Language = '$Language', Page = '$Page', Weight = '$Weight'
                    WHERE PID = '$PID'";
            $result = mysqli_query($con, $sql);
            print '
               <script type="text/javascript">alert("This product is already exists, Infomation is updated");</script>
                    ';
        }
        else{
            $sql = "INSERT INTO products (PID, Title, Author, MRP, Price, Discount, Available, Publisher, Edition, Description, Language, page, weight)
                    VALUES ('$PID', '$Title', '$Author', '$MRP', '$Price', '$Discount', '$Available', '$Publisher', '$Edition', '$Description', '$Language', '$Page', '$Weight')";
            $result = mysqli_query($con, $sql);
            print '
               <script type="text/javascript">alert("This product is uploaded");</script>
                    ';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>admin</title>
    <style>
            body {
                font-family: Arial, sans-serif;
            }
            h2 {
                color: #333;
            }
            form {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-gap: 10px;
            }
            label {
                font-weight: bold;
            margin-right: 10px;
            }
            input, select {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
            padding-left: 10px;
            }
            select {
                padding: 8px;
            }
            input[name="submit_product"] {
                background-color: #4CAF50;
                color: #fff;
                padding: 10px 20px;
                border: none;
                cursor: pointer;
            }
            input[name="open_submit_product"] {
                background-color: #4CAF50;
                color: #fff;
                padding: 10px 20px;
                border: none;
                cursor: pointer;
            }
            input[name="close_submit_product"] {
                background-color: #FF0000;
                color: #fff;
                padding: 10px 20px;
                border: none;
                cursor: pointer;
                margin-top: 8px;
            }
            input[name="open_show_user"] {
                background-color: #4CAF50;
                color: #fff;
                padding: 10px 20px;
                border: none;
                cursor: pointer;
            }
            .table {
                border-collapse: collapse;
                width: 100%;
            }

            .table th, .table td {
                border: 1px solid #ddd;
                padding: 8px;
            }

            .table tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            .table th {
                background-color: #4CAF50;
                color: white;
            }

        </style>
</head>
<body>
    <h2>Upload a new product.</h2>
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <input type="submit" value="Upload Product" name="open_submit_product">
    </form>
    <?php
        if(isset($_POST['open_submit_product'])){
            echo '
        <form action="admin.php" method="post" enctype="multipart/form-data">
            <label for="fileToUpload">Ảnh minh họa:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" require>
    
            <label for="PID">PID:</label>
            <input type="text" name="PID" id="PID" require>
    
            <label for="Title">Title:</label>
            <input type="text" name="Title" id="Title" require>
    
            <label for="Author">Author:</label>
            <input type="text" name="Author" id="Author" require>
    
            <label for="MRP">MRP:</label>
            <input type="number" name="MRP" id="MRP" step="any" required>
    
            <label for="Price">Price:</label>
            <input type="number" name="Price" id="Price" step="any" required>
    
            <label for="Discount">Discount:</label>
            <input type="number" name="Discount" id="Discount" step="1" required>
    
            <label for="Available">Available:</label>
            <input type="number" name="Available" id="Available" step="1" required>
    
            <label for="Publisher">Publisher:</label>
            <input type="text" name="Publisher" id="Publisher" require>
    
            <label for="Edition">Edition:</label>
            <input type="text" name="Edition" id="Edition" require>
    
            <label for="Category">Category:</label>
            <select name="Category" id="Category" required>
                <option value="Entrance Exam">Entrance Exam</option>
                <option value="Literature and Fiction">Literature and Fiction</option>
                <option value="Biographies and Auto Biographies">Biographies and Auto Biographies</option>
                <option value="Academic and Professional">Academic and Professional</option>
                <option value="Children and Teens">Children and Teens</option>
                <option value="Regional Books">Regional Books</option>
                <option value="Business and Management">Business and Management</option>
                <option value="New">New Releases</option>
                <option value="Health and Cooking">Health and Cooking</option>
                <option value="Others">Others</option>
            </select>
    
            <label for="Description">Description:</label>
            <input type="text" name="Description" id="Description">
    
            <label for="Language">Language:</label>
            <input type="text" name="Language" id="Language" require>
    
            <label for="Page">Page:</label>
            <input type="number" name="Page" id="Page" step="1" required>
    
            <label for="Weight">Weight:</label>
            <input type="number" name="Weight" id="Weight" step="1" required>
            
            <input type="submit" value="Upload Product" name="submit_product">
        </form>
        ';
        }
            
        
    ?>
    <form action="admin.php" method="post" enctype="multipart/form-data">
            <input type="submit" value="Close" name="close_submit_product">
        </form>
    <h2>All user.</h2>
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <input type="submit" value="Show users" name="open_show_user">
    </form>
    <?php
        if(isset($_POST['open_show_user'])){
            $sql="SELECT * FROM users;";
            $users=mysqli_query($con, $sql);
            echo '<form>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>UserName</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                    </thead>
                    <tbody>';
        ?>
                    <?php
                        
                        foreach ($users as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value['UserName']; ?></td>
                                <td><?php echo $value['Password']; ?></td>
                                <td><?php echo $value['Mail']; ?></td>
                                <td><?php echo $value['Phone']; ?></td>
                                <td>
                                    <button class="button">
                                        <a href="delete.php?uname=<?php echo $value['UserName']; ?>" class="text-light">Delete</a>
                                    </button>
                                </td>
                                <td>
                                    <button class="button">
                                        <a href="cart_show.php?uname=<?php echo $value['UserName']; ?>" class="text-light">Cart</a>
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                    
                    ?>
                    </tbody>
                </table>
            </div>
            </form>
            <?php
        }
    ?>
    
</body>
</html>
