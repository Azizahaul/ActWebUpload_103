<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["tmp_name"]);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Periksa apakah berkas sudah ada
if (file_exists($target_file)) {
    $uploadOk = 0;
    $msg = "Maaf, berkas sudah ada.";
}

// Periksa ukuran berkas (maks 500KB)
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $uploadOk = 0;
    $msg = "Maaf, berkas Anda terlalu besar (maks 500KB).";
}

// Hanya izinkan format tertentu (dinonaktifkan untuk praktikum)
/*
if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
    $msg = "Maaf, hanya berkas JPG, JPEG, PNG & GIF yang diperbolehkan.";
    $uploadOk = 0;
}
*/

if ($uploadOk == 0) {
    header("Location: index.php?status=error&msg=" . urlencode($msg ?? "Berkas tidak dapat diunggah."));
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $namaFile = htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
        header("Location: daftar.php?status=ok&msg=" . urlencode("Berkas $namaFile telah diunggah."));
    } else {
        header("Location: index.php?status=error&msg=" . urlencode("Terjadi kesalahan saat mengunggah berkas."));
    }
}
exit;
?>