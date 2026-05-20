<?php
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $path = "uploads/" . $file;

    if (file_exists($path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Length: ' . filesize($path));
        header('Pragma: public');
        readfile($path);
        exit;
    } else {
        header("Location: daftar.php?status=error&msg=" . urlencode("File tidak ditemukan."));
    }
} else {
    header("Location: daftar.php");
}
exit;
?>