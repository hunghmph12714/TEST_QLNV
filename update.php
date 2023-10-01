<?php
include 'db.php';
include 'Nhanvien.php';

$database = new Database();
$db = $database->getConnection();

$nhanvien = new Nhanvien($db);
// nếu ấn submit sẽ gắn tất cả dữ liệu vào class Nhanvien
if ($_POST) {
    $nhanvien->fullname = $_POST['fullname'];
    $nhanvien->phone = $_POST['phone'];
    $nhanvien->email = $_POST['email'];
    $nhanvien->introduce = $_POST['introduce'];
    $nhanvien->start_date = $_POST['start_date'];
    // nếu có id trên đường dẫn thì gán id vào class Nhanvien
    if ($_GET['id']) {
        $nhanvien->id = $_GET['id'];
        if ($nhanvien->update()) {
            header("Location: list.php");
        } else {
            echo "Không thể cập nhật thông tin nhân viên.";
        }
    }
}
// nếu tồn tại id trên đường dẫn thì lấy ra dữ liệu bản ghi đó
$id = isset($_GET['id']) ? $_GET['id'] : die('Lỗi: Không tìm thấy ID nhân viên.');
$nhanvien->id = $id;
$nhanvien->readOne();

?>

<!DOCTYPE html>
<html lang="en">

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
            border: none;
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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

        <h2>Chỉnh sửa nhân viên</h2>
        <form method="post">
            <table>
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
                    <td></td>
                    <td>
                        <button type="submit">Lưu</button>
                        <a href="list.php"><button type="button">Quay lại </button></a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>