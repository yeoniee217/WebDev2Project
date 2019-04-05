<?php
session_start();
include 'php-image-resize-master\lib\ImageResize.php';
use \Gumlet\ImageResize;

function file_upload_path($original_filename, $upload_subfolder_name = 'uploads')
{
    $current_folder = dirname(__FILE__);
    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
    return join(DIRECTORY_SEPARATOR, $path_segments);
}

function file_is_an_image($temporary_path, $new_path)
{
    $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png', 'pdf'];
    $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type = $_FILES['image']['type'];

    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);
    return $file_extension_is_valid && $mime_type_is_valid;
}

$image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
$upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

if ($image_upload_detected) {

    $image_filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
    $image_fileExtention = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    $temporary_image_path = $_FILES['image']['tmp_name'];

    $file_type = $_FILES['image']['type'];

    $new_image_path = file_upload_path($_FILES['image']['name']);

    if (file_is_an_image($temporary_image_path, $new_image_path)) {

        if ($file_type == "application/pdf") {

            move_uploaded_file($temporary_image_path, $new_image_path);

        } elseif (move_uploaded_file($temporary_image_path, $new_image_path)) {
            
            $medImage = new ImageResize(file_upload_path($image_filename . "." . $image_fileExtention));
            $medImage->resizeToWidth(150,150);
            $medImage->save(file_upload_path($_SESSION['id'] . "." . $image_fileExtention));

            header("Location: myAccount.php");
            exit;

        }
    } else {
        header("Location: myAccount.php");
        exit;
    }
} else{
    header("Location: myAccount.php");
    exit;
}

?>