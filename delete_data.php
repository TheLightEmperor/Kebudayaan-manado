<?php
include("db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get image filename before deleting the record
    $result = mysqli_query($conn, "SELECT gambar FROM budaya WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
    
    // Delete the image file if it exists
    if (!empty($row['gambar'])) {
        $image_path = "uploads/" . $row['gambar'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    // Delete the record from database
    $sql = "DELETE FROM budaya WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
}
?>