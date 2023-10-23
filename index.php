<?php
require __DIR__ . "/data.php";

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
                <button>Add to snackpack</button>
            </div>
        </div>
<?php } } ?>