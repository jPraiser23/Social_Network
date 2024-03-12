<?php
//Read and Write Records to database from php

//1.Establish Connection
$host = "localhost";
$username = "root";
$password = "";
$db = "mybook_db";

$connection = mysqli_connect($host,$username,$password,$db);

//2.Create Query
$first_name = "John";
$last_name = "Praiser";

$query = "insert into users (first_name,last_name) values ('$first_name','$last_name')";

//3.Launch and Debug Query
mysqli_query($connection,$query);

echo mysqli_error($connection);

