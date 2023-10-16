<?php
// Koneksi Database
$server = "localhost";
$user = "root";
$pass = "";
$database = "db_mahasiswa";
// menangani error exception handling
// try catch
// menggunakan API PDO
try {
$koneksi = new PDO("mysql: host=$server; dbname=$database", $user, $pass); 
    $koneksi->setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
} catch(PDOException $e) {
echo "Connection failed: " . $e->getMessage();
}
// inisialisasi variabel 
$nama = $kelas = $alamat = "";

// cek apakah ada tombol simpan yang di klik 
if(isset($_POST['simpan']))
{
    //Cek Apakah data akan diedit atau disimpan baru 
    if($_GET['hal'] == "edit")
    {
    //Data akan di edit
    $stmt = $koneksi->prepare("UPDATE students set 
        nama = :nama,
        kelas = :kelas,
        alamat = :alamat
        WHERE id = :id");
    $stmt->bindParam(':nama', $_POST['nama']);
    $stmt->bindParam(':kelas', $_POST['kelas']);
    $stmt->bindParam(':alamat', $_POST['alamat']);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    echo "<script>
alert('Edit data suksess!'); 
document.location='index.php';
</script>";
}
else
{
//Data akan disimpan Baru
$stmt = $koneksi->prepare("INSERT INTO students (nama, kelas, alamat) VALUES (:nama, :kelas, :alamat)");
$stmt->bindParam(':nama', $_POST['nama']); 
$stmt->bindParam(':kelas', $_POST['kelas']);
$stmt->bindParam(':alamat', $_POST['alamat']);
$stmt->execute();
echo "<script>
alert('Simpan data suksess!'); 
document.location='index.php';
</script>";
}
}
// cek apakah ada kata kunci hal untuk hapus data 
if(isset($_GET['hal']))
{
    if($_GET['hal'] == "edit")
    {
    $stmt = $koneksi->prepare('SELECT * FROM students WHERE id = :id'); 
    $stmt->bindParam('id', $_GET['id']);
    $stmt->execute();

    $data = $stmt->fetch(PDO:: FETCH_ASSOC);
    if($data)
    {
    //Jika data ditemukan, maka data ditampung ke dalam variabel 
    $nama = $data['nama'];
    $kelas = $data['kelas'];
    $alamat = $data['alamat'];
    }
}
else if ($_GET['hal'] == "hapus")
{
$stmt = $koneksi->prepare('DELETE FROM students WHERE id = :id');
$stmt->bindParam('id', $_GET['id']);
$stmt->execute();
echo "<script> 
        alert('Hapus Data Suksess !! '); 
        document.location='index.php'; 
      </script>";
}
}
?>