<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class ReceiptService
{
    public function __construct(
        private Database $db
    ) {
    }

    public function validateUpload(?array $file, string $transactionId)
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

        if (!isset($file['tmp_name'])) {
            throw new ValidationException(
                [
                    'receipt' => ['Invalid file']
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

        dd($file);
    }
}