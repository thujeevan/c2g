<?php

namespace c2g\Towers;

use c2g\Base\FoundationPile;
use c2g\Base\Game;

/**
 * Towers game main class
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class Towers extends Game {
    
    const NAME = 'Towers';

    /**
     * @var array of tableau piles
     */
    protected $tableauPiles;
    
    /**
     * @var array of tower piles
     */
    protected $towerPiles;

    /**
     * construct this game with default set up
     */
    public function __construct() {
        parent::__construct(self::NAME);
        $this->initPiles();
    }

    /**
     * function to deal the cards to be played
     * will be called when running this game
     */
    public function dealCards() {
        // get the deck and shuffle
        $shuffled = $this->deck->shuffle();
        // five cycle of deal for this game
        for ($deals = 0; $deals < 5; $deals++) {
            foreach ($this->tableauPiles as $pile) {
                $pile->deal($shuffled->getNextCard());
            }
        }
        // put remaining cards to randomly picked towers
        $randKeys = array_rand($this->towerPiles, 2);
        while ($card = $shuffled->getNextCard()) {
            $this->towerPiles[array_pop($randKeys)]->addCard($card);
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
        // four tower piles 
        for ($count = 0; $count < 4; $count++) {
            $this->towerPiles[] = new TowerPile();
        }
        // merged set of whole bunch of piles
        $this->piles = array_merge($this->foundationPiles, $this->tableauPiles, $this->towerPiles);
    }

}
