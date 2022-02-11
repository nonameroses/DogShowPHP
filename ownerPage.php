

<?php
$id = $_GET['id'];
require 'config.php';
$query =  "SELECT * FROM owners where id=?";

if (!empty($conn)) {
    if($stmt =$conn->prepare($query)){
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result= $stmt->get_result();
        $row=$result->fetch_object();

        echo"ID: ". $row->id . "<br>";
        echo"Name: ". $row->name. "<br>";
        echo"Email: ". $row->email. "<br>";
        echo"Address: ". $row->address. "<br>";
        echo"Phone Number: ". $row->phone. "<br>";
        $stmt->close();
    }
}



?>