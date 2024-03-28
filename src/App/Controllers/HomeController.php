<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\TransactionService;
use Framework\TemplateEngine;
use App\Config\Paths;

class HomeController
{
    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService
    ) {
    }
    public function home()
    {
        $transactions = $this->transactionService->getTransactionsByUser();
        echo $this->view->render(
            'index.php',
            [
                'title' => 'Home',
                'transactions' => $transactions
            ]
        );
    }
}
