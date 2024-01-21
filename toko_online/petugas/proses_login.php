<?php
session_start();
if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true) {
    header("location: home.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
}

    if (!empty($username) && !empty($password)) {
        include "koneksi.php";
        $stmt = $koneksi->prepare("select * from petugas where username = ? and password = ?");
        $stmt->bind_param("ss", $username, md5($password));
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        echo "<script>alert('Username dan Password harus diisi');location.href='index.php';</script>";
    }
        if ($result->num_rows > 0) {
            $dt_login = $result->fetch_array(MYSQLI_ASSOC);
            $_SESSION['id_petugas'] = $dt_login['id_petugas'];
            $_SESSION['nama_petugas'] = $dt_login['nama_petugas'];
            $_SESSION['status_login'] = true;
            header("location: home.php");            
        } else {
            echo "<script>alert('Username dan Password tidak benar');location.href='index.php';</script>";
        }
$stmt->close();

?>