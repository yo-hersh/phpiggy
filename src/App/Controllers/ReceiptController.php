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
        $receipt = $_FILES['receipt'] ?? null;
        $this->receiptService->validateUpload($receipt);
        $this->receiptService->upload($receipt, $params['transaction']);

        redirectTo("/");
    }

    public function download(array $params)
    {
        $transaction = $this->transactionService->getOneByUser($params['transaction']);
        if (empty($transaction)) {
            redirectTo("/");
        }

        $receipt = $this->receiptService->getOneByUser($params['receipt']);
        if (empty($receipt)) {
            redirectTo("/");
        }

        if ($receipt['transaction_id'] != $transaction['id']) {
            redirectTo("/");
        }

        $this->receiptService->download($receipt);

    }

    public function delete(array $params)
    {
        $transaction = $this->transactionService->getOneByUser($params['transaction']);
        if (empty($transaction)) {
            redirectTo("/");
        }

        $receipt = $this->receiptService->getOneByUser($params['receipt']);
        if (empty($receipt)) {
            redirectTo("/");
        }

        if ($receipt['transaction_id'] != $transaction['id']) {
            redirectTo("/");
        }

        $this->receiptService->delete($receipt);
    }
}