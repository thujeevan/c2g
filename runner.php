#!/usr/bin/php
<?php
/**
 * Game runner main script
 */
require_once __DIR__ . '/vendor/autoload.php';

function run() {

    // game classes as a hash table
    $games = [
        't' => "c2g\Towers\Towers",
        'f' => "c2g\FortyThieves\FortyThieves",
        's' => "c2g\Sixteens\Sixteens"
    ];

    echo "Welcome to Solitaire!" . PHP_EOL;
    echo "Today's menu of solitaire games includes:" . PHP_EOL;
    echo "\t 1. The Towers (t)" . PHP_EOL;
    echo "\t 2. Forty Thieves (f)" . PHP_EOL;
    echo "\t 3. Sixteens (s)" . PHP_EOL;
    echo "All to challenge you. Enjoy!" . PHP_EOL;

    // main runner loop begins
    while (TRUE) {
        echo "Which version of solitaire would you like to play? ";
        $choice = strtolower(trim(fgets(STDIN))); // getting string from standard input stream
        if (!array_key_exists($choice, $games)) {
            echo "Valid choices are t(tower), f(forty thieves), or s(sixteens)." . PHP_EOL;
            continue;
        } else if (executeGame(new $games[$choice]())) {
            continue;
        } else {
            echo "Good bye!". PHP_EOL;
            break;
        }
    }
}

// function to execute each game
function executeGame($game) {
    $game->run();
    echo "Play Again. (Y/N)? ";
    $option = strtolower(trim(fgets(STDIN)));
    switch ($option) {
        case 'yes':
        case 'y':
            return TRUE;
        default:
            return FALSE;
    }
}

// finally run the game runner
run();
