<?php

namespace c2g\Sixteens;

use c2g\Base\Card;
use c2g\Base\FoundationPile;
use c2g\Base\Pile;

/**
 * SpecialTableauPile class for sixteens game which extends from TableauPile
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class SpecialTableauPile extends TableauPile {

    const LIMIT = 3;
    const NAME = 'Sp.Tableau';
    
    /**
     * Constructor of special pile with it's own name
     * 
     * @param integer $limit
     * @param string $name
     */
    public function __construct() {
        parent::__construct(self::LIMIT, self::NAME);
    }

    /**
     * Overridden function which provides custom restrictions on this pile
     * for adding cards 
     * 
     * @param \c2g\Base\Card $card
     * @param \c2g\Base\Pile $src
     * @return boolean
     */
    public function canAdd(Card $card, Pile $src) {
        if ($src && $src instanceof FoundationPile) { // can't accept from foundation pile
            return FALSE;
        }
        // can't accept if pile already full
        if ($this->isFull()) {
            return FALSE;
        }
        // circular build breaks 
        if (!$this->isEmpty() && // not empty
                $this->top()->isFirstInRank() && // top card is A
                $card->isLastInRank() && // card is K
                !$card->isAlternate($this->top())) { // but card is not alternate in color
            return FALSE;
        }
        // breaks alternate, and ranking
        if (!$this->isEmpty() && // not empty
                !$this->top()->isFirstInRank() && // top card is not A
                !($card->isAlternate($this->top()) // card is not alternate in color
                        && $card->isLessThanByOne($this->top()))) { // or card is not less than by one rank
            return FALSE;
        }
        return TRUE;
    }

}
