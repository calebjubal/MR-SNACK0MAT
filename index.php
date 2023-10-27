<?php
session_start();    
require __DIR__ . "/header.php";
require __DIR__ . "/footer.php";
require __DIR__ . "/data.php";
require __DIR__ . "/functions.php";

?> <div class='container'> <?php

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
        <!-- Echoar ut användarens pris för sin egna korg-->
            <p>Your total is: <?php echo array_sum($_SESSION["price"]) ?> &#36; </p>
        </ul>
        <form action="reset_session.php" method="post">
        <button type="submit">Checkout</button>
        </form>
    </div>
    <?php } ?>
    <?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["search"])) {
    $searchQuery = $_POST["search"];
    $searchQuery = sanitizeName($searchQuery);
    $searchResults = [];

    // Loopa igenom snacks listan och hitta matchningar.
    foreach ($snacks as $category => $items) {
        foreach ($items as $snack) {
            // Om $searchquery finns i snack-listan så får vi ut positionen av strängen i listan. Den lägger vi sen in i sökresultatslistan.
            if (stripos($snack["name"], $searchQuery) !== false) {
                $searchResults[] = $snack;
            }
        }
    } ?> <h3>This is your result!</h3>
    <div class="searchitemsholder"> <?php
        foreach ($searchResults as $snack) { ?>
            <div class="item"> 
            <h3><?php echo $snack["name"];?></h3>
            <h3><?php echo $snack["price"]; ?> &#36;</h3>
            <h4><?php echo $snack["description"]; ?></h4>
            <img src="https://htmlcolorcodes.com/assets/images/colors/gray-color-solid-background-1920x1080.png">
            <form action="index.php" method="post">
                            <input type="hidden" name="value" value="<?php echo $snack["price"]; ?>">
                            <input type="hidden" name="addtobasket" value="<?php echo $snack["name"]; ?>">
                        <button type="submit">Add to snackpack</button>
                        </form>
            </div><?php
        }
    ?></div><?php
}
?>

<div class="mixbox">
    <!-- $i är lika med 1 eftersom att jag vill ha nummer som startar med 1 på titeln av varje mix -->
    <?php for ($i = 1; $i < 5; $i++) {
        $randomCategory = array_rand($snacks);
        $randomItem = getRandomItem($randomCategory);
        $randomItemCount  = 0;
        $mixprice = [];
        ?>
        <div class="mixes">
        <h3>Randomized mix #<?php echo $i ?></h3>
        <img src="<?php echo $basketimages[$i]; ?>" alt="">
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
            <form action="index.php" method="post">
                <input type="hidden" name="addtobasket" value="Randomized mix #<?php echo $i ?>">
                <input type="hidden" name="value" value="<?php echo array_sum($mixprice); ?>">
                <button type="submit">Add to cart</button>
            </form>
        </div>
    <?php } ?>
</div>
    <div class="itemlist">
        <h1>Select your own mix of snacks!</h1>
        <div class="searchbardiv">
            <form method="post" action="index.php">
                <input type="text" name="search" placeholder="Search snacks...">
                <button type="submit">Search</button>
            </form>
        </div>
        <?php
        foreach ($snacks as $category => $items) {
            ?><div class="category-container">
                    <h2><?php echo $category; ?></h2> <?php
            // Itererar igenom alla saker som är tillgängliga att köpa
            foreach ($items as $item) {
                ?> <div class="item">
                    <h3>
                        <?php echo $item["name"]; ?>
                    </h3>
                    <p>
                        <?php echo $item["description"]; ?>
                    </p>
                    <img src="https://htmlcolorcodes.com/assets/images/colors/gray-color-solid-background-1920x1080.png" alt="<?php echo $item["name"]; ?>">
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
        <?php } ?> </div> <?php } ?>
    </div>
</div>