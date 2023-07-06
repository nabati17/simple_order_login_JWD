<?php
session_start();
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
    </style>
</head>

<body>
    <div class="container ">

        <div class="row">
            <div class="col-md-4 offset-md-4 mt-5">

                <?php
                if (isset($_SESSION['error'])) {
                    ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['error'] ?>
                </div>
                <?php
                } elseif (isset($_SESSION['success'])) {
                    ?>
                <?php echo '<script>alert("Anda Berhasil Login.");</script>'?>
            </div>

            <?php
                }
                ?>


            <div class="card ">
                <div class="card-title text-center">
                    <h1>Login Form</h1>
                </div>
                <div class="card-body">
                    <form action="process.php" method="post">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" name="email" class="form-control" id="email" aria-describedby="email"
                                placeholder="email">

                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Password">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>

                </div>
            </div>
        </div>

    </div>

    </div>
</body>

</html>