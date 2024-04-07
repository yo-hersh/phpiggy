<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ReceiptService, TransactionService};

class ReceiptController
{
    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService,
        private ReceiptService $receiptService
    ) {
    }

    public function uploadView(array $params)
    {
        $transaction = $this->transactionService->getOneByUser($params['transaction']);

        if ($transaction == null) {
            redirectTo("/");
        }
        echo $this->view->render("transactions/receipts/create.php");
    }

    public function upload(array $params)
    {
        $transaction = $this->transactionService->getOneByUser($params['transaction']);
        if ($transaction == null) {
            redirectTo("/");
        }
        $this->receiptService->validateUpload($_FILES['receipt'], $params['transaction']);


        redirectTo("/");
    }
}