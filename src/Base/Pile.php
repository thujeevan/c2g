<?php

namespace c2g\Base;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use c2g\Base\Card;
use c2g\Base\Pile;

/**
 * Pile base class
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class Pile implements IteratorAggregate, ArrayAccess, Countable {

    use \c2g\Traits\IteratorAggregate;
    use \c2g\Traits\ArrayAccess;
    use \c2g\Traits\Countable;

    /**
     * @var integer limit of this pile
     */
    protected $limit;
    
    /**
     * @var boolean true if this/derived pile is circular
     */
    protected $circular;
    
    /**
     * @var boolean true if this/derived pile is fanned
     */
    protected $fanned;
    
    /**
     * @var array which holds the references to the cards dealt
     */
    protected $cards;
    
    /**
     * @var string name of this/derived pile
     */
    protected $name;

    /**
     * Pile constructor, which intializes the cards container to be empty
     * 
     * @param integer $limit the amount of cards which could hold by this pile
     * @param string $pileName Name of this/derived pile
     */
    public function __construct($limit, $pileName) {
        $this->limit = $limit;
        $this->name = $pileName;
        $this->cards = [];
    }

    /**
     * function to get the cards, mainly used to provide concrete implements to 
     * interface methods
     * 
     * @return array array of cards which belongs to this pile
     */
    protected function &getContainer() {
        return $this->cards;
    }

    /**     
     * Tells whether the top can be removed from this pile
     * Optionally pass the destination pile - some piles won't accept to remove 
     * the top card for specific destinations
     * Usually overridden by sub class
     * 
     * @param \c2g\Base\Pile $dest
     * @return boolean
     */
    public function canRemove(Pile $dest = NULL) {
        return (count($this->cards) > 0);
    }

    /**
     * Which tells whether this pile can accept more cards
     * Optionally pass the destination pile - some piles can't accept from 
     * specific sources 
     * Usually overridden by subclass for more comprehensive check
     * 
     * @param \c2g\Base\Card $card
     * @param \c2g\Base\Pile $src
     * @return boolean
     */
    public function canAdd(Card $card, Pile $src = NULL) {
        return (count($this->cards) >= 0) && (count($this->cards) < $this->limit);
    }

    /**
     * Add a card to this pile
     * 
     * @param \c2g\Base\Card $card
     * @return \c2g\Base\Pile
     */
    public function addCard(Card $card) {
        array_unshift($this->cards, $card);
        return $this;
    }

    /**
     * remove a card from this pile, which returns the top card of this pile
     * 
     * @return \c2g\Base\Card
     */
    public function removeCard() {
        return array_shift($this->cards);
    }

    /**
     * Returns the reference to the top card of this pile
     * 
     * @return \c2g\Base\Card 
     */
    public function top() {
        return $this->cards[0];
    }
    
    /**
     * function tells whether this pile is empty or not
     * 
     * @return boolean 
     */
    public function isEmpty() {
        return (count($this->cards) == 0);
    }
    
    /**
     * function tells whether this pile is empty or not
     * 
     * @return boolean 
     */
    public function isFull() {
        return (count($this->cards) == $this->limit);
    }

    /**
     * Function to get the string representation of this pile
     * 
     * @return string String representation of this pile
     */
    public function printPile() {
        $str = "";
        $str .= sprintf("%-10s: ", $this->name); // print the pile name
        
        // return if this is an empty pile
        if ($this->isEmpty()) {
            return $str .= 'Empty pile';
        }

        $str .= $this->printTopCard(); // get the top card
        // if this pile is fanned 
        if ($this->fanned) {
            foreach ($this->cards as $key => $card) {
                if ($key == 0) {
                    continue; // skip the top card
                }
                $str .= sprintf("%-4s ", $card); // print the cards
            }
        } else if ($this->top()->isFacedUp() && $this->limit > 1) {
            // print the count of the cards below the top card
            $str .= sprintf('( Remaining %d card%s below )', ($this->count() - 1), ($this->count() > 2 ? 's' : ''));
        } else if (!$this->top()->isFacedUp()) {
            $str .= sprintf("%-4s ", ' Faced down');
        }
        return $str;
    }

    /**
     * Get the string representation of topcard of this pile
     * Child class may change the default behavior
     * 
     * @return string string representation of top card 
     */
    protected function printTopCard() {
        return sprintf("%-4s ", $this->top());
    }

}
