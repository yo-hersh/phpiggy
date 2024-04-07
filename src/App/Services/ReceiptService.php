<?php

declare(strict_types=1);

namespace App\Services;

use App\Config\Paths;
use Framework\Database;
use Framework\Exceptions\ValidationException;

class ReceiptService
{
    public function __construct(
        private Database $db
    ) {
    }

    public function validateUpload(?array $file)
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            throw new ValidationException(
                [
                    'receipt' => ['Receipt is required']
                ]
            );
        }

        $allowedTypes = ['application/pdf', 'image/png', 'image/jpeg', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new ValidationException(
                [
                    'receipt' => ['Invalid file type']
                ]
            );
        }

        $maxFileSizeMB = 3;

        if ($file['size'] > $maxFileSizeMB * 1024 * 1024) {
            throw new ValidationException(
                [
                    'receipt' => ['File too large']
                ]
            );
        }

        $pattern = '/^[\p{L}\p{N}\s_.-]+$/u';
        if (!preg_match($pattern, $file['name'])) {
            throw new ValidationException(
                [
                    'receipt' => ['Invalid file name']
                ]
            );
        }

    }

    public function upload(array $file, string $transactionId)
    {
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(16)) . '.' . $fileExtension;
        $newLocation = Paths::STORAGE_UPLOADS . '/' . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $newLocation)) {
            throw new ValidationException(
                [
                    'receipt' => ['Failed to upload file']
                ]
            );
        }

        $this->db->query(
            'INSERT INTO receipts ( transaction_id, original_filename,storage_filename , media_type) VALUES (:transaction_id, :original_filename, :storage_filename, :media_type);',
            [
                'transaction_id' => $transactionId,
                'original_filename' => $file['name'],
                'storage_filename' => $newFileName,
                'media_type' => $file['type']
            ]
        );
    }
}


