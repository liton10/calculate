# calculate
A simple command based program to calculate string operations.

How it works:

Copy .env.example file to .env

Generate a key file and put it to .env (php artisan key:generate)

The program got 3 artisan commands.
```
1. php artisan FindPosition {expression} {character}
Example: php artisan FindPosition "bcdefgabcdefg" "a"
2. php artisan CalculateChar {expression}
Example: php artisan CalculateChar "a_++ef"
If you want to include '"' characters just escape them like  php artisan CalculateChar "a_+\"+\"ef"
3. php artisan calculate {expression}
Example: php artisan calculate "1 + 3 -2"
```
