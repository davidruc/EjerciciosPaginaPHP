<?php

 /*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */
    
 declare(strict_types=1);
 class SimpleCipher
 {
     public const LOWER_BOUNDARY = 97; // lowercase a
     public const UPPER_BOUNDARY = 122; // lowercase z
     public function __construct(string $key = null)
     {
         if ($key === '' || preg_match('/[0-9A-Z]/', strval($key))) {
             throw new InvalidArgumentException();
         }
         $this->key = $key ?: $this->generateRandomKey();
     }
     public function generateRandomChar(): string
     {
         return chr(rand(self::LOWER_BOUNDARY, self::UPPER_BOUNDARY));
     }
     public function generateRandomKey(): string
     {
         return join(array_map('self::generateRandomChar', range(1, 100)));
     }
     public function encode(string $plainText): string
     {
         $results = [];
         foreach (str_split($plainText) as $i => $char) {
             $length = ord(str_split($this->key)[$i]) - self::LOWER_BOUNDARY;
             $shifto = ord($char) + $length;
             $results[] = $shifto > self::UPPER_BOUNDARY
                 ? chr($shifto - self::UPPER_BOUNDARY + self::LOWER_BOUNDARY - 1)
                 : chr($shifto);
         }
         return join($results);
     }
     public function decode(string $cipherText): string
     {
         $results = [];
         foreach (str_split($cipherText) as $i => $char) {
             $length = ord(str_split($this->key)[$i]) - self::LOWER_BOUNDARY;
             $shifto = ord($char) - $length;
             $results[] = $shifto < self::LOWER_BOUNDARY
                 ? chr($shifto + self::UPPER_BOUNDARY - self::LOWER_BOUNDARY + 1)
                 : chr($shifto);
         }
         return join($results);
     }
 }

?>