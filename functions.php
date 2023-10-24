<?php
require __DIR__ . "/data.php";

function addToBasket(string $item) {
// Kanske lägga in sen.
}

function getRandomItem($category) {
    global $snacks;
    $items = $snacks[$category];
    $randomItem = $items[array_rand($items)];
    return $randomItem;
}