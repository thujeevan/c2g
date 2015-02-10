<?php

namespace c2g\Sixteens;

use c2g\Base\FoundationPile;
use c2g\Base\Game;

/**
 * Sixteens game main file
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class Sixteens extends Game {
    
    const NAME = 'Sixteens';

    /**
     * @var array of TableauPiles
     */
    protected $tableauPiles;
    
    /**
     * @var array of SpecialTableauPiles
     */
    protected $specialTableauPiles;

    /**
     * construct the game with default settings
     * init will be called to setup the piles for this game
     */
    public function __construct() {
        parent::__construct(self::NAME);
        $this->initPiles();
    }

    /**
     * function which deal cards to each piles from the deck
     * each piles will hold the references to the specific cards from the deck
     */
    public function dealCards() {
        $shuffled = $this->deck->shuffle();
        $piles = array_merge($this->tableauPiles, $this->specialTableauPiles);
        $pileCount = count($piles);
        $deckCount = count($shuffled);
        $deals = ceil($deckCount / $pileCount);
        while ($deals--) {
            foreach ($piles as $key => $pile) {
                $next = $shuffled->getNextCard();
                if (!$next) {
                    break;
                }
                $pile->deal($next);
            }
        }
        $this->redrawBoard();
    }

    /**
     * private function which responsible to setup the piles 
     * for this game
     */
    private function initPiles() {
        // four foundation piles
        for ($count = 0; $count < 4; $count++) {
            $this->foundationPiles[] = new FoundationPile(TRUE);
        }
        // sixteen tableau piles 
        for ($count = 0; $count < 16; $count++) {
            $this->tableauPiles[] = new TableauPile();
        }
        // two special tableau piles
        for ($count = 0; $count < 2; $count++) {
            $this->specialTableauPiles[] = new SpecialTableauPile();
        }
        // merged set of whole bunch of piles
        $this->piles = array_merge($this->foundationPiles, $this->tableauPiles, $this->specialTableauPiles);
    }

}
