<?php

namespace c2g\Test\FortyThieves;

use PHPUnit_Framework_TestCase;
use c2g\Base\Card;
use c2g\Base\DiscardPile;
use c2g\Base\FoundationPile;
use c2g\Base\Pile;
use c2g\Base\StockPile;
use c2g\FortyThieves\TableauPile;

/**
 * Description of TableauPile
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class TableauPileTest extends PHPUnit_Framework_TestCase {

    protected $tableau;
    protected $tableau2;
    protected $foundation;
    protected $stock;
    protected $discard;

    protected function setUp() {
        $this->tableau = new TableauPile();
        $this->tableau2 = new TableauPile();
        $this->foundation = new FoundationPile(FALSE);
        $this->stock = new StockPile(32);
        $this->discard = new DiscardPile();
    }

    function testInstance() {
        $this->assertTrue($this->tableau instanceof TableauPile);
        $this->assertTrue($this->tableau instanceof Pile);
    }

    function testCanAddWhenEmpty() {
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 1, 'term' => 'A']);
        $this->assertTrue($this->tableau->canAdd($card, $this->discard));
        $this->assertFalse($this->tableau->canAdd($card, $this->stock));
        $this->assertFalse($this->tableau->canAdd($card, $this->foundation));
        $this->assertTrue($this->tableau->canAdd($card, $this->tableau2));

        $this->assertTrue($this->tableau->isEmpty());
        $this->tableau->addCard($card);
        $this->assertFalse($this->tableau->isEmpty());

        $removed = $this->tableau->removeCard();
        $this->assertEquals($removed, $card);
        $this->assertTrue($this->tableau->isEmpty());

        $card = new Card(['suit' => 'D', 'class' => 1], ['index' => 2, 'term' => '2']);
        $this->assertTrue($this->tableau->canAdd($card, $this->discard));
        $this->assertFalse($this->tableau->canAdd($card, $this->stock));
        $this->assertFalse($this->tableau->canAdd($card, $this->foundation));
        $this->assertTrue($this->tableau->canAdd($card, $this->tableau2));

        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 13, 'term' => 'K']);
        $this->assertTrue($this->tableau->canAdd($card, $this->discard));
        $this->assertFalse($this->tableau->canAdd($card, $this->stock));
        $this->assertFalse($this->tableau->canAdd($card, $this->foundation));
        $this->assertTrue($this->tableau->canAdd($card, $this->tableau2));
    }

    function testCanAddWhenNotEmpty() {
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 7, 'term' => '7']);
        $this->assertTrue($this->tableau->canAdd($card, $this->tableau2));

        $this->assertTrue($this->tableau->isEmpty());
        $this->tableau->addCard($card);
        $this->assertFalse($this->tableau->isEmpty());
        
        $card = new Card(['suit' => 'D', 'class' => 1], ['index' => 6, 'term' => '6']);
        $this->assertFalse($this->tableau->canAdd($card, $this->discard));
        $this->assertFalse($this->tableau->canAdd($card, $this->stock));
        $this->assertFalse($this->tableau->canAdd($card, $this->foundation));
        $this->assertFalse($this->tableau->canAdd($card, $this->tableau2));

        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 6, 'term' => '6']);
        $this->assertTrue($this->tableau->canAdd($card, $this->discard));
        $this->assertFalse($this->tableau->canAdd($card, $this->stock));
        $this->assertFalse($this->tableau->canAdd($card, $this->foundation));
        $this->assertTrue($this->tableau->canAdd($card, $this->tableau2));
    }

    function testCanRemove(){
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 7, 'term' => '7']);
        $this->tableau->addCard($card);
        $card = new Card(['suit' => 'D', 'class' => 1], ['index' => 1, 'term' => 'A']);
        $this->tableau2->addCard($card);
        
        $this->assertFalse($this->foundation->canAdd($this->tableau->top()));        
        $this->assertTrue($this->foundation->canAdd($this->tableau2->top()));
    }
}
