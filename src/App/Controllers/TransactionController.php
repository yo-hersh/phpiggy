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

    public function editView(array $params)
    {
        $transaction = $this->transactionService->getOneByUser($params['transaction']);
        if ($transaction == null) {
            redirectTo('/');
        }
        echo $this->view->render("transactions/edit.php", [
            'transaction' => $transaction
        ]);
    }

    public function edit(array $params)
    {
        $this->validatorService->validateCreateTransaction($_POST);
        $this->transactionService->edit($params['transaction'], $_POST);
        redirectTo('/');
    }

}
