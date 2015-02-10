<?php

use c2g\Base\Card;

namespace c2g\Base;

/**
 * Card base class
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class Card {

    /**
     * @var array The suit for the card
     */
    private $suit;

    /**
     * @var array The rank of the card.
     */
    private $rank;

    /**
     * @var boolean Tells whether this card is facing up or not
     */
    private $facedUp;

    /**
     * Creates a new card of suit $suit with number $rank.
     * @param array $suit where array in the format ['suit' => K, 'class' => 1 ]
     * @param array $rank where array in the format ['index' => 1, 'term' => A ]
     * @param boolean $facedUp defaults to false
     */
    public function __construct(array $suit, array $rank, $facedUp = FALSE) {
        $this->suit = $suit;
        $this->rank = $rank;
        $this->facedUp = $facedUp;
    }

    /**
     * @return string The suit for the card;
     */
    public function getSuit() {
        return $this->suit;
    }

    /**
     * @return string The number for the card;
     */
    public function getRank() {
        return $this->rank;
    }

    /**
     * Helper to flip the card upside down
     * 
     * @return Card return this card instance
     */
    public function flip() {
        $this->facedUp = !$this->facedUp;
        return $this;
    }

    /**
     * @return boolean TRUE if this card is faced up
     */
    public function isFacedUp() {
        return $this->facedUp;
    }

    /**
     * comparison helper
     * @param Card $card
     * @return boolean true when both in the same suit
     */
    public function isSameSuit(Card $card) {
        return $this->suit['suit'] == $card->getSuit()['suit'];
    }

    /**
     * comparison helper
     * @param Card $card
     * @return boolean true when both aren't in the same class
     */
    public function isAlternate(Card $card) {
        return ($this->suit['class'] != $card->getSuit()['class']);
    }

    /**
     * comparison helper
     * @param Card $card
     * @return boolean true when this card is greater in rank than the given 
     */
    public function isGreaterThan(Card $card) {
        return $this->rank['index'] > $card->getRank()['index'];
    }
    
    /**
     * comparison helper
     * @param Card $card
     * @return boolean true when this card is greater by one in rank than the given 
     */
    public function isGreaterThanByOne(Card $card) {
        return $this->rank['index'] == ($card->getRank()['index'] + 1);
    }
    
    /**
     * comparison helper
     * @param Card $card
     * @return boolean true when card is equal in rank as the given
     */
    public function isEqual(Card $card) {
        return $this->rank['index'] == $card->getRank()['index'];
    }
    
    /**
     * comparison helper
     * @param Card $card
     * @return boolean true when card is less in rank than the given
     */
    public function isLessThan(Card $card) {
        return $this->rank['index'] < $card->getRank()['index'];
    }
    
    /**
     * comparison helper
     * @param Card $card
     * @return boolean true when card is less by one in rank than the given
     */
    public function isLessThanByOne(Card $card) {
        return ($this->rank['index'] + 1) == $card->getRank()['index'];
    }
    
    /**
     * helper which tells whether this card is the first one
     * - which means is A
     * @return boolean
     */
    public function isFirstInRank() {
        return ($this->rank['index'] == 1);
    }

    /**
     * helper which tells whether this card is the last one
     * - which means is K
     * @return boolean
     */
    public function isLastInRank() {
        return ($this->rank['index'] == 13);
    }

    /**
     * Returns a string in such a format RS, R - rank, S - suit : eg. 4H
     * only if this card is faced up,
     * otherwise would return "faced down"
     *
     * @return string string representation of this card.
     */
    public function __toString() {
        if ($this->facedUp) {
            return "{$this->rank['term']}{$this->suit['suit']}";
        } else {
            return "faced down";
        }
    }

}
