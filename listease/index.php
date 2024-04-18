<?php
//show error
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['email'])){
    header('Location: login.php');
    exit();
}
include('../database_checker.php');
$connection->select_db('listease');
$id = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item = filter_input(INPUT_POST, 'item-name', FILTER_SANITIZE_STRING);
    $stmt = $connection->prepare("INSERT INTO items (name, user_id) VALUES (?, ?)");
    $stmt->bind_param('si', $item, $id);
    $stmt->execute();
    header('Location: index.php');
    exit();
}
$itemsArray = [];
$sql = "SELECT * FROM items WHERE user_id = '$id'";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $itemsArray[] = $row;
    }
}

echo '<!doctype html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">';
echo '<meta http-equiv="X-UA-Compatible" content="ie=edge">';
echo '<link rel="apple-touch-icon" sizes="180x180" href="./img/favicon/apple-touch-icon.png">';
echo '<link rel="icon" type="image/png" sizes="32x32" href="./img/favicon/favicon-32x32.png">';
echo '<link rel="icon" type="image/png" sizes="16x16" href="./img/favicon/favicon-16x16.png">';
echo '<link rel="manifest" href="/site.webmanifest">';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">';
echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">';
echo '<link rel="stylesheet" href="../styles/font.css">';
echo '<title>ListEase</title>';
echo '</head>';
echo '<body>';
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col-12">';
echo '<h1 class="text-center">Shopping list</h1>';
echo '</div>';
echo '</div>';

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger" role="alert">';
    echo $_SESSION['error_message'];
    echo '</div>';
    echo '<script> setTimeout(function () { document.querySelector(\'.alert\').style.display = \'none\'; }, 3000); </script>';
}
unset($_SESSION['error_message']);

echo '<div class="row">';
echo '<div class="col-12">';
echo '<form action="index.php" method="post">';
echo '<div class="input-group mb-3">';
echo '<input type="text" class="form-control" placeholder="Add new item" name="item-name">';
echo '<button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="bi bi-plus-lg"></i></button>';
echo '<a href="logout.php" class="btn btn-danger">Logout</a>';
echo '<button id="switch" class="btn btn-secondary" onclick="cycleThemes()" type="button">Switch</button>';
echo '</div>';
echo '</form>';
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<div class="col-12">';
echo '<ul class="list-group list-group-flush">';
if (empty($itemsArray)) {
    echo '<li class="list-group list-group-item">So empty...</li>';
} else {
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col" class="col-3">Name</th>';
    echo '<th scope="col" class="col-3">Quantity</th>';
    echo '<th scope="col" class="col-3">Cost Per Item</th>';
    echo '<th scope="col" class="col-3">Total Cost</th>';
    echo '<th scope="col" class="col-3">Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($itemsArray as $item) {
        echo '<tr>';
        echo '<td class="align-middle">';
        echo $item['name'];
        echo '</td>';
        echo '<td class="align-middle" id="quantity-' . $item['id'] . '" onclick="replaceWithInput(' . $item['id'] . ', \'quantity\')">';
        echo $item['quantity'];
        echo '</td>';
        echo '<td class="align-middle" id="price-' . $item['id'] . '" onclick="replaceWithInput(' . $item['id'] . ', \'price\')">';

        if (isset($item['price'])) {
            echo number_format($item['price'], 2, ',', ' ') . ' Kč';
        }

        echo '</td>';
        echo '<td class="align-middle">';

        if (isset($item['quantity'], $item['price'])) {
            $price = number_format($item['quantity'] * $item['price'], 2, ',', ' ');
            echo $price . ' Kč';
        } else {
            echo 'N/A';
        }

        echo '</td>';
        echo '<td class="d-flex justify-content-between row">';
        echo '<button type="submit" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#deleteModal' . $item['id'] . '"><i class="bi bi-trash h3"></i></button>';
        if (is_null($item['price'])) {
            echo '<button type="button" class="btn btn-primary col mt-2" data-bs-toggle="modal" data-bs-target="#priceModal' . $item['id'] . '">';
            echo '<i class="bi bi-cash h3"></i>';
            echo '</button>';
            echo '<div class="modal fade text-dark" id="priceModal' . $item['id'] . '" tabindex="-1" aria-labelledby="priceModalLabel" aria-hidden="true">';
            echo '<div class="modal-dialog">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="priceModalLabel">Add price</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body text-dark">';
            echo '<form action="price.php" method="post">';
            echo '<input type="hidden" name="id" value="' . $item['id'] . '">';
            echo '<div class="mb-3">';
            echo '<label for="price" class="form-label me-2">Price</label>';
            echo '<div class="d-flex align-items-center">';
            echo '<input type="number" class="form-control me-2" id="price" name="price">';
            echo '<span class="text-muted">CZK</span>';
            echo '</div>';
            echo '</div>';
            echo '<button type="submit" class="btn btn-primary">Submit</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        if (is_null($item['quantity'])) {
            echo '<button type="button" class="btn btn-primary btn-block col mt-2" data-bs-toggle="modal" data-bs-target="#quantityModal' . $item['id'] . '">';
            echo '<i class="bi bi-plus h3"></i>';
            echo '</button>';
            echo '<div class="modal fade text-dark" id="quantityModal' . $item['id'] . '" tabindex="-1" aria-labelledby="quantityModalLabel" aria-hidden="true">';
            echo '<div class="modal-dialog">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="quantityModalLabel">Add quantity</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body text-dark">';
            echo '<form action="quantity.php" method="post">';
            echo '<input type="hidden" name="id" value="' . $item['id'] . '">';
            echo '<div class="mb-3">';
            echo '<label for="quantity" class="form-label">Quantity</label>';
            echo '<input type="number" class="form-control" id="quantity" name="quantity">';
            echo '</div>';
            echo '<button type="submit" class="btn btn-primary">Submit</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</td>';
        echo '</tr>';
        echo '<div class="modal fade text-dark" id="deleteModal' . $item['id'] . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
        echo '<div class="modal-dialog">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="deleteModalLabel">Delete item</h5>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';
        echo '<div class="modal-body text-dark">';
        echo '<p>Are you sure you want to delete this item?</p>';
        echo '<p><i>' . $item['name'] . '</i></p>';
        echo '<form action="delete.php" method="post">';
        echo '<input type="hidden" name="id" value="' . $item['id'] . '">';
        echo '<button type="submit" class="btn btn-danger">Delete</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
echo '</ul>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>';
echo '<script src="../scripts/dark-mode.js"></script>';
echo '<script src="./scripts/index.js"></script>';
echo '</body>';
echo '</html>';
