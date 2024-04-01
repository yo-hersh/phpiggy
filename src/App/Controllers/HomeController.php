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
        $searchTerm = addcslashes($_GET['s'] ?? '', '%_');
        $page = $_GET['p'] ?? 1;
        $page = (int) $page;
        $length = TRANSACTIONS_PER_PAGE;
        $offset = ($page - 1) * $length;

        [$transactions, $count] = $this->transactionService->getTransactionsAndCountByUser(
            $searchTerm,
            $length,
            $offset
        );
        // dd($transactions, $count);
        $lastPage = ceil($count / $length);

        echo $this->view->render(
            'index.php',
            [
                'title' => 'Home',
                'transactions' => $transactions,
                'currentPage' => $page,
                'previousPageQuery' => http_build_query(
                    [
                        's' => $searchTerm,
                        'p' => $page - 1
                    ]
                ),
                'nextPageQuery' => http_build_query(
                    [
                        's' => $searchTerm,
                        'p' => $page + 1
                    ]
                ),
                'lastPage' => $lastPage
            ],
        );
    }
}
