<?php require_once('src/header.php'); ?>

<?php
if (isset($_SESSION['user'])) {
    $api = new Api();
    $apiData = $api->getApiData();

    ?>

    <form action="charge.php" method="post" id="payment-form">
        <div class="form-row">
            <label for="card-element">Credit or debit card</label>
            <div id="card-element">
                <!-- a Stripe Element will be inserted here. -->
            </div>
            <!-- Used to display form errors -->
            <div id="card-errors"></div>
        </div>
        <button>Submit Payment</button>
    </form>
<?php
}
?>

<?php require_once('src/footer.php'); ?>