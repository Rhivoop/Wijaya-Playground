<!DOCTYPE html>
<html lang="en"><!-- Basic -->
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
     <!-- Site Metas -->
    <title>Wijaya Playground</title>  
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">    
	<!-- Site CSS -->
    <link rel="stylesheet" href="css/style.css">    
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<!-- Start header -->
	<header class="top-navbar">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="index.php">
					<h2>WIJAYA PLAYGROUND</h2>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-rs-food" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbars-rs-food">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
						<li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
						<li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
						<li class="nav-item"><a class="nav-link" href="review.php">Review</a></li>
						<li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<!-- End header -->
	
	<!-- Start All Pages -->
	<div class="all-page-title page-breadcrumb">
		<div class="container text-center">
			<div class="row">
				<div class="col-lg-12">
					<h1>Review</h1>
				</div>
			</div>
		</div>
	</div>
	<!-- End All Pages -->
	
		<!-- Start Review section -->
		<div class="contact-box">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="heading-title text-center">
							<h2>Review</h2>
							<p>Hasil Ulasan Customer Ada Disini!</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
// Menghubungkan ke database menggunakan PDO (PHP Data Object)
try {
    $koneksi = new PDO("mysql:host=localhost;dbname=oop", "root", "");
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Koneksi ke database gagal: " . $e->getMessage();
}

// Mengambil data ulasan dari tabel 'review'
$stmt = $koneksi->prepare("SELECT * FROM review");
$stmt->execute();
$ulasan = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Tampilkan ulasan-ulasan yang ada -->
<div class="container mb-5">
    <div class="row">
        <?php foreach ($ulasan as $komentar) : ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-review">
                    <div class="card-body">
                        <p class="card-text"><?php echo $komentar['komentar']; ?></p>
                        <h5 class="card-title"><?php echo $komentar['nama']; ?></h5>
                        <div><?php echo "<p>⭐" . $komentar['rating'] . "!</p>"; ?></div>
                        <h6 class="card-subtitle mb-2 text-muted">Ulasan Pada, <?php echo $komentar['tanggal']; ?></h6>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Menghubungkan ke database menggunakan PDO
        $koneksi = new PDO("mysql:host=localhost;dbname=oop", "root", "");
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Mendapatkan data dari formulir
        $nama = $_POST['nama'];
        $ulasan = $_POST['ulasan']; // Mengubah dari 'komentar' menjadi 'ulasan'
        $rating = $_POST['rating'];
        $date = $_POST['tanggal'];

        // Menyiapkan dan mengeksekusi query untuk menyimpan data ke dalam database
        $stmt = $koneksi->prepare("INSERT INTO review (nama, komentar, rating, tanggal) VALUES (:nama, :komentar, :rating, :tanggal)");
		
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':komentar', $ulasan); // Mengubah dari ':komentar' menjadi ':ulasan'
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':tanggal', $date);
        $stmt->execute();

        echo "Ulasan berhasil disimpan.";
		echo '<meta http-equiv="refresh" content="1">';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>




<!-- Formulir -->
<div class="container mb-5">
    <div class="row">
        <div class="col-lg-12">
            <h2>Tambah Komentar</h2>
            <form action="review.php" method="post">
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="komentar">Ulasan:</label>
                    <textarea class="form-control" id="komentar" name="ulasan" rows="4" required></textarea>
                </div>
				<div class="form-group">
					<label for="tanggal">Tanggal:</label>
					<input type="date" class="form-control" id="tanggal" name="tanggal" required>
				</div>
                <div class="form-group">
					<label for="rating">Rating:</label>
                    <select class="form-control" id="rating" name="rating" required>
						<option value="1">1 Bintang</option>
                        <option value="2">2 Bintang</option>
                        <option value="3">3 Bintang</option>
                        <option value="4">4 Bintang</option>
                        <option value="5">5 Bintang</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-common">Kirim Ulasan</button>
            </form>
        </div>
    </div>
</div>

		
		<!-- end form -->
		<!-- End Review section -->
	
	
	<!-- Start Contact info -->
	<div class="contact-box">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="heading-title text-center">
						<h2>Contact</h2>
						<p>Hubungi Kami Disini!</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Contact -->
	
	<!-- Start Contact info -->
	<div class="contact-imfo-box">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <i class="fa fa-whatsapp"></i>
                <div class="overflow-hidden">
                    <h4>WhatsApp</h4>
                    <p class="lead">
                        <a href="https://wa.me/6282124818217" target="_blank">082124818217</a>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <i class="fa fa-facebook"></i>
                <div class="overflow-hidden">
                    <h4>Facebook</h4>
                    <p class="lead">
                        <a href="https://facebook.com/wijayaplayland" target="_blank">Wijaya Playland</a>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <i class="fa fa-envelope"></i>
                <div class="overflow-hidden">
                    <h4>Email</h4>
                    <p class="lead">
                        <a href="mailto:wijayaplayground@gmail.com">wijayaplayground@gmail.com</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
	<!-- End Contact info -->
	<!-- Start Footer -->
	<footer class="footer-area bg-f">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<h3>About Us</h3>
					<p>Selamat Datang di Wijaya Playground yang terletak di Indoor Playground Jln. Perbatasan Negara saka, negeri katon Pesawaran (Setelah pertashop pasar Jambon)</p>
				</div>

				<div class="col-lg-3 col-md-6">
					<h3>Contact information</h3>
					<p class="lead">Jln. Perbatasan Negara saka, negeri katon Pesawaran (Setelah pertashop pasar Jambon)
					</p>
					<p class="lead"><a href="#">+62 821-2481-8217</a></p>
					<p><a href="#"> @wijayaland.id</a></p>
				</div>
				<div class="col-lg-3 col-md-6">
					<h3>Opening hours</h3>
					<p>Buka Jam 07:00 - 12:00 WIB</p>
				</div>
			</div>
		</div>
		
		<div class="copyright">
			<div class="container">
				<div class="row">
				<div class="col-lg-12 text-center">
					<p class="company-name">&copy;<a href="#">Wijaya Playground</a> Design By : <a href="#">oop</a></p>
				</div>

				</div>
			</div>
		</div>
		
	</footer>
<!-- End Footer -->
	<a href="#" id="back-to-top" title="Back to top" style="display: none;"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a>

	<!-- ALL JS FILES -->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
	<script src="js/jquery.superslides.min.js"></script>
	<script src="js/images-loded.min.js"></script>
	<script src="js/isotope.min.js"></script>
	<script src="js/baguetteBox.min.js"></script>
	<script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>