<?php require_once('src/header.php'); ?>

<?php
if (isset($_SESSION['user'])) {
    $api = new Api();
    $apiData = $api->getApiData();

    ?>

    <form action="charge.php" method="post" id="payment-form">
        <input type="text" name="firstname" placeholder="firstname"><br>
        <input type="text" name="lastname" placeholder="lastname"><br>
        <input type="text" name="address" placeholder="address"><br>
        <input type="text" name="state" placeholder="state"><br>
        <input type="text" name="zip" placeholder="zip"><br>
        <input type="text" name="country" placeholder="country"><br>
        <input type="text" name="phone" placeholder="phone"><br>
        
        <div class="form-row">
            <label for="card-element">Credit or debit card</label>
            <div id="card-element">
                <!-- a Stripe Element will be inserted here. -->
            </div>
            <!-- Used to display form errors -->
            <div id="card-errors"></div>
        </div>
        <button name="pay">Submit Payment</button>
    </form>
<?php
}
?>

<?php require_once('src/footer.php'); ?>