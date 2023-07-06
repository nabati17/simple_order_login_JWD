<?php
session_start();

require_once 'Cart.php'; // Import kelas Cart

if (empty($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['login_success']) && $_SESSION['login_success']) {
    echo '<script>alert("Anda berhasil login");</script>';
    $_SESSION['login_success'] = false;
}

// Inisialisasi daftar pesanan
$pesanan = [
    'Capucino' => 35000,
    'Green Tea Latte' => 40000,
    'Fish and Chips' => 50000,
    'Tuna Sandwich' => 45000,
    'Mineral Water' => 8000,
    'French Fries' => 18000
];

$cart = new Cart($_SESSION); // Buat objek Cart dengan data sesi

// Memperbarui daftar pesanan jika ada input POST yang dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $menu = $_POST['add_to_cart'];
        if (isset($pesanan[$menu])) {
            $cart->addToCart($menu, $pesanan[$menu]);
        }
    }
}

$_SESSION = $cart->getSessionData(); // Simpan data sesi setelah pemrosesan
$_SESSION['login'] = true; 
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <title>Login & Logout PHP</title>

    <style>
    .card {
        background-color: #f2f2f2;
    }

    .btn {
        margin: 5px;
    }
    </style>
</head>

<body>

    <div class="container">

        <div class="row">
            <div class="col-md-4 offset-md-4 mt-5">

                <div class="card">
                    <div class="card-title text-center">
                        <h1>Pesanan</h1>
                    </div>
                    <div class="card-body">

                        <?php foreach ($pesanan as $menu => $harga) : ?>
                        <form action="" method="POST">
                            <input type="hidden" name="add_to_cart" value="<?= $menu ?>">
                            <button type="submit"
                                class="btn mb-3 btn-<?= ($cart->isInCart($menu)) ? 'success' : 'light' ?> btn-block"><?= $menu ?>
                                Rp. <?= $harga ?></button>
                        </form>
                        <?php endforeach; ?>

                        <br>

                        <?php if ($cart->getCart() !== null && !empty($cart->getCart())) : ?>
                        <p>Total Harga: Rp. <?= $cart->getTotal() ?></p>
                        <?php endif; ?>

                        <center>
                            <a href="logout.php">Logout</a>
                        </center>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>

</html>