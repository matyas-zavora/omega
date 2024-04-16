<?php
session_start();

include('../database_checker.php');
if (!isset($_SESSION['email'])) header('Location: login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item = $_POST['item-name'];
    $connection->query("INSERT INTO items (name, user_id) VALUES ('$item', '$id')");
    header('Location: index.php');
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="180x180" href="./img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="../styles/font.css">
    <title>ListEase</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Shopping list</h1>
        </div>
    </div>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['error_message']; ?>
        </div>
        <script> setTimeout(function () {
                document.querySelector('.alert').style.display = 'none';
            }, 3000); </script>
    <?php endif; ?>
    <?php unset($_SESSION['error_message']); ?>

    <div class="row">
        <div class="col-12">
            <form action="index.php" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Add new item" name="item-name">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i
                                class="bi bi-plus-lg"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <ul class="list-group list-group-flush">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($itemsArray as $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $item['price'] . ' CZK'; ?></td>
                            <td><?php ?></td>
                            <td>
                                <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?php echo $item['id']; ?>"><i
                                            class="bi bi-trash h1"></i></button>
                                <?php if (is_null($item['price'])) : ?>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#priceModal<?php echo $item['id']; ?>">
                                        <i class="bi bi-cash h1"></i>
                                    </button>
                                    <div class="modal fade text-dark" id="priceModal<?php echo $item['id']; ?>"
                                         tabindex="-1" aria-labelledby="priceModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="priceModalLabel">Add price</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-dark">
                                                    <form action="price.php" method="post">
                                                        <input type="hidden" name="id"
                                                               value="<?php echo $item['id']; ?>">
                                                        <div class="mb-3">
                                                            <label for="price" class="form-label me-2">Price</label>
                                                            <div class="d-flex align-items-center">
                                                                <input type="number" class="form-control me-2"
                                                                       id="price"
                                                                       name="price">
                                                                <span class="text-muted">CZK</span>
                                                            </div>

                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Submit
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif; ?>
                                <?php if (is_null($item['quantity'])) : ?>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#quantityModal<?php echo $item['id']; ?>">
                                    <i class="bi bi-plus h1"></i>
                                </button>
                                <div class="modal fade text-dark" id="quantityModal<?php echo $item['id']; ?>"
                                     tabindex="-1" aria-labelledby="quantityModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="quantityModalLabel">Add quantity</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body
                                            text-dark">
                                                <form action="quantity.php" method="post">
                                                    <input type="hidden" name="id"
                                                           value="<?php echo $item['id']; ?>">
                                                    <div class="mb-3">
                                                        <label for="quantity" class="form-label">Quantity</label>
                                                        <input type="number" class="form-control" id="quantity"
                                                               name="quantity">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <?php endif; ?>
                            <div class="modal fade text-dark" id="deleteModal<?php echo $item['id']; ?>"
                                 tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Delete item</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body
                                            text-dark">
                                            <p>Are you sure you want to delete this item?</p>
                                            <p><i><?php echo $item['name'] ?></i></p>
                                            <form action="delete.php" method="post">
                                                <input type="hidden" name="id"
                                                       value="<?php echo $item['id']; ?>">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>
            </ul>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../scripts/dark-mode.js"></script>
</body>
</html>