<?php

namespace c2g\Sixteens;

use c2g\Base\Card;
use c2g\Base\FoundationPile;
use c2g\Base\Pile;

/**
 * Tableau pile class for sixteens game
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class TableauPile extends Pile {
    
    const LIMIT = 3;
    const NAME = 'Tableau';

    /**
     * constructor function initializes the state with defaults
     * 
     * @param integer $limit
     * @param string $name
     */
    public function __construct($limit = self::LIMIT, $name = self::NAME) {
        parent::__construct($limit, $name);
        $this->fanned = TRUE;
        $this->circular = TRUE;
    }

    /**
     * Specialized version of Pile's canAdd function
     * 
     * @param \c2g\Base\Card $card card to be added
     * @param \c2g\Base\Pile $src Source pile of the card
     * @return boolean
     */
    public function canAdd(Card $card, Pile $src) {
        if ($src && $src instanceof FoundationPile) { // can't accept from foundation pile
            return FALSE;
        }
        // can't accept if it became empty or pile already full
        if ($this->isEmpty() || $this->isFull()) {
            return FALSE;
        }
        // circular build breaks 
        if ($this->top()->isFirstInRank() && $card->isLastInRank() && !$card->isAlternate($this->top())) {
            return FALSE;
        }
        // breaks alternate, and ranking
        if (!$this->top()->isFirstInRank() && !($card->isAlternate($this->top()) && $card->isLessThanByOne($this->top()))) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * cards are fanned and visible, need to check and flip when adding
     * 
     * @param \c2g\Base\Card $card
     * @return Pile 
     */
    public function addCard(Card $card) {
        return parent::addCard(!$card->isFacedUp() ? $card->flip() : $card);
    }

    /**
     * Function to add cards to this pile on initial deal
     * 
     * @param \c2g\Base\Card $card
     * @return boolean | integer - false on limit reached, 
     *                             number of cards on this pile on success
     */
    public function deal(Card $card) {
        if ($this->count() == $this->limit) {
            return FALSE;
        }
        array_unshift($this->cards, $card);
    }

}
