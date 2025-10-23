<?php
include_once '../../../config.php';
include_once "../../api.php";
require '../../../parseEnv.php';
parseEnv(__DIR__ . '/../../../.env');

$baseApiKey = getenv('BASE_API_KEY');

Api::Header("Access-Control-Allow-Origin: *");
Api::Header("Access-Control-Allow-Methods: POST");
Api::Header("Content-Type: application/json");
Api::Header("X-Content-Type-Options: nosniff");
Api::Header("X-Frame-Options: DENY");


$uploadDir = API::storageUploadDir();
$maxFileSize = 100 * 1024 * 1024;
$allowedExtensions = [
    'jpg',
    'jpeg',
    'png',
    'gif',
    'webp',
    'svg',
    'pdf',
    'txt',
    'doc',
    'docx',
    'xls',
    'xlsx',
    'ppt',
    'pptx',
    'zip',
    'rar',
    'tar',
    'gz',
    'json',
    'xml'
];
$allowedTypes = [
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp',
    'image/svg+xml',
    'application/pdf',
    'text/plain',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.ms-powerpoint',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'application/zip',
    'application/x-rar-compressed',
    'application/x-tar',
    'application/gzip',
    'application/json',
    'application/xml',
    'text/xml'
];

if (Method::POST()) {
    try {
        if (empty($_FILES['file']) || empty($_POST['apikey'])) {
            throw new Exception('Missing required parameters');
        }

        $file = $_FILES['file'];
        $apiKey = $_POST['apikey'];

        if ($apiKey !== $baseApiKey) {
            throw new Exception('Invalid API key');
        }

        // File metadata
        $originalName = basename($file['name']);
        $fileNameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
        $fileSize = (int) $file['size'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $safeFilename = $fileNameWithoutExt . "_" . bin2hex(random_bytes(16)) . '.' . $extension;
        $targetPath = $uploadDir . $safeFilename;
        $publicUrl = "https://relay.ekilie.com/bucket/" . rawurlencode($safeFilename);

        // Validates upload
        API::validateUpload($file, $maxFileSize, $allowedTypes, $allowedExtensions, $mimeType, $extension);

        // Creates upload directory if not exists
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            throw new Exception("Failed to create upload directory");
        }

        // Moves uploaded file
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new Exception("File storage failed");
        }


        Api::Response([
            'status' => 'success',
            'url' => $publicUrl,
            'metadata' => [
                'original_name' => $originalName,
                'file_type' => $mimeType,
                'file_size' => $fileSize,
                'upload_time' => date('c')
            ]
        ]);

    } catch (Exception $e) {
        error_log("Upload Error: {$e->getMessage()} - IP: {$_SERVER['REMOTE_ADDR']}");
        http_response_code(400);
        Api::Response([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    Api::Response([
        'status' => 'error',
        'message' => 'Method not allowed'
    ]);
}