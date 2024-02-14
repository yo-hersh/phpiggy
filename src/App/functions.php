<?php

declare(strict_types=1);

// the following is used for debugging
// calling the following function in the console to debug
function dd()
{
    foreach (func_get_args() as $arg) {
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
    die();
}

function escapeString(mixed $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirectTo(string $path)
{
    header("Location: {$path}");
    http_response_code(302);
    exit;
}

/**
 * Print error messages for the given value if it exists in the errors array
 *
 * @param string $value The value to check for errors
 * @param array $errors The array of errors
 * @return void
 */
function formErrorPrinting(string $value, array $errors)
{
    // Check if the value exists in the errors array
    if (array_key_exists($value, $errors)) {
        // Print the error messages in a styled div
        echo '<div class="bg-grey-100 mt-2 p-2 text-red-500">';
        foreach ($errors[$value] as $error) {
            echo e($error) . '. ';
        }
        echo '</div>';
    }
}
