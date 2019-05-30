<?php include('src/header.php'); ?>

<?php

if (!empty($_GET['tid']) && !empty($_GET['product'])) {
    $GET = filter_var_array($_GET, FILTER_SANITIZE_STRING);

    $tid = $GET['tid'];
    $product = $GET['product'];
} else {
    header('Location: index.php');
}
?>

<h2>Thank you for buying <?php echo $product; ?></h2>
<hr>
<p> Transaction <?php echo $tid ?> </p>
<br>
<a href="index.php">Go back to home</a>

<?php include('src/footer.php'); ?>