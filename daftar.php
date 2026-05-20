<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Berkas Terunggah</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f2f5;
      min-height: 100vh;
      padding: 2rem 1rem;
      color: #333;
    }

    .container { max-width: 700px; margin: 0 auto; }

    .header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 1.5rem;
    }

    .header a {
      text-decoration: none;
      color: #3b82f6;
      font-size: 0.875rem;
    }

    .header a:hover { text-decoration: underline; }

    h1 {
      font-size: 1.4rem;
      font-weight: 600;
      color: #1a1a2e;
    }

    .card {
      background: white;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.875rem;
    }

    thead tr { border-bottom: 2px solid #f0f0f0; }

    th {
      text-align: left;
      padding: 8px 10px;
      color: #888;
      font-weight: 500;
      font-size: 0.8rem;
    }

    td {
      padding: 10px;
      border-bottom: 1px solid #f5f5f5;
      vertical-align: middle;
    }

    .preview-box {
      width: 42px; height: 42px;
      border-radius: 8px;
      background: #f0f2f5;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.7rem;
      font-weight: 600;
      color: #666;
      overflow: hidden;
    }

    .preview-box img {
      width: 100%; height: 100%;
      object-fit: cover;
      border-radius: 8px;
    }

    .badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 6px;
      font-size: 0.72rem;
      font-weight: 600;
      background: #e0e7ff;
      color: #3730a3;
    }

    .btn-hapus {
      padding: 5px 14px;
      background: transparent;
      border: 1px solid #fca5a5;
      color: #ef4444;
      border-radius: 7px;
      font-size: 0.8rem;
      cursor: pointer;
    }

    .btn-hapus:hover { background: #fef2f2; }

    .btn-unduh {
      padding: 5px 14px;
      background: transparent;
      border: 1px solid #93c5fd;
      color: #3b82f6;
      border-radius: 7px;
      font-size: 0.8rem;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }

    .btn-unduh:hover { background: #eff6ff; }

    .aksi-group { display: flex; gap: 6px; align-items: center; }

    .empty { text-align: center; color: #aaa; padding: 2rem; font-size: 0.875rem; }

    .msg {
      padding: 10px 14px;
      border-radius: 8px;
      font-size: 0.85rem;
      margin-bottom: 1rem;
    }

    .msg.success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .msg.error   { background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; }

    .btn-unggah {
      display: block;
      text-align: center;
      margin-top: 1.25rem;
    }

    .btn-unggah a {
      display: inline-block;
      padding: 9px 20px;
      background: #3b82f6;
      color: white;
      border-radius: 9px;
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 500;
    }

    .btn-unggah a:hover { background: #2563eb; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>📋 Daftar Berkas Terunggah</h1>
      <a href="index.php">← Kembali Unggah</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
      <div class="msg <?= $_GET['status'] === 'ok' ? 'success' : 'error' ?>">
        <?= htmlspecialchars($_GET['msg']) ?>
      </div>
    <?php endif; ?>

    <div class="card">
      <table>
        <thead>
          <tr>
            <th style="width:56px">Pratinjau</th>
            <th>Nama Berkas</th>
            <th>Tipe</th>
            <th>Ukuran</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $uploadDir = 'uploads/';
          $files = array_diff(scandir($uploadDir), ['.', '..']);
          if (empty($files)):
          ?>
          <tr><td colspan="5" class="empty">Belum ada file yang diunggah.</td></tr>
          <?php else: foreach ($files as $file):
            $path = $uploadDir . $file;
            $ext = strtoupper(pathinfo($file, PATHINFO_EXTENSION));
            $size = filesize($path);
            $sizeStr = $size < 1024 ? $size . ' B' : ($size < 1048576 ? round($size/1024, 2) . ' KB' : round($size/1048576, 2) . ' MB');
            $isImage = in_array(strtolower($ext), ['jpg','jpeg','png','gif','webp']);
          ?>
          <tr>
            <td>
              <div class="preview-box">
                <?php if ($isImage): ?>
                  <img src="<?= htmlspecialchars($path) ?>" alt="<?= htmlspecialchars($file) ?>">
                <?php else: ?>
                  <?= htmlspecialchars($ext) ?>
                <?php endif; ?>
              </div>
            </td>
            <td><?= htmlspecialchars($file) ?></td>
            <td><span class="badge"><?= htmlspecialchars($ext) ?></span></td>
            <td><?= $sizeStr ?></td>
            <td>
              <div class="aksi-group"><a href="unduh.php?file=<?= urlencode($file) ?>" class="btn-unduh">Unduh</a><a href="hapus.php?file=<?= urlencode($file) ?>" onclick="return confirm('Hapus file ini?')"><button class="btn-hapus">Hapus</button></a></div>
            </td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>

      <div class="btn-unggah">
        <a href="index.php">+ Unggah File Baru</a>
      </div>
    </div>
  </div>
</body>
</html>