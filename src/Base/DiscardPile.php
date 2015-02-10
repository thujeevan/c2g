<?php

namespace c2g\Base;

/**
 * DiscardPile class
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class DiscardPile extends Pile {
    
    const LIMIT = 32;
    const NAME = 'Discard';

    /**
     * class instantiation with default values
     * initialized with the limit of 32, since stock
     * piles have max of 32 cards
     */
    public function __construct() {
        parent::__construct(self::LIMIT, self::NAME);
        $this->fanned = FALSE;
    }

    /**
     * this kind of piles usually accept the cards only from stockpiles
     * 
     * @param Card $card
     * @param Pile $src
     * @return boolean
     */
    public function canAdd(Card $card, Pile $src) {
        if (!($src && $src instanceof StockPile)) {
            return FALSE;
        }
        return parent::canAdd($card);
    }
    
    /**
     * tells whether the top card can be moved to given destination pile
     * 
     * @param Pile $dest destination pile 
     * @return boolean
     */
    public function canRemove(Pile $dest = NULL) {
        if (($dest && $dest instanceof StockPile)) {
            return FALSE;
        }
        return parent::canRemove($dest);
    }
}
