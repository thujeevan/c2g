<?php

namespace c2g\Towers;

use c2g\Base\Card;
use c2g\Base\Pile;

/**
 * TowerPile
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class TowerPile extends Pile {
    
    const LIMIT = 1;
    const NAME = 'Tower';

    /**
     * constructor function
     * Tower piles can only hold one item 
     */
    public function __construct() {
        parent::__construct(self::LIMIT, self::NAME);
    }

    /**
     * Tower piles only accept card from Tableau piles
     * 
     * @param \c2g\Base\Card $card
     * @param \c2g\Base\Pile $src
     * @return boolean
     */
    public function canAdd(Card $card, Pile $src = NULL) {
        if ($src && !($src instanceof TableauPile)) {
            return FALSE;
        }
        return parent::canAdd($card, $src);
    }

}
