<!DOCTYPE html>
<html>
<head>
	<title>CRUD Tes BCA</title>
	<link rel="icon" href="" />
</head>
<body>

<?php

// --- koneksi ke database
$koneksi = mysqli_connect("localhost","root","","test_bca") or die(mysqli_error());

// --- Fngsi tambah data (Create)
function tambah($koneksi){
	
	if (isset($_POST['btn_simpan'])){
		$id = $_POST['id_nasabah'];
		$nominal = $_POST['nominal'];
		$jenis = $_POST['jenis'];
		$tanggal = $_POST['tanggal'];
		
		if(!empty($nominal) && !empty($jenis) && !empty($tanggal)){
			$sql = "INSERT INTO transaksi (id_nasabah,nominal, jenis, tanggal) VALUES(".$id.",'".$nominal."','".$jenis."','".$tanggal."')";
			$simpan = mysqli_query($koneksi, $sql);
			if($simpan && isset($_GET['aksi'])){
				if($_GET['aksi'] == 'create'){
					header('location: index.php');
				}
			}
		} else {
			$pesan = "Tidak dapat menyimpan, data belum lengkap!";
		}
	}

	?> 
		<form action="" method="POST">
			<fieldset>
				<legend><h2>Tambah data</h2></legend>
				<label>ID Nasabah <input type="text" name="id_nasabah" /></label> <br>
				<label>Nominal <input type="number" name="nominal" /></label> <br>
				<label>Jenis <input type="text" name="jenis" /></label><br>
				<label>Tanggal panen <input type="date" name="tanggal" /></label> <br>
				<br>
				<label>
					<input type="submit" name="btn_simpan" value="Simpan"/>
					<input type="reset" name="reset" value="Besihkan"/>
				</label>
				<br>
				<p><?php echo isset($pesan) ? $pesan : "" ?></p>
			</fieldset>
		</form>
	<?php

}
// --- Tutup Fngsi tambah data


// --- Fungsi Baca Data (Read)
function tampil_data($koneksi){
	$sql = "SELECT * FROM transaksi";
	$query = mysqli_query($koneksi, $sql);
	$sql2= "SELECT * FROM saldo";
	$query2 = mysqli_query($koneksi, $sql2);

	echo "<fieldset>";
	echo "<legend><h2>Data Transaksi</h2></legend>";
	
	echo "<table border='1' cellpadding='10'>";
	echo "<tr>
			<th>ID Nasabah</th>
			<th>Nominal </th>
			<th>Jenis</th>
			<th>Tanggal</th>
			<th>Tindakan</th>
		  </tr>";
	
	while($data = mysqli_fetch_array($query)){
		?>
			<tr>
				<td><?php echo $data['id_nasabah']; ?></td>
				<td><?php echo $data['nominal']; ?></td>
				<td><?php echo $data['jenis']; ?> </td>			
				<td><?php echo $data['tanggal']; ?></td>
				<td>
					<a href="index.php?aksi=update&id=<?php echo $data['id_nasabah']; ?>&id_nasabah=<?php echo $data['id_nasabah']; ?>&nominal=<?php echo $data['nominal']; ?>&jenis=<?php echo $data['jenis']; ?>&tanggal=<?php echo $data['tanggal']; ?>">Ubah</a> |
					<a href="index.php?aksi=delete&id=<?php echo $data['id_nasabah']; ?>">Hapus</a>
				</td>
			</tr>
		<?php
	}
	echo "</table>";
	echo "</fieldset>";

	echo "<fieldset>";
	echo "<legend><h2>Data Saldo</h2></legend>";
	
	echo "<table border='1' cellpadding='10'>";
	echo "<tr>
			<th>ID Nasabah</th>
			<th>Nama</th>
			<th>Saldo</th>
			<th>Tindakan</th>
		  </tr>";
	
	while($data = mysqli_fetch_array($query2)){
		?>
			<tr>
				<td><?php echo $data['Id']; ?></td>
				<td><?php echo $data['nama']; ?></td>
				<td><?php echo $data['saldo']; ?> </td>			
		        <td>
					<a href="index.php?aksi=update&Id=<?php echo $data['Id']; ?>&Id=<?php echo $data['Id']; ?>&nama=<?php echo $data['nama']; ?>&saldo=<?php echo $data['saldo']; ?>">Ubah</a> |
					<a href="index.php?aksi=delete&Id=<?php echo $data['Id']; ?>">Hapus</a>
				</td>
			</tr>
		<?php
	}
	echo "</table>";
	echo "</fieldset>";
}
// --- Tutup Fungsi Baca Data (Read)


