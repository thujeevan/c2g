<?php

namespace c2g\Towers;

use c2g\Base\Card;
use c2g\Base\FoundationPile;
use c2g\Base\Pile;
use c2g\FortyThieves\TableauPile as FortyThievesTableauPile;

/**
 * TableauPile for Towers, which extends from fortythieves tableau pile class
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class TableauPile extends FortyThievesTableauPile {

    const LIMIT = 17;
    const NAME = 'Tableau';

    /**
     * construct with specific limit
     */
    public function __construct() {
        parent::__construct(self::LIMIT, self::NAME);
    }

    /**
     * function which controls the addition of cards for this pile
     * 
     * @param \c2g\Base\Card $card
     * @param \c2g\Base\Pile $src
     * @return boolean
     */
    public function canAdd(Card $card, Pile $src = NULL) {
        // source is foundation pile
        if ($src && $src instanceof FoundationPile) {
            return FALSE;
        }
        // pile is empty and card is not K
        if ($this->isEmpty() && !$card->isLastInRank()) {
            return FALSE;
        }
        // pile is not empty
        // and breaks rank order
        if (!$this->isEmpty() && !($card->isSameSuit($this->top()) && $card->isLessThanByOne($this->top()))) {
            return FALSE;
        }
        return parent::canAdd($card, $src);
    }

}
