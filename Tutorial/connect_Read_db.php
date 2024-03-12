<?php
//Read Records to database from php

//1.Establish Connection
$host = "localhost";
$username = "root";
$password = "";
$db = "mybook_db";

$connection = mysqli_connect($host, $username, $password, $db);



//2.Create Query


$query = "select * from users";

//3.Launch and Debug Query
$result = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<pre>";
    print_r($row);
    echo "</pre>";

}

