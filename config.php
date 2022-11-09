<?php

//De database inloggegevens volgens standaard instellingen van MySQL
const DB_SERVER = 'localhost';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'crud_db';

//Verbinding proberen te maken met de MySQL database
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME) or die ("Error: " . mysqli_connect_error());


