<?php
/**
 * Safely handles an uploaded image: validates size + real MIME type,
 * generates a random name and moves it to the target directory.
 *
 * @return array [success(bool), value(string)] value = stored filename or error message
 */
function save_uploaded_image($fileField, $targetDir, $prefix = '', $maxBytes = 3145728) {
    if (!isset($_FILES[$fileField]) || $_FILES[$fileField]['error'] !== UPLOAD_ERR_OK) {
        return [false, "No file uploaded or upload error occurred."];
    }

    $file = $_FILES[$fileField];

    if ($file['size'] > $maxBytes) {
        return [false, "File too large. Maximum allowed size is 3 MB."];
    }

    // Validate the REAL mime type (not just the extension)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];
    if (!isset($allowed[$mime])) {
        return [false, "Only JPG, PNG or WEBP images are allowed."];
    }

    // Random name prevents path traversal / overwriting / executable uploads
    $newName = $prefix . time() . '_' . bin2hex(random_bytes(6)) . '.' . $allowed[$mime];
    $target  = rtrim($targetDir, '/') . '/' . $newName;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        return [false, "Could not save the uploaded file."];
    }

    return [true, $newName];
}
