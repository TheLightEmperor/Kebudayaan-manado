<?php include("db.php"); ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Kebudayaan</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="add-data-container">
        <div class="form-header">
            <a href="index.php" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
            <h1>Tambah Data Kebudayaan Manado</h1>
        </div>

        <div class="form-card">
            <form action="add_data.php" method="POST" enctype="multipart/form-data" class="modern-form">
                <div class="form-group">
                    <label for="nama">Nama Budaya</label>
                    <input type="text" id="nama" name="nama" required placeholder="Masukkan nama budaya">
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="5" required 
                        placeholder="Jelaskan tentang budaya ini"></textarea>
                </div>

                <div class="form-group">
                    <label for="gambar" class="file-upload-label">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Pilih Gambar</span>
                    </label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" class="file-upload-input">
                    <div id="file-name" class="file-name"></div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit" class="submit-button">
                        <i class="fas fa-save"></i>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Display selected filename
        document.getElementById('gambar').addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'Tidak ada file dipilih';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = "";

    // Upload folder
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (!empty($_FILES["gambar"]["name"])) {
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
        $gambar = $_FILES["gambar"]["name"];
    }

    $sql = "INSERT INTO budaya (nama, deskripsi, gambar) VALUES ('$nama', '$deskripsi', '$gambar')";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>
                <i class='fas fa-check-circle'></i>
                <div class='alert-content'>
                    <h4>Berhasil!</h4>
                    <p>Data telah berhasil ditambahkan ke database.</p>
                    <a href='index.php' class='alert-button'>Lihat Data</a>
                </div>
              </div>";
    } else {
        echo "<div class='alert alert-error'>
                <i class='fas fa-exclamation-circle'></i>
                <div class='alert-content'>
                    <h4>Error!</h4>
                    <p>" . mysqli_error($conn) . "</p>
                </div>
              </div>";
    }
}
?>
