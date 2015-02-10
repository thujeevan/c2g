<?php

namespace c2g\FortyThieves;

use c2g\Base\DiscardPile;
use c2g\Base\FoundationPile;
use c2g\Base\Game;
use c2g\Base\StockPile;

/**
 * FortyThieves game main class
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class FortyThieves extends Game {
    
    const NAME = 'Forty Thieves';

    /**
     * @var array of Tableau piles
     */
    protected $tableauPiles;
    
    /**
     * @var Stockpile instance
     */
    protected $stockPile;
    
    /**
     * @var DiscardPile instance
     */
    protected $discardPile;

    /**
     * constructor function which initializes default state
     */
    public function __construct() {
        parent::__construct(self::NAME);
        $this->initPiles();
    }

    /**
     * function which deal cards to tableau piles, stock pile
     */
    public function dealCards() {
        $shuffled = $this->deck->shuffle();
        // only tow cycle of deal for this game
        for ($deals = 0; $deals < 2; $deals++) {
            foreach ($this->tableauPiles as $pile) {
                $pile->deal($shuffled->getNextCard());
            }
        }
        // put remaining cards to stockPile
        while($card = $shuffled->getNextCard()){
            $this->stockPile->addCard($card);
        }
        // redraw board once done
        $this->redrawBoard();
    }

    /**
     * function which init default piles for this game
     */
    private function initPiles() {
        // four foundation piles
        for ($count = 0; $count < 4; $count++) {
            $this->foundationPiles[] = new FoundationPile(FALSE);
        }
        // ten tableau piles 
        for ($count = 0; $count < 10; $count++) {
            $this->tableauPiles[] = new TableauPile();
        }
        $this->stockPile = new StockPile(32);
        $this->discardPile = new DiscardPile();
        // merged set of whole bunch of piles
        $this->piles = array_merge($this->foundationPiles, $this->tableauPiles);
        $this->piles[] = $this->stockPile;
        $this->piles[] = $this->discardPile;
    }

}
