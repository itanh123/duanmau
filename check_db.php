<?php
session_start();
require_once "commons/loader.php";

echo "<h2>Kiểm tra cấu trúc Database</h2>";

try {
    $conn = connectDB();
    echo "✅ Kết nối database thành công!<br><br>";
    
    // Kiểm tra bảng chi_tiet_don_hang
    echo "<h3>Bảng chi_tiet_don_hang:</h3>";
    $sql = "DESCRIBE chi_tiet_don_hang";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $columns = $stmt->fetchAll();
    
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Cột</th><th>Kiểu</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . $column['Field'] . "</td>";
        echo "<td>" . $column['Type'] . "</td>";
        echo "<td>" . $column['Null'] . "</td>";
        echo "<td>" . $column['Key'] . "</td>";
        echo "<td>" . $column['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
    
    // Kiểm tra dữ liệu trong bảng
    echo "<h3>Dữ liệu trong bảng:</h3>";
    $sql = "SELECT * FROM chi_tiet_don_hang LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
    
    if (count($data) > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr>";
        foreach (array_keys($data[0]) as $key) {
            echo "<th>" . $key . "</th>";
        }
        echo "</tr>";
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Bảng trống<br>";
    }
    
    // Kiểm tra bảng don_hang
    echo "<h3>Bảng don_hang:</h3>";
    $sql = "DESCRIBE don_hang";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $columns = $stmt->fetchAll();
    
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Cột</th><th>Kiểu</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . $column['Field'] . "</td>";
        echo "<td>" . $column['Type'] . "</td>";
        echo "<td>" . $column['Null'] . "</td>";
        echo "<td>" . $column['Key'] . "</td>";
        echo "<td>" . $column['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "<br>";
}

echo "<br><a href='?act=hienthi'>Quay lại trang chủ</a>";
?> 