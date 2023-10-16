<?php 
require "proses.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body{
            background-image: var(--bs-gradient);
        }
    </style>
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row">
            <div class="col">
                <nav class="navbar bg-body-secondary rounded">
                    <div class="container">
                        <a class="navbar-brand">Crud PDO</a>
                        <form action="index.php" method="post" class="d-flex" role="search">
                            <input type="search" class="form-control me-2" name="keyword" id="" aria-label="Search">
                            <button class="btn btn-dark bg.dark.bg-gradient" type="submit" name="cari">Search</button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
        <div class="card mt-3 custom-container">
            <div class="card-header bg-primary text-white d-flex justify-content-center">
                Data Siswa
            </div>
            <div class="card-body" style="background-color: #f2f2f2;">
                <form action="" method="post" >
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" value="<?=@$nama?>" id="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" name="kelas" value="<?=@$kelas?>" id="nama" required>
   
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" required><?=@$alamat?></textarea>
                    </div>
                    <div class="">
                    <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                    <button type="submit" class="btn btn-dark mx-5" style="color: white;">Delete</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header bg-success text-white d-flex justify-content-center">
                Daftar Siswa
            </div>
            <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
            <?php 
                if (isset($_POST["cari"])) {
                    $keyword = "%" . $_POST['keyword'] . "%";
                    $stmt = $koneksi->prepare("SELECT * FROM students WHERE
                        nama LIKE :keyword OR
                        kelas LIKE :keyword OR
                        alamat LIKE :keyword");
                    $stmt -> bindParam(':keyword', $keyword); 
                    $stmt -> execute();
                    } else {
                    $stmt = $koneksi->prepare("SELECT * FROM students ORDER BY id DESC"); 
                    $stmt->execute();

                    }
                    $no = 1;
                    while($data = $stmt -> fetch(PDO :: FETCH_ASSOC)) :
            ?>
           <tr>
        <td><?=$no++; ?></td>
        <td><?=$data['nama']?></td>
        <td><?=$data['kelas']?></td>
        <td><?=$data['alamat']?></td>
        <td>
            <a href="index.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning">Edit</a> 
            <a href="index.php?hal=hapus&id=<?=$data['id']?>" 
               onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger ">Hapus</a>
        </td>
    </tr>
<?php endwhile; //penutup perulangan while ?>
        </table>
                    </div>
                    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>