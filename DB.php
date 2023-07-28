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

function getProducts()
{
  global $conn;
  $query = "SELECT * FROM products";
  try {
    $statement = $conn->prepare($query);
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
  }
  return $data;
}
