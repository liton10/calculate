<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CalculationService;

/**
 * Calculates a individual number of characters in an expression
 *
 * @package StringOperation
 */
class CalculateChar extends Command
{
    /**
     * Calculates a individual number of characters in an expression
     *
     * @var string
     */
    protected $signature = 'CalculateChar {expression}';
   /**
     *
     * @var string
     */
    protected $description = "Calculates a individual number of characters in an expression";

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Calculates a individual number of characters in an expression
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $string = $this->argument('expression');
        $service = new CalculationService;
        $result = $service->calculateCharacters($string);
    }
}
