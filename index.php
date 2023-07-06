<?php   
session_start();

if (empty($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION['login_success']) {
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

// Memperbarui daftar pesanan jika ada input POST yang dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $menu = $_POST['add_to_cart'];
        if (isset($pesanan[$menu])) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = []; // Inisialisasi keranjang jika belum ada
            }
            $cartIndex = null;
            foreach ($_SESSION['cart'] as $index => $item) {
                if ($item['menu'] === $menu) {
                    $cartIndex = $index;
                    break;
                }
            }
            if ($cartIndex !== null) {
                // Jika item pesanan sudah ada dalam keranjang, hapus item dari keranjang dan kurangi total harga
                $_SESSION['total'] -= $_SESSION['cart'][$cartIndex]['harga'];
                unset($_SESSION['cart'][$cartIndex]);
            } else {
                // Jika item pesanan belum ada dalam keranjang, tambahkan item ke keranjang dan tambahkan total harga
                $_SESSION['cart'][] = [
                    'menu' => $menu,
                    'harga' => $pesanan[$menu]
                ];
                $_SESSION['total'] += $pesanan[$menu];
            }
        }
    }
}

// Inisialisasi total harga jika sesi total belum ada
if (!isset($_SESSION['total'])) {
    $_SESSION['total'] = 0;
}

// Menghapus semua item pesanan saat halaman di-refresh
if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_SESSION['cart'])) {
    unset($_SESSION['cart']);
    $_SESSION['total'] = 0; // Menetapkan total harga ke 0 saat halaman diperbarui
}
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
                                class="btn mb-3 btn-<?= (isset($_SESSION['cart']) && in_array($menu, array_column($_SESSION['cart'], 'menu'))) ? 'success' : 'light' ?> btn-block"><?= $menu ?>
                                Rp. <?= $harga ?></button>
                        </form>
                        <?php endforeach; ?>

                        <br>

                        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
                        <p>Total Harga: Rp. <?= $_SESSION['total'] ?></p>
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