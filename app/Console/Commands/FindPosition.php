<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CalculationService;

/**
 * Finds position of a given character from a given string recusrsively.
 *
 * @package StringOperation
 */
class FindPosition extends Command
{
    /**
     * Finds position of a given character from a given string recusrsively.
     *
     * @var string
     */
    protected $signature = 'FindPosition {expression} {character}';
   /**
     *
     * @var string
     */
    protected $description = "Finds position of a given character from a given string recusrsively.";

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Finds position of a given character from a given string recusrsively.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $string = $this->argument('expression');
        $character = $this->argument('character');
        $service = new CalculationService;
        $result = $service->findPosition($string, $character);
    }
}
