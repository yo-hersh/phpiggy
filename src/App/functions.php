<?php 

declare(strict_types=1);

// the following is used for debugging
// calling the following function in the console to debug
function dd(){
    foreach (func_get_args() as $arg) {
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
    die();
}

?>