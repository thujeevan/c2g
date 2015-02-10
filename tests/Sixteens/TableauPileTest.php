<?php

namespace c2g\Test\Sixteens;

use PHPUnit_Framework_TestCase;
use c2g\Base\Card;
use c2g\Base\FoundationPile;
use c2g\Base\Pile;
use c2g\Sixteens\SpecialTableauPile;
use c2g\Sixteens\TableauPile;

/**
 * Description of TableauPile
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class TableauPileTest extends PHPUnit_Framework_TestCase {

    protected $tableau;
    protected $tableau2;
    protected $foundation;
    protected $spTableau;

    protected function setUp() {
        $this->tableau = new TableauPile();
        $this->tableau2 = new TableauPile();
        $this->foundation = new FoundationPile(TRUE);
        $this->spTableau = new SpecialTableauPile();
    }

    function testInstance() {
        $this->assertTrue($this->tableau instanceof TableauPile);
        $this->assertTrue($this->tableau instanceof Pile);
    }

    function testCanAddWhenEmpty() {
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 1, 'term' => 'A']);
        $this->assertFalse($this->tableau->canAdd($card, $this->foundation));
        $this->assertFalse($this->tableau->canAdd($card, $this->spTableau));
        
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 1, 'term' => 'A']);
        $this->assertTrue($this->spTableau->isEmpty());
        $this->assertFalse($this->spTableau->canAdd($card, $this->foundation));
        $this->assertTrue($this->spTableau->canAdd($card, $this->tableau));
        $this->assertTrue($this->spTableau->canAdd($card, $this->spTableau));
    }

    function testCanAddWhenNotEmpty() {
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 7, 'term' => '7']);
        $this->tableau->deal($card); // deal one card        
        $this->assertFalse($this->tableau->canAdd($card, $this->foundation));
        
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 6, 'term' => '6']);
        $this->assertFalse($this->tableau->canAdd($card, $this->spTableau));
        $this->assertFalse($this->tableau->canAdd($card, $this->tableau2));
        
        $card = new Card(['suit' => 'S', 'class' => 0], ['index' => 6, 'term' => '6']);
        $this->assertTrue($this->tableau->canAdd($card, $this->spTableau));
        $this->assertTrue($this->tableau->canAdd($card, $this->tableau2));        
        $this->tableau->addCard($card);
        
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 5, 'term' => '5']);
        $this->assertTrue($this->tableau->canAdd($card, $this->tableau2));
        $this->tableau->addCard($card);
        
        $this->assertEquals(3, count($this->tableau));
        $card = new Card(['suit' => 'S', 'class' => 0], ['index' => 4, 'term' => '4']);
        $this->assertFalse($this->tableau->canAdd($card, $this->tableau2));
        
        $card = new Card(['suit' => 'S', 'class' => 0], ['index' => 1, 'term' => 'A']);
        $this->tableau2->addCard($card);
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 13, 'term' => 'K']);
        $this->assertTrue($this->tableau2->canAdd($card, $this->tableau));
    }
}
