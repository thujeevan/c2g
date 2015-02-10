<?php

namespace c2g\Base;

/**
 * abstract Game base class
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
abstract class Game {
    
    private $name;
    protected $deck;
    protected $foundationPiles;    
    protected $piles;

    public abstract function dealCards();

    /**
     * Initialize the deck for this game, can be optionally passed
     * 
     * @param Deck $deck
     */
    public function __construct($name, $deck = NULL) {
        $this->name = $name;
        if (!$deck) {
            $deck = new Deck();
        }
        $this->deck = $deck;
    }

    /**
     * Main interactive function which accepts inputs from user
     * and perform move
     */
    public function run() {
        $head = "Welcome to {$this->name}";
        $boarder = join('+', array_fill(0, ceil(strlen($head) / 2), '-'));
        echo $head . PHP_EOL . $boarder . PHP_EOL;

        $this->dealCards(); // deal cards

        while (TRUE) {
            echo "Enter move as src# dst# (or quit/q to end game): ";
            $line = strtolower(trim(fgets(STDIN))); // getting string from standard input stream
            if (!strlen($line)) { // empty input - continue
                continue;
            }
            if ($line == 'quit' || $line == 'q') { // input is quit - break the loop
                break;
            }
            $inputs = split(' ', $line);
            if (count($inputs) != 2) { // if the count is wrong 
                echo "Malformed input, please try again " . PHP_EOL;
                continue;
            }
            $range = range(1, count($this->piles));
            if (!(in_array($inputs[0], $range) && in_array($inputs[1], $range))) { // inputs are out of bounce
                echo "Malformed input, please try again " . PHP_EOL;
                continue;
            }
            // if everything okay - move
            if(!$this->move($this->piles[$inputs[0] - 1], $this->piles[$inputs[1] - 1])){
                echo "Illegal move" . PHP_EOL;
            }
            $this->redrawBoard(); // redraw the board
            if ($this->win()) { // check for the win 
                echo "Congratulations - you won " . $this->name . PHP_EOL;
                break;
            }
        }
    }

    /**
     * function which responsible to redraw the board on every move
     * Prints the formatted string representation of the pile
     */
    protected function redrawBoard() {
        foreach ($this->piles as $key => $pile) {
            $at = $key + 1;
            echo sprintf("[%2s] ", $at) . $pile->printPile() . PHP_EOL;
        }
    }

    /**
     * Function which handles moving cards from pile to pile
     * If the move is invalid - managed by piles, this will print invalid move
     * 
     * @param Pile $src source pile
     * @param Pile $dest destination pile
     * @return null
     */
    protected function move(Pile $src, Pile $dest) {
        if ($src->canRemove($dest)) { // check if the source can move to destination
            if (!$dest->canAdd($src->top(), $src)) { // check if dest can add from this src                
                return FALSE;
            }
            $card = $src->removeCard(); // get the top card from the src pile
            if (!$card->isFacedUp()) {
                $card->flip(); // card isn't faced up, flip it
            }
            $dest->addCard($card); // add card to destination
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Private function to get the game state win
     * 
     * @return boolean true if foundationpile are filled up 
     */
    private function win() {
        return array_reduce($this->foundationPiles, function ($carry, $item) {
                    $carry += count($item);
                    return $carry;
                }, 0) == 52;
    }

}
