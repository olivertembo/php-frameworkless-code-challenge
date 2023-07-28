<?php
require_once './DB.php';



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
  $sales = getSales();

  // Filter variables
  $filterCustomer = isset($_GET['customer']) ? $_GET['customer'] : '';
  $filterProduct = isset($_GET['product']) ? $_GET['product'] : '';
  $filterMinPrice = isset($_GET['min_price']) ? $_GET['min_price'] : '';
  $filterMaxPrice = isset($_GET['max_price']) ? $_GET['max_price'] : '';

  $filteredSales = array_filter($sales, function ($sale) use ($filterCustomer, $filterProduct, $filterMinPrice, $filterMaxPrice) {
    $customerMatch = empty($filterCustomer) || stripos($sale['customer_name'], $filterCustomer) !== false;
    $productMatch = empty($filterProduct) || stripos($sale['product_name'], $filterProduct) !== false;
    $priceMatch = (empty($filterMinPrice) || $sale['product_price'] >= $filterMinPrice) &&
      (empty($filterMaxPrice) || $sale['product_price'] <= $filterMaxPrice);
    return $customerMatch && $productMatch && $priceMatch;
  });

  $totalPrice = array_reduce($filteredSales, function ($sum, $sale) {
    return $sum + $sale['product_price'];
  }, 0);

?>
  <!DOCTYPE html>
  <html>

  <head>
    <title>Sales</title>
    <link rel="stylesheet" href="./styles.css" />
  </head>

  <body>
    <h1>Sales Data</h1>
    <!-- Filters Form -->
    <form method="get">
      <label for="customer">Filter by Customer Name:</label>
      <input type="text" name="customer" value="<?php echo htmlspecialchars($filterCustomer); ?>">

      <label for="product">Filter by Product Name:</label>
      <input type="text" name="product" value="<?php echo htmlspecialchars($filterProduct); ?>">

      <label for="min_price">Min Product Price:</label>
      <input type="number" name="min_price" step="0.01" value="<?php echo htmlspecialchars($filterMinPrice); ?>">

      <label for="max_price">Max Product Price:</label>
      <input type="number" name="max_price" step="0.01" value="<?php echo htmlspecialchars($filterMaxPrice); ?>">

      <button type="submit">Apply Filters</button>
    </form>
    <hr />
    <table>
      <thead>
        <tr>
          <th>Sale ID</th>
          <th>Customer Name</th>
          <th>Customer Email</th>
          <th>Product ID</th>
          <th>Product Name</th>
          <th>Product Price</th>
          <th>Sale Date</th>
          <th>Version</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($filteredSales as $sale) : ?>
          <tr>
            <td><?php echo $sale['sale_id']; ?></td>
            <td><?php echo $sale['customer_name']; ?></td>
            <td><?php echo $sale['customer_mail']; ?></td>
            <td><?php echo $sale['product_id']; ?></td>
            <td><?php echo $sale['product_name']; ?></td>
            <td><?php echo $sale['product_price']; ?></td>
            <td><?php echo $sale['sale_date']; ?></td>
            <td><?php echo $sale['version']; ?></td>
          </tr>
        <?php endforeach; ?>

        <tr>
          <td colspan="5">Total Price</td>
          <td><?php echo number_format($totalPrice, 2); ?></td>
          <td colspan="2"></td>
        </tr>

      </tbody>
    </table>
  </body>

  </html>
<?php
  return false;
} else {
  http_response_code(404);
  echo "Not Found";
}
