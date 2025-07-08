<?php

namespace App\UI\CLI;

use App\Application\Command\CommandRegistry;
use Throwable;

class Kernel
{
    public function handle(array $argv): int
    {
        if (count($argv) < 1) {
            echo "Использование: php converter <command> [args...]\n";
            return 1;
        }

        $commandName = array_shift($argv);

        try {
            $command = CommandRegistry::getCommand($commandName);
            $config  = CommandRegistry::createConfig($commandName, $argv);
            $result  = $command->execute($config);

            if ($result !== null) {
                echo $result;
            }

            return 0;
        } catch (Throwable $e) {
            echo "Ошибка: " . $e->getMessage() . "\n";

            return 1;
        }
    }
} 