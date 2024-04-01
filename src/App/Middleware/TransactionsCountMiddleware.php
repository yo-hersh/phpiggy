<?php

namespace App\Middleware;

use App\Services\TransactionService;
use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class TransactionsCountMiddleware implements MiddlewareInterface
{
    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService
    ) {
    }

    public function process(callable $next)
    {
        if (!isset($_SESSION['transactionsCount'])) {
            $_SESSION['transactionsCount'] = $this->transactionService->getCountByUser($_GET['s'] ?? '');
        }
        $next();
    }
}