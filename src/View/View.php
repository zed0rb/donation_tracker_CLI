<?php
declare(strict_types=1);

namespace App\View;

class View
{
    public function prompt(string $message): string
    {
        echo $message;
        return trim(fgets(STDIN));
    }

    public function displaySuccessMessage(string $message): void
    {
        echo "\033[32m$message\033[0m" . PHP_EOL; // Green text for success
    }

    public function displayItems(array $items, callable $formatCallback): void
    {
        if (empty($items)) {
            $this->displayErrorMessage("No items found.");
            return;
        }

        foreach ($items as $item) {
            $this->displayMessage($formatCallback($item));
        }
    }

    public function displayErrorMessage(string $message): void
    {
        echo "\033[31m$message\033[0m" . PHP_EOL; // Red text for error
    }

    public function displayMessage(string $message): void
    {
        echo $message . PHP_EOL;
    }
}
