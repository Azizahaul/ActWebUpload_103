<?php
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $path = "uploads/" . $file;

    if (file_exists($path)) {
        unlink($path);
        header("Location: index.php?status=ok&msg=" . urlencode("Berkas $file berhasil dihapus."));
    } else {
        header("Location: index.php?status=error&msg=" . urlencode("Berkas tidak ditemukan."));
    }
} else {
    header("Location: index.php");
}
exit;
?>