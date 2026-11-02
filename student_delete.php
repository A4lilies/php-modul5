<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
include("connection.php");

if (isset($_GET["nim"])) {
    $nim = mysqli_real_escape_string($connection, $_GET["nim"]);

    // Ambil nama mahasiswa untuk pesan konfirmasi
    $query_select = "SELECT name FROM student WHERE nim='$nim'";
    $result_select = mysqli_query($connection, $query_select);
    $data = mysqli_fetch_assoc($result_select);

    if ($data) {
        $name = $data["name"];

        // Jalankan Query Hapus
        $query_delete = "DELETE FROM student WHERE nim='$nim'";
        $result_delete = mysqli_query($connection, $query_delete);

        if ($result_delete) {
            $message = "Mahasiswa dengan nama \"<b>$name</b>\" telah berhasil dihapus.";
        } else {
            die("Query gagal dijalankan: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
        }
    }
}

header("Location: student_view.php?message=" . urlencode($message));
exit();
?>