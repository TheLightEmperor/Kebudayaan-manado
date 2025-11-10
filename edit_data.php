<?php include("db.php"); 

// Get data by ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM budaya WHERE id=$id");
    $data = mysqli_fetch_assoc($result);
}

// Update data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $gambar_lama = $_POST['gambar_lama'];
    $gambar = $gambar_lama;

    // Handle image upload
    if (!empty($_FILES["gambar"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        
        // Delete old image if exists
        if (!empty($gambar_lama) && file_exists($target_dir . $gambar_lama)) {
            unlink($target_dir . $gambar_lama);
        }
        
        // Upload new image
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = $_FILES["gambar"]["name"];
        }
    }

    $sql = "UPDATE budaya SET nama='$nama', deskripsi='$deskripsi', gambar='$gambar' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        // After successful update, get the updated data
        $result = mysqli_query($conn, "SELECT * FROM budaya WHERE id=$id");
        $data = mysqli_fetch_assoc($result);
        
        echo "<div class='alert alert-success'>
                <i class='fas fa-check-circle'></i>
                <div class='alert-content'>
                    <h4>Berhasil!</h4>
                    <p>Data telah berhasil diperbarui.</p>
                    <a href='index.php' class='alert-button'>Kembali ke Daftar</a>
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kebudayaan</title>
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
            <h1>Edit Data Kebudayaan Manado</h1>
        </div>

        <?php if (isset($data)): ?>
        <div class="form-card">
            <form action="edit_data.php?id=<?php echo $data['id']; ?>" method="POST" enctype="multipart/form-data" class="modern-form">
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                <input type="hidden" name="gambar_lama" value="<?php echo $data['gambar']; ?>">

                <div class="form-group">
                    <label for="nama">Nama Budaya</label>
                    <input type="text" id="nama" name="nama" required 
                           placeholder="Masukkan nama budaya" 
                           value="<?php echo $data['nama']; ?>">
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="5" required 
                              placeholder="Jelaskan tentang budaya ini"><?php echo $data['deskripsi']; ?></textarea>
                </div>

                <div class="form-group">
                    <?php if (!empty($data['gambar'])): ?>
                        <div class="current-image">
                            <label>Gambar Saat Ini:</label>
                            <img src="uploads/<?php echo $data['gambar']; ?>" alt="Current Image" 
                                 style="max-width: 200px; margin: 10px 0;">
                        </div>
                    <?php endif; ?>
                    
                    <label for="gambar" class="file-upload-label">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Pilih Gambar Baru</span>
                    </label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" class="file-upload-input">
                    <div id="file-name" class="file-name"></div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="update" class="submit-button">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        <?php else: ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div class="alert-content">
                    <h4>Error!</h4>
                    <p>Data tidak ditemukan.</p>
                    <a href="index.php" class="alert-button">Kembali ke Daftar</a>
                </div>
            </div>
        <?php endif; ?>
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