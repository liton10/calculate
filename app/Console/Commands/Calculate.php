<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CalculationService;

/**
 * Calculates a mathematical expression
 *
 * @package StringOperation
 */
class Calculate extends Command
{
    /**
     * Calculates a mathematical expression
     *
     * @var string
     */
    protected $signature = 'calculate {expression}';
   /**
     *
     * @var string
     */
    protected $description = "Calculates a mathematical expression";

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Calculates a mathematical expression
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $string = $this->argument('expression');
        $service = new CalculationService;
        $result = $service->calculateExpression($string);
        echo $result.PHP_EOL; 
    }
}
