<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kebudayaan Manado</title>
    <link rel="stylesheet" href="style.css">
    
    <!-- Google Translate Element -->
    <script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'id',
            includedLanguages: 'en,zh,ja,ko,es,fr,de,ru',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</head>
<body>
    <div id="google_translate_element" class="translate-container"></div>

    <div class="header-container">
        <h1>Kebudayaan Manado</h1>
    </div>
    
    <div class="action-grid">
        <a href="add_data.php" class="action-button">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Data</span>
        </a>
        <div class="action-button search-container">
            <i class="fas fa-search"></i>
            <span>Cari</span>
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari budaya...">
            </div>
        </div>
    </div>
    
    <hr class="styled-hr">

    <div id="budayaContainer">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM budaya");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='budaya' data-nama='" . strtolower($row['nama']) . "' data-deskripsi='" . strtolower($row['deskripsi']) . "'>";
        echo "<div class='budaya-actions'>";
        echo "<a href='edit_data.php?id=" . $row['id'] . "' class='edit-button'><i class='fas fa-edit'></i> Edit</a>";
        echo "<a href='#' onclick='confirmDelete(" . $row['id'] . ")' class='delete-button'><i class='fas fa-trash-alt'></i> Hapus</a>";
        echo "</div>";
        echo "<h2>" . $row['nama'] . "</h2>";
        echo "<p>" . $row['deskripsi'] . "</p>";
        if (!empty($row['gambar'])) {
            echo "<img src='uploads/" . $row['gambar'] . "' width='200'>";
        }
        echo "</div>";
    }
    ?>
    </div>

    <script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const budayaItems = document.querySelectorAll('.budaya');
        
        budayaItems.forEach(item => {
            const nama = item.getAttribute('data-nama');
            const deskripsi = item.getAttribute('data-deskripsi');
            const shouldShow = nama.includes(searchTerm) || deskripsi.includes(searchTerm);
            
            item.style.display = shouldShow ? 'block' : 'none';
            if (shouldShow) {
                item.style.animation = 'fadeIn 0.5s ease';
            }
        });
    });

    // Auto-focus search when clicking the search button
    document.querySelector('.search-container').addEventListener('click', function(e) {
        if (!e.target.matches('input')) {
            document.getElementById('searchInput').focus();
        }
    });
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            window.location.href = 'delete_data.php?id=' + id;
        }
    }
    </script>
</body>
</html>
