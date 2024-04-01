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
        [$searchTerm, $page, $length, $offset] = $this->getPageInfo();
        [$transactions, $count] = $this->getTransactionsAndCount($searchTerm, $length, $offset);

        $lastPage = $this->calculateLastPage($count, $length);

        echo $this->view->render(
            'index.php',
            [
                'title' => 'Home',
                'searchTerm' => $searchTerm,
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

    private function getPageInfo()
    {
        $searchTerm = addcslashes($_GET['s'] ?? '', '%_');
        $page = $_GET['p'] ?? 1;
        $page = (int) $page;
        $length = TRANSACTIONS_PER_PAGE;
        $offset = ($page - 1) * $length;

        return [$searchTerm, $page, $length, $offset];
    }

    private function calculateLastPage(int $count, int $length)
    {
        return ceil($count / $length);
    }


    private function getTransactionsAndCount(string $searchTerm, int $length, int $offset)
    {
        return $this->transactionService->getTransactionsAndCountByUser($searchTerm, $length, $offset);
    }

}
