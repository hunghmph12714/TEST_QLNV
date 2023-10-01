<?php
include 'db.php';
include 'Nhanvien.php';

$database = new Database();
$db = $database->getConnection();

$nhanvien = new Nhanvien($db);
$stmt = $nhanvien->read();
// nếu tồn tại ID thì xóa 
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    if ($id) {
        $nhanvien->id = $id;
        $nhanvien->delete();
        header("Location: list.php");
    }
}

// nếu người dùng ấn btn thêm nhân viên thì hiện form thêm ra
$showAddForm = false;
if (isset($_POST['showAddForm'])) {
    $showAddForm = true;
} else {
    $showAddForm = false;
}
// nếu người dùng thì ấn submit, không phải ấn submit btn thêm nhân viên thì gán tất cả dữ liệu vào clas Nhanvien và thêm mới
if ($_POST && !$_POST['showAddForm']) {
    $nhanvien->fullname = $_POST['fullname'];
    $nhanvien->phone = $_POST['phone'];
    $nhanvien->email = $_POST['email'];
    $nhanvien->introduce = $_POST['introduce'];
    $nhanvien->start_date = $_POST['start_date'];


    if ($nhanvien->create()) {
        header("Location: list.php");
    } else {
        echo "Không thể thêm nhân viên.";
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Trang Quản Trị</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #444;
            color: #fff;
            width: 250px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav li {
            padding: 10px 15px;
        }

        nav a {
            text-decoration: none;
            color: #fff;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-form-create td {
            border: none;
        }
    </style>
</head>

<body>
    <header>
        <h1>Trang Quản Trị</h1>
    </header>
    <nav>
        <ul>
            <li><a href="list.php">Quản lý nhân viên</a></li>

        </ul>
    </nav>
    <div class="content">
        <h2>Danh sách Nhân viên</h2>
        <!-- Nút "Thêm Nhân viên" để hiển thị form thêm -->
        <form method="post">
            <input type="submit" name="showAddForm" value="Thêm Nhân viên">
        </form>

        <!-- Kiểm tra và hiển thị form thêm nhân viên -->
        <?php if ($showAddForm) : ?>

            <div id="addEmployeeForm">
                <h2>Thêm Nhân viên</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <table class="table-form-create">
                        <tr>
                            <td style="width: 20%;"> <label for="fullname">Họ và Tên</label> </td>
                            <td> <input type="text" name="fullname" value="<?php echo $nhanvien->fullname; ?>" required></td>
                        </tr>
                        <tr>
                            <td> <label for="phone">Số Điện Thoại</label>
                            </td>
                            <td> <input type="text" name="phone" pattern="[0-9]{10}" title="Số điện thoại phải có 10 chữ số" value="<?php echo $nhanvien->phone; ?>" required></td>
                        </tr>

                        <tr>
                            <td> <label for="email">Email</label></td>
                            <td> <input type="email" name="email" value="<?php echo $nhanvien->email; ?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td> <label for="introduce">Giới thiệu bản thân</label>
                            </td>
                            <td> <textarea name="introduce" required><?php echo $nhanvien->introduce; ?> </textarea>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="start_date">Ngày vào làm</label>
                            </td>
                            <td> <input type="date" name="start_date" value="<?php echo $nhanvien->start_date; ?>" required>

                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <button type="submit">Lưu</button>
                                <a href="list.php"><button type="button">Hủy </button></a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên NV</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Giới thiệu</th>
                    <th>Ngày vào làm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['introduce']; ?></td>
                        <td><?php echo $row['start_date']; ?></td>
                        <td>
                            <button> <a href="update.php?id=<?php echo $row['id']; ?>">Sửa</a></button>
                            <button onclick="confirmDelete(<?php echo $row['id']; ?>)">Xóa</button>

                        </td>
                    </tr>
                <?php endwhile; ?>

            </tbody>
        </table>

    </div>
    <script>
        function confirmDelete(id) {
            if (confirm("Bạn có chắc chắn muốn xóa nhân viên này không?")) {
                window.location.href = "list.php?id=" + id;
                window.location.href = "list.php?id=" + id;

            }
        }
    </script>

</body>

</html>