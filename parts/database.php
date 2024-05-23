<?php
function sqlConnection()
{
    try {
        $dbname = "blog_project";
        $hostName = "localhost";
        $dbuser = "root";
        return new PDO("mysql:host=$hostName;dbname=$dbname", "$dbuser", '');
    } catch (Exception $err) {
        exit("Error is" . $err);
    }
}