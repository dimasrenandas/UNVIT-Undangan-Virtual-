<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../database.php';
include_once '../users.php';
$database = new Database();
$db = $database->getConnection();
$item = new Employee($db);

$item->username = $_GET['username'];
$item->fullname=$_GET['fullname'];
$item->email=$_GET['email'];
$item->password=$_GET['password'];
$item->status=$_GET['status'];
$item->phone=$_GET['phone'];
$item->kota=$_GET['kota'];
$item->address=$_GET['address'];

$item->password=password_hash($_GET['password'], PASSWORD_DEFAULT);

//
// $item->name = $_GET['name'];
// $item->email = $_GET['email'];
// $item->designation = $_GET['designation'];
// $item->created = date('Y-m-d H:i:s');
if($item->createEmployee()===True){
echo 'Employee created successfully.';
} else{
echo 'Employee could not be created.';
}
?>