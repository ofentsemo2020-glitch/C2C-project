<?php

$conn = new mysqli(
    "sql101.infinityfree.com",
    "if0_42072891",
    "NarutoSasuke16",
    "if0_42072891_ushop"
);

if($conn->connect_error){

    die("Connection Failed: " . $conn->connect_error);
}

?>