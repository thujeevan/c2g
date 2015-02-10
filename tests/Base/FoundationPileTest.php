<?php

namespace c2g\Test\Base;

use PHPUnit_Framework_TestCase;
use c2g\Base\Card;
use c2g\Base\FoundationPile;

/**
 * FoundationPileTest
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class FoundationPileTest extends PHPUnit_Framework_TestCase {
    
    protected $foundationPile;

    protected function setUp() {
        $this->foundationPile = new FoundationPile(FALSE);
    }
    
    function testCanAdd(){
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 1, 'term' => 'A' ]);
        $this->assertTrue($this->foundationPile->isEmpty());
        $this->assertTrue($this->foundationPile->canAdd($card));
        
    }
    
    function testCanRemove(){
        $this->assertFalse($this->foundationPile->canRemove());
    }
    
    function testAddFirstCard() {
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 1, 'term' => 'A' ]);
        $this->foundationPile->addCard($card);
        $this->assertFalse($this->foundationPile->isEmpty());
        $this->assertFalse($this->foundationPile->canAdd($card));
    }
    
    function testAddNextCard() {
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 1, 'term' => 'A' ]);
        $this->foundationPile->addCard($card);
        
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 2, 'term' => '2' ]);
        $this->assertTrue($this->foundationPile->canAdd($card));
        $this->foundationPile->addCard($card);
        
        $this->assertEquals(2, count($this->foundationPile));
        
        $card = new Card(['suit' => 'S', 'class' => 0], ['index' => 3, 'term' => '3' ]);
        $this->assertFalse($this->foundationPile->canAdd($card));
    }
    
    function testFull() {
        $cards = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
        foreach ($cards as $k => $c){
            $card = new Card(['suit' => 'H', 'class' => 1], ['index' => $k, 'term' => $c ]);
            $this->foundationPile->addCard($card);
        }
        
        $card = new Card(['suit' => 'S', 'class' => 0], ['index' => 2, 'term' => '2' ]);
        $this->assertTrue($this->foundationPile->isFull());
        $this->assertFalse($this->foundationPile->canAdd($card));
    }
}