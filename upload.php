<?php
include "util.php";

cors();
validate();
$uploads_dir = $ini["uploads_dir"] . $_SERVER["PHP_AUTH_USER"];

if (!file_exists($uploads_dir)) {
    $log->info("The directory does not exist. Creating $uploads_dir directory...");
    mkdir($uploads_dir, 0777, true);
}

if (isset($_FILES["file"]["name"])) {
    $name = basename($_FILES["file"]["name"]);
    $tmp_name = $_FILES["file"]["tmp_name"];
    $image = $uploads_dir . "/" . $name;

    if (move_uploaded_file($tmp_name, $image)) {
        header("HTTP/1.1 200 OK");
        $log->info("$name is valid, and was successfully uploaded.");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        $log->error("Error uploading the file: $image.");
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    $log->error("Image data not found.");
}