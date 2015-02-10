<?php

namespace c2g\FortyThieves;

use c2g\Base\Card;
use c2g\Base\FoundationPile;
use c2g\Base\Pile;
use c2g\Base\StockPile;

/**
 * TableauPiles for game Forty thieves
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class TableauPile extends Pile {
    
    const LIMIT = 14;
    const NAME = 'Tableau';
    
    /**
     * Initializes tableau pile for forty theives with default values
     * 
     * @param integer $limit
     * @param string $pileName
     */
    public function __construct($limit = self::LIMIT, $pileName = self::NAME) {
        parent::__construct($limit, $pileName);
        $this->circular = FALSE;
        $this->fanned = TRUE;
    }
    
    /**
     * Specialized version of super class's function
     * which tels whether a card can be added to this pile from a specific pile
     * 
     * @param \c2g\Base\Card $card
     * @param \c2g\Base\Pile $src
     * @return boolean
     */
    public function canAdd(Card $card, Pile $src = NULL) {
        // source can neither be foundation nor stock
        if($src instanceof FoundationPile || $src instanceof StockPile){
            return FALSE;
        }
        // if this pile has at least one card 
        // and breaks suit and rank
        if(!$this->isEmpty() && 
                !($card->isSameSuit($this->top()) 
                && $card->isLessThanByOne($this->top()))){
            return FALSE;
        }
        return parent::canAdd($card, $src);
    }
    
    /**
     * Adding a card to this pile
     * 
     * @param \c2g\Base\Card $card
     * @return Pile this pile
     */
    public function addCard(Card $card) {
        return parent::addCard(!$card->isFacedUp() ? $card->flip() : $card);
    }
    
    /**
     * Function used to distribute the cards on initial deal
     * 
     * @param \c2g\Base\Card $card
     */
    public function deal(Card $card) {
        array_unshift($this->cards, $card);
    }
}
