<?php

namespace c2g\Base;

/**
 *  FoundationPile base class
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class FoundationPile extends Pile {

    const LIMIT = 13;
    const NAME = 'Foundation';
    
    /**
     * data member of this class, which holds the base card 
     * when this pile is circular
     * @var Card 
     */
    static $baseCard;

    /**
     * Constructor function which initializes foundation pile with
     * pile name and the cards limit
     * Foundation piles are not fanned usually
     * 
     * @param boolean $circular true if this is circular pile
     */
    public function __construct($circular) {
        parent::__construct(self::LIMIT, self::NAME);
        $this->circular = $circular;
        $this->fanned = FALSE;
    }

    /**
     * Specialied version of Pile's can add function, control the restrictions 
     * of adding cards to this pile
     * 
     * @param \c2g\Base\Card $card card to be added to this pile
     * @param \c2g\Base\Pile $src the pile from which the card comes
     * @return boolean
     */
    public function canAdd(Card $card, Pile $src = NULL) {
        if ($this->count() == $this->limit) { // pile is full
            return FALSE;
        }
        if (!$this->isEmpty() && !$card->isSameSuit($this->top())) { // doesn't belong to same suit
            return FALSE;
        }
        // pile is not circular
        // pile count is zero
        // card is not A
        if (!$this->circular && $this->isEmpty() && !$card->isFirstInRank()) {
            return FALSE;
        }
        // circular pile
        // has at least one card - implies, should have baseCard
        // topcard is K and card to be inserted is A
        if ($this->circular && !$this->isEmpty() && 
                $this->top()->isLastInRank() && 
                $card->isFirstInRank()) {
            return TRUE;
        }
        // can be circular or non circular
        if (!$this->isEmpty() && !$card->isGreaterThanByOne($this->top())) {
            return FALSE;
        }
        // circular pile
        // empty pile
        // basecard exists
        // card to be added not as equal as basecard in rank
        if ($this->circular && $this->isEmpty() && 
                static::$baseCard && !$card->isEqual(static::$baseCard)) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Foundation pile usually doesn't allow to remove cards
     * 
     * @param \c2g\Base\Pile $dest Pile to which the card to be added
     * @return boolean
     */
    public function canRemove(Pile $dest = NULL) {
        return FALSE;
    }
    
    /**
     * overridden function of Pile's add card
     * Since foundation piles can be circular sometimes
     * 
     * @param \c2g\Base\Card $card
     * @return Pile 
     */
    public function addCard(Card $card) {
        if ($this->circular && $this->isEmpty()) {
            static::$baseCard = $card;
        }
        return parent::addCard(!$card->isFacedUp() ? $card->flip() : $card);
    }

}
