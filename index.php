<?php
session_start();    
require __DIR__ . "/header.php";
require __DIR__ . "/footer.php";
require __DIR__ . "/data.php";
require __DIR__ . "/functions.php";

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
<div class="container">
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
        <!-- Echoar ut användarens pris för sin egna korg-->
            <p>Your total is: <?php echo array_sum($_SESSION["price"]) ?> &#36; </p>
        </ul>
    </div>
    <?php } ?>

    <?php for ($i = 0; $i < 4; $i++) {
        $randomCategory = array_rand($snacks);
        $randomItem = getRandomItem($randomCategory);
        $randomItemCount  = 0;
        $mixprice = [];
        ?>
        <div class="mixes">
        <h3>A randomized mix if you don't know what to choose</h3>
            <?php while ($randomItemCount <= 3) { ?>
                <h3><?php echo $randomItem["name"]; ?></h3>
                <p><?php echo $randomItem["description"]; ?></p>
                <p>Price: <?php echo $randomItem["price"]; ?> &#36;</p>
                <?php $randomItemCount++;
                $randomCategory = array_rand($snacks);
                $randomItem = getRandomItem($randomCategory);
                array_push($mixprice, $randomItem["price"]);
            } ?>
        This mix costs: <?php echo array_sum($mixprice); ?> &#36;
        </div>
    <?php } ?>

    <div class="itemlist">
        <h1>Select your own mix of snacks!</h1>
        <?php
        foreach ($snacks as $category => $items) {
            ?><h2><?php echo $category; ?></h2> <hr> <?php
            // Itererar igenom alla saker som är tillgängliga att köpa
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
    </div>
</div>