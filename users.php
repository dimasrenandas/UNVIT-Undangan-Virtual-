<?php
class Employee{
// dbection
private $db;
// Table
private $db_table = "users";
// Columns
public $id;
public $username;
public $fullname;
public $email;
public $password;
public $status;
public $phone;
public $kota;
public $address;
public $identitas;
public $qr_key;
public $created_at;


// Db dbection
public function __construct($db){
$this->db = $db;
}

// GET ALL
public function getEmployees(){
$sqlQuery = "SELECT id, username, fullname, email, password, status, phone, kota, address, identitas, qr_key, created_at  FROM " . $this->db_table . "";
$this->result = $this->db->query($sqlQuery);
return $this->result;
}

// CREATE
public function createEmployee(){
// sanitize
$this->username=htmlspecialchars(strip_tags($this->username));
$this->fullname=htmlspecialchars(strip_tags($this->fullname));
$this->email=htmlspecialchars(strip_tags($this->email));
$this->password=htmlspecialchars(strip_tags($this->password));
$this->status=htmlspecialchars(strip_tags($this->status));
$this->phone=htmlspecialchars(strip_tags($this->phone));
$this->kota=htmlspecialchars(strip_tags($this->kota));
$this->address=htmlspecialchars(strip_tags($this->address));
$this->identitas=htmlspecialchars(strip_tags($this->identitas));
$this->qr_key=htmlspecialchars(strip_tags($this->qr_key));
$this->created_at=htmlspecialchars(strip_tags($this->created_at));
$sqlQuery = "INSERT INTO
". $this->db_table ." SET username = '".$this->username."',
fullname = '".$this->fullname."',email = '".$this->email."',password = '".$this->password."' ,
status = '".$this->status."',phone = '".$this->phone."' , kota = '".$this->kota."' ,address = '".$this->address."' ,identitas = '".$this->identitas."'";

if (!empty($this->username) && !empty($this->password) && !empty($this->fullname)&&!empty($this->phone)&&!empty($this->kota))
{
    $this->db->query($sqlQuery);
    if($this->db->affected_rows > 0){
    return true;
    }
    return false;
    }
}



// UPDATE
public function getSingleEmployee(){
$sqlQuery = "SELECT id, username, fullname, email, password, status, phone, kota, address, identitas, qr_key, created_at FROM
". $this->db_table ." WHERE id = ".$this->id;
$record = $this->db->query($sqlQuery);
$dataRow=$record->fetch_assoc();
$this->username = $dataRow['username'];
$this->fullname = $dataRow['fullname'];
$this->email = $dataRow['email'];
$this->password = $dataRow['password'];
$this->status = $dataRow['status'];
$this->phone = $dataRow['phone'];
$this->kota = $dataRow['kota'];
$this->address = $dataRow['address'];
$this->identitas = $dataRow['identitas'];
}



// DELETE
function deleteEmployee(){
$sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ".$this->id;
$this->db->query($sqlQuery);
if($this->db->affected_rows > 0){
return true;
}
return false;
}
}
?>