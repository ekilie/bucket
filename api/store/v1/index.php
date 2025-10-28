<?php
include_once __DIR__ . '/../../../config.php';
include_once __DIR__ . '/../../api.php';
require __DIR__ . '/../../../parseEnv.php';
parseEnv(__DIR__ . '/../../../.env');

$baseApiKey = getenv('BASE_API_KEY');

Api::Header("Access-Control-Allow-Origin: *");
Api::Header("Access-Control-Allow-Methods: POST");
Api::Header("Content-Type: application/json");
Api::Header("X-Content-Type-Options: nosniff");
Api::Header("X-Frame-Options: DENY");

$uploadDir = API::storageUploadDir();
$maxFileSize = 100 * 1024 * 1024; // 100 MB

$allowedExtensions = [
    // Images
    'jpg',
    'jpeg',
    'png',
    'gif',
    'webp',
    'svg',
    // Documents
    'pdf',
    'txt',
    'doc',
    'docx',
    'xls',
    'xlsx',
    'ppt',
    'pptx',
    // Archives
    'zip',
    'rar',
    'tar',
    'gz',
    // Data
    'json',
    'xml',
    // Audio
    'mp3',
    'wav',
    'm4a',
    'aac',
    'ogg',
    'oga',
    'flac',
    'opus',
    'webm',
    // Video
    'mp4',
    'mov',
    'avi',
    'mkv',
    'webm'
];

$allowedTypes = [
    // Images
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp',
    'image/svg+xml',
    // Documents
    'application/pdf',
    'text/plain',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.ms-powerpoint',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    // Archives
    'application/zip',
    'application/x-rar-compressed',
    'application/x-tar',
    'application/gzip',
    // Data
    'application/json',
    'application/xml',
    'text/xml',
    // Audio
    'audio/mpeg',        // .mp3
    'audio/x-wav',       // .wav
    'audio/wav',
    'audio/aac',         // .aac
    'audio/mp4',         // .m4a
    'audio/x-m4a',
    'audio/ogg',         // .ogg
    'audio/oga',
    'audio/flac',        // .flac
    'audio/webm',        // .webm
    'audio/opus',        // .opus
    // Video
    'video/mp4',         // .mp4
    'video/quicktime',   // .mov
    'video/x-msvideo',   // .avi
    'video/x-matroska',  // .mkv
    'video/webm'         // .webm
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

        // Metadata
        $originalName = basename($file['name']);
        $fileNameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
        $fileSize = (int) $file['size'];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        $safeFilename = $fileNameWithoutExt . "_" . bin2hex(random_bytes(16)) . '.' . $extension;
        $targetPath = $uploadDir . $safeFilename;
        $publicUrl = "https://bucket.ekilie.com/bucket/" . rawurlencode($safeFilename);

        // Validate
        API::validateUpload($file, $maxFileSize, $allowedTypes, $allowedExtensions, $mimeType, $extension);

        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            throw new Exception("Failed to create upload directory");
        }

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