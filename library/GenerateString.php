<?php
class GenerateString
{
    public static function getString($length)
    {
        $string = '';

        while (strlen($string) < $length) {
            srand(self::_makeSeed());

            $ch_type = (rand() % 2);

            if ($ch_type == 0) {
                $character = self::_generateNumber();
            } else {
                $character = self::_generateChar();
            }

            $string .= $character;
        }
        
        return $string;
    }

    private static function _generateNumber()
    {
        mt_srand(self::_makeSeed());
        $character = mt_rand(0,9);

        return $character;
    }

    private static function _generateChar()
    {
        mt_srand(self::_makeSeed());

        $letter_type = mt_rand(0,9);
        $letter_type = $letter_type % 2;

        if ($letter_type == 1) { /* gen lower case char */
            mt_srand(self::_makeSeed());
            $character = mt_rand(97,122);
        } else {                 /* gen upper case char */
            mt_srand(self::_makeSeed());
            $character = mt_rand(65,90);
        }
        $character = chr($character);

        return $character;
    }

    private static function _makeSeed()
    {
        list($usec, $sec) = explode(' ', microtime());
        return (float) $sec + ((float) $usec * 100000);
    }
}
