<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dsn = "mysql:host=php-test-mysql-1;port=3306;dbname=test_db";


$username = "user";
$password = "password";

$conn;

try {
  $conn  = new PDO($dsn, $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection Failed: " . $e->getMessage();
}

function getSales()
{
  global $conn;
  $query = "SELECT * FROM sales";
  try {
    $statement = $conn->prepare($query);
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
  }
  return $data;
}

function seedSales ()
{
  global $conn;
  $productsFilePath = __DIR__ . '/mock/DEV_Sales_full.json';

  $productsData = file_get_contents($productsFilePath);
  $products = json_decode($productsData, true);

  $query = "INSERT INTO sales (sale_id, customer_name, customer_mail, product_id, product_name, product_price, sale_date, version) VALUES (:sale_id, :customer_name, :customer_mail, :product_id, :product_name, :product_price, :sale_date, :version)";
  try {
    $statement = $conn->prepare($query);
    foreach ($products as $product) {
      $statement->bindValue(':sale_id', $product['sale_id']);
      $statement->bindValue(':customer_name', $product['customer_name']);
      $statement->bindValue(':customer_mail', $product['customer_mail']);
      $statement->bindValue(':product_id', $product['product_id']);
      $statement->bindValue(':product_name', $product['product_name']);
      $statement->bindValue(':product_price', $product['product_price']);
      $statement->bindValue(':sale_date', $product['sale_date']);
      $statement->bindValue(':version', $product['version']);
      $statement->execute();
    }
   
  } catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
  }

}

function migration ()
{
  global $conn;
  $query = "CREATE TABLE IF NOT EXISTS sales (
    sale_id INT(6) DEFAULT NULL,
    customer_name VARCHAR(255) DEFAULT NULL,
    customer_mail VARCHAR(60) DEFAULT NULL,
    product_id INT DEFAULT NULL,
    product_name text DEFAULT NULL,
    product_price decimal(10,2) DEFAULT NULL,
    sale_date datetime DEFAULT NULL,
    version VARCHAR(60) DEFAULT NULL
  )";
  try {
    $statement = $conn->prepare($query);
    $statement->execute();
  } catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
  }
}
