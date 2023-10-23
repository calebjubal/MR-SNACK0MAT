<?php
session_start();    
require __DIR__ . "/header.php";
require __DIR__ . "/footer.php";
require __DIR__ . "/data.php";

// Kollar om det finns en aktiv korg. Om det inte gör det, sätt den som en tom array.
if(!isset($_SESSION["basket"])) {
    $_SESSION["basket"] = [];
    $_SESSION["price"] = [];
}
// Kollar om något har lagts till i korgen.
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["addtobasket"])) {
    $activeItem = $_POST["addtobasket"];
    $activePrice = $_POST["value"];
    $_SESSION["price"][] = $activePrice;
    $_SESSION["basket"][] = $activeItem;
/*     var_dump($_SESSION["basket"]);
    ?> <hr> <?php
    var_dump($_SESSION["price"]);  !!!TA BORT SEN!!! */
    ?>

<div class="selectedItems">
    <h3>This is your basket:</h3>
    <ul>
        <?php
        // Iterera över korg-session-listan och visa varje item med varje pris för det itemet i listan.
        for ($i=0; $i < count($_SESSION["basket"]); $i++) { 
            $item = $_SESSION["basket"][$i];
            $price = $_SESSION["price"][$i];
            ?> <li><?php echo $item ?> - <?php echo $price ?> &#36; </li>
       <?php } ?>
        <p>Your total is: <?php echo array_sum($_SESSION["price"]) ?> &#36; </p>
    </ul>
</div>
<?php } ?>

<?php
foreach ($snacks as $category => $items) {
    ?><h2><?php echo $category; ?></h2> <hr> <?php
    foreach ($items as $item) {
        ?> <div class="item">
            <h3>
                <?php echo $item["name"]; ?>
            </h3>
            <p>
                <?php echo $item["description"]; ?>
            </p>
            <img src="#" alt="<?php echo $item["name"]; ?>">
            <div class="pricetag">
                <h3>
                    <?php echo $item["price"]; ?> &#36;
                </h3>
                <form action="index.php" method="post">
                    <input type="hidden" name="value" value="<?php echo $item["price"]; ?>">
                    <input type="hidden" name="addtobasket" value="<?php echo $item["name"]; ?>">
                <button type="submit">Add to snackpack</button>
                </form>
            </div>
        </div>
<?php } } ?>