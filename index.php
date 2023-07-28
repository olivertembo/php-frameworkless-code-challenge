<?php
require_once './DB.php';

echo "<br />";

// show mysql info on server
phpinfo();



// Set the path to the products file
$productsFilePath = __DIR__ . '/data/DEV_Sales_full.json';

// Function to read the products data from the file
function readProducts()
{
    global $productsFilePath;
    if (!file_exists($productsFilePath)) {
        return [];
    }

    $productsData = file_get_contents($productsFilePath);
    return json_decode($productsData, true);
}

// Function to save the products data to the file
function saveProducts($products)
{
    global $productsFilePath;
    $productsData = json_encode($products, JSON_PRETTY_PRINT);
    file_put_contents($productsFilePath, $productsData);
}

// Handle the GET request to fetch all products
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo ("Server is running");
    exit();
    $products = readProducts();
    header('Content-Type: application/json');
    echo json_encode($products, JSON_PRETTY_PRINT);
}

// // Handle the POST request to add a new product
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $data = json_decode(file_get_contents('php://input'), true);
//     if ($data && isset($data['name']) && isset($data['price'])) {
//         $products = readProducts();
//         $newProduct = [
//             'name' => $data['name'],
//             'price' => $data['price']
//         ];
//         $products[] = $newProduct;
//         saveProducts($products);

//         // Respond with the newly added product
//         header('Content-Type: application/json');
//         echo json_encode($newProduct, JSON_PRETTY_PRINT);
//     } else {
//         http_response_code(400);
//         echo "Invalid data received.";
//     }
// }