// --- Fungsi Ubah Data (Update)
function ubah($koneksi){

	// ubah data
	if(isset($_POST['btn_ubah'])){
		$id = $_POST['id'];
		$id_nasabah = $_POST['id_nasabah'];
		$nominal = $_POST['nominal'];	
		$jenis = $_POST['jenis'];	
		$tanggal = $_POST['tanggal'];
		
		if(!empty($id_nasabah) && !empty($nominal) && !empty($jenis) && !empty($tanggal)){
			$perubahan = "id_nasabah='".$id_nasabah."',nominal=".$nominal.",jenis=".$jenis.",tanggal='".$tanggal."'";
			$sql_update = "UPDATE transaksi SET ".$perubahan." WHERE id=$id";
			$sql_update2 = "UPDATE saldo SET ".$id_nasabah." WHERE id = $id_nasabah";
			$update = mysqli_query($koneksi, $sql_update);
			$update2 = mysqli_query($koneksi, $sql_update2);
			if($update && isset($_GET['aksi'])){
				if($_GET['aksi'] == 'update'){
					header('location: index.php');
				}
			}
		} else {
			$pesan = "Data tidak lengkap!";
		}
		if($update2 && isset($_GET['aksi'])){
			if($_GET['aksi'] == 'update'){
				header('location: index.php');
			}
		}
	} else {
		$pesan = "Data tidak lengkap!";
	}
	// tampilkan form ubah
	if(isset($_GET['id'])){
		?>
			<a href="index.php"> &laquo; Home</a> | 
			<a href="index.php?aksi=create"> (+) Tambah Data</a>
			<hr>
			
			<form action="" method="POST">
			<fieldset>
				<legend><h2>Ubah data</h2></legend>
				<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
				<label>ID Nasabah <input type="text" name="id_nasabah" value="<?php echo $_GET['id_nasabah'] ?>"/></label> <br>
				<label>Nominal <input type="number" name="nominal" value="<?php echo $_GET['nominal'] ?>"/></label><br>
				<label>Jenis <input type="text" name="jenis" value="<?php echo $_GET['jenis'] ?>"/></label><br>
				<label>Tanggal<input type="date" name="tanggal" value="<?php echo $_GET['tanggal'] ?>"/></label> <br>
				<br>
				<label>
					<input type="submit" name="btn_ubah" value="Simpan Perubahan"/> atau <a href="index.php?aksi=delete&id=<?php echo $_GET['id'] ?>"> (x) Hapus data ini</a>!
				</label>
				<br>
				<p><?php echo isset($pesan) ? $pesan : "" ?></p>
				
			</fieldset>
			</form>
		<?php
	}
	
}
// --- Tutup Fungsi Update


// --- Fungsi Delete
function hapus($koneksi){

	if(isset($_GET['id']) && isset($_GET['aksi'])){
		$id = $_GET['id'];
		$sql_hapus = "DELETE FROM transaksi WHERE id=" . $id;
		$hapus = mysqli_query($koneksi, $sql_hapus);
		
		if($hapus){
			if($_GET['aksi'] == 'delete'){
				header('location: index.php');
			}
		}
	}
	
}
// --- Tutup Fungsi Hapus


// ===================================================================

// --- Program Utama
if (isset($_GET['aksi'])){
	switch($_GET['aksi']){
		case "create":
			echo '<a href="index.php"> &laquo; Home</a>';
			tambah($koneksi);
			break;
		case "read":
			tampil_data($koneksi);
			break;
		case "update":
			ubah($koneksi);
			tampil_data($koneksi);
			break;
		case "delete":
			hapus($koneksi);
			break;
		default:
			echo "<h3>Aksi <i>".$_GET['aksi']."</i> tidak ada!</h3>";
			tambah($koneksi);
			tampil_data($koneksi);
	}
} else {
	tambah($koneksi);
	tampil_data($koneksi);
}

?>
</body>
</html>
