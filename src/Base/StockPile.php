<?php

namespace c2g\Base;

/**
 * StockPile class
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class StockPile extends Pile {

    const NAME = 'Stock';

    /**
     * constructor function of stock pile
     * Usually providing circular state doesn't make sense, since cards 
     * cannot be added to this kind of piles
     * 
     * @param integer $limit
     */
    public function __construct($limit) {
        parent::__construct($limit, self::NAME);
        $this->circular = FALSE;
        $this->fanned = FALSE;
    }

    /**
     * Stock piles don't accept cards from any pile
     * 
     * @param \c2g\Base\Card $card
     * @param \c2g\Base\Pile $src
     * @return boolean
     */
    function canAdd(Card $card, Pile $src) {
        return FALSE;
    }

    /**
     * stock piles can only move cards to discard piles
     * 
     * @param \c2g\Base\Pile $dest
     * @return boolean
     */
    function canRemove(Pile $dest = NULL) {
        if (!($dest && ($dest instanceof DiscardPile))) {
            return FALSE;
        }
        return parent::canRemove();
    }

    /**
     * function which retruns the string version of topcard
     * Stock piles are always faced down and not fanned
     * 
     * @return string representation of this pile's top card
     */
    protected function printTopCard() {
        if ($this->top()->isFacedUp()) {
            $this->top()->flip();
        }
        return sprintf("%-4s card%s ", $this->count(), ($this->count() > 1 ? 's' : ''));
    }
}
