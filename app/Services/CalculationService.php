<?php
namespace App\Services;

/**
 * Service class for calculating strings.
 *
 * @package StringOperation
 */
class CalculationService
{
    /**
     * Calculates a mathematical expression
     *
     * @param string $string
     * @return string
     * @throws \Exception
     */
    public function calculateExpression($string) 
    {
        $elements = [];
        $errroPrefix = 'Error: ';
        $defaultError = 'Syntax Error';
        try {
            $string = str_replace(' ', '', $string);
            // We will filterout and process any sign conversions.
            $array_from = array ('++','--','+-','-+','x+','/+'); 
            $array_to = array ('+','+','-','-','x','/');
            $string = str_replace ($array_from, $array_to, $string);
            $string = str_replace(' ', '', $string);
            // Now take every number and operand in an array.
            $operands = ['x','/','%','-','+'];
            $number = '';
            // if the opration starts with -, we preserve this as a negetive number.
            if ($string[0] == '-') {
                $number = '-';
                $string = ltrim($string, '-');
            }
            for( $i = 0; $i < strlen($string); $i++ ) {
                if (in_array($string[$i], $operands)) {
                    // Any number caught yet? push it first.
                    if (strlen($number)) {
                        $elements[] =  $number;
                        // Re initiate number.
                        $number = '';  
                    }

                    // Take the operand.
                    $elements[] =  $string[$i];

                    // Check whether the next element is a - sign, in that case consider this is a negetive number.

                    if ($string[$i+1] == '-') {
                        $number = '-';
                        // Skip processing the element.
                        $i++;  
                    }

                } else {
                    $number = $number.$string[$i];
                }
            }
            // Finaly, put any leftover final number. If there is no leftout number, its an error.
            if (strlen($number)) {
                $elements[] =  $number;   
            } else {
                throw new \Exception($errroPrefix.$defaultError);
            }

            // Now for each operands do the operations.
            foreach ($operands as $operand) {
                for ($i = 0; $i < count($elements); $i++) {
                    if ($elements[$i] === $operand) {
                        switch ($operand) {
                            case 'x':
                                $result = ($elements[$i-1] * $elements[$i+1]);
                                break;
                            case '/':
                                $result = ($elements[$i-1] / $elements[$i+1]);
                                break;
                            case '%':
                                $result = ($elements[$i-1] % $elements[$i+1]);
                                break;
                            case '-':
                                $result = ($elements[$i-1] - $elements[$i+1]);
                                break;
                            case '+':
                                $result = ($elements[$i-1] + $elements[$i+1]);
                                break;
                            default:
                                $result = ($elements[$i-1] + $elements[$i+1]);
                                break;
                        }
                        unset($elements[$i-1]);
                        unset($elements[$i+1]);
                        $elements[$i] = $result;
                        $elements = array_values($elements);
                        $i--;
                    }
                }
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            if (strpos($errorMessage, 'by zero') !== false) {
                $errorMessage = $errroPrefix.$errorMessage;
            } else {
                $errorMessage = $errroPrefix.$defaultError;
            }
            return $errorMessage; 
        }

        // check is the result is numberic. Else, we consider it syntax error.
        if (is_numeric($elements[0])) { 
            return round($elements[0]); 
        } 
        return $errroPrefix.$defaultError;
    }


    /**
     * Calculates a individual number of characters in an expression
     *
     * @param string $string
     * @return void
     * @throws \Exception
     */
    public function calculateCharacters($input) 
    {
        $result = [];
        try {
            for($i = 0; $i < strlen($input); $i++) {
              $chr = $input[$i];
              $result[$chr] = isset($result[$chr]) ? $result[$chr] + 1 : 1;
            }

            $total = 0;
            echo '========='.PHP_EOL;
            echo '==Report=='.PHP_EOL;
            foreach ($result as $chars => $value) {
                $total = ($total + $value);
                echo $chars.': '.$value.PHP_EOL;
            }
            echo "Total Characters: ".$total.PHP_EOL;
        } catch (\Exception $e) {
            echo "Error processing request.".PHP_EOL; 
        }
    }

    /**
     * Finds first occurance of a character in an string.
     *
     * @param string $string
     * @param string $character
     * @return void
     * @throws \Exception
     */
    public function findPosition($string, $character) 
    {
        echo 'Position: '.$this->findIndex($string, $character).PHP_EOL;
    }


    /**
     * Finds first occurance of a character in an string.
     *
     * @param string $string
     * @param string $character
     * @param string $character
     * @return integer
     * @throws \Exception
     */
    private function findIndex($string, $character, $i=0) {
        if ($i >= strlen($string)) {
          return 'N/A';
        } else if ($string[$i] === $character) {
            return ($i+1);
        } 
        return $this->findIndex($string, $character, ($i+1));
    }
}       