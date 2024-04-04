<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\TransactionService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;

class TransactionController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService,
        private TransactionService $transactionService
    ) {
    }

    public function createView()
    {
        echo $this->view->render("transactions/create.php");
    }

    public function create()
    {
        $this->validatorService->validateCreateTransaction($_POST);
        $this->transactionService->create($_POST);
        redirectTo('/');
    }

    public function editView(array $transaction)
    {
        dd($transaction);
    }
}
