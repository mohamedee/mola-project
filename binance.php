<?php
// binance.php

// Set the content type to JSON so the response will be recognized as JSON
header('Content-Type: application/json');

// Function to fetch data from Binance API
function getBinancePrice($symbol) {
    $url = "https://api.binance.com/api/v3/ticker/price?symbol={$symbol}USDT"; // Binance API endpoint for the symbol
    $json = file_get_contents($url); // Fetch the API data

    if ($json === FALSE) {
        return json_encode(["error" => "Error fetching data from Binance"]);
    }

    $data = json_decode($json, true); // Decode the JSON response

    if (isset($data['price'])) {
        // Return the price as JSON
        return json_encode([
            "symbol" => "{$symbol}USDT",
            "price" => $data['price']
        ]);
    } else {
        return json_encode(["error" => "No price data available"]);
    }
}

// Get the coin symbol from the URL parameter (e.g., BTC, ETH)
if (isset($_GET['symbol'])) {
    $symbol = strtoupper($_GET['symbol']); // Convert to uppercase for Binance (e.g., BTC -> BTCUSDT)
    echo getBinancePrice($symbol); // Return the price in JSON format
} else {
    echo json_encode(["error" => "Please provide a coin symbol in the URL (e.g., ?symbol=BTC)"]);
}
?>
