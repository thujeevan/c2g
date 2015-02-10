<?php

namespace c2g\Test\Towers;

use PHPUnit_Framework_TestCase;
use c2g\Base\Card;
use c2g\Base\FoundationPile;
use c2g\Towers\TableauPile;
use c2g\Towers\TowerPile;

/**
 * Description of TowerPileTest
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class TowerPileTest extends PHPUnit_Framework_TestCase {

    protected $tableau;
    protected $tower;
    protected $foundation;

    protected function setUp() {
        $this->tableau = new TableauPile();
        $this->tower = new TowerPile();
        $this->foundation = new FoundationPile(FALSE);
    }

    function testCanAddCard() {
        $card1 = new Card(['suit' => 'H', 'class' => 1], ['index' => 1, 'term' => 'A']);
        $this->assertTrue($this->tower->isEmpty());
        $this->assertFalse($this->tableau->canAdd($card1, $this->foundation));
        $this->assertTrue($this->tower->canAdd($card1, $this->tableau));

        $card2 = new Card(['suit' => 'H', 'class' => 1], ['index' => 13, 'term' => 'K']);
        $this->assertTrue($this->tower->isEmpty());
        $this->assertFalse($this->tableau->canAdd($card2, $this->foundation));
        $this->assertTrue($this->tower->canAdd($card2, $this->tableau));
        
        $this->tower->addCard($card2); // deal/move one card
        $this->assertTrue($this->tower->isFull());
        $this->assertFalse($this->tower->canAdd($card1, $this->tableau));
    }
}
