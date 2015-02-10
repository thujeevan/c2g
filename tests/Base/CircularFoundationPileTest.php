<?php

namespace c2g\Test\Base;

use PHPUnit_Framework_TestCase;
use c2g\Base\Card;
use c2g\Base\FoundationPile;

/**
 * CircularFoundationPileTest
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class CircularFoundationPileTest extends PHPUnit_Framework_TestCase {
    
    protected $pile1;
    protected $pile2;

    protected function setUp() {
        $this->pile1 = new FoundationPile(TRUE);
        $this->pile2 = new FoundationPile(TRUE);
    }
    
    function testCanAdd(){
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 1, 'term' => 'A' ]);
        $this->assertTrue($this->pile1->isEmpty());
        $this->assertTrue($this->pile1->canAdd($card));        
    }
    
    function testCanStartWithAny(){
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 13, 'term' => 'K' ]);
        $this->assertTrue($this->pile1->isEmpty());
        $this->assertTrue($this->pile1->canAdd($card));        
    }
    
    function testCanRemove(){
        $this->assertFalse($this->pile1->canRemove());
    }
    
    function testAddFirstCard() {
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 1, 'term' => 'A' ]);
        $this->assertTrue($this->pile1->canAdd($card));
        $this->pile1->addCard($card);
        
        $card = new Card(['suit' => 'C', 'class' => 1], ['index' => 1, 'term' => 'A' ]);
        $this->assertTrue($this->pile2->canAdd($card));
        
        $card = new Card(['suit' => 'S', 'class' => 1], ['index' => 2, 'term' => '2' ]);
        $this->assertFalse($this->pile2->canAdd($card));
        
        FoundationPile::$baseCard = NULL;
    }
    
    function testAddNextCard() {
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 13, 'term' => 'K' ]);
        $this->assertTrue($this->pile1->canAdd($card));
        $this->pile1->addCard($card);
        
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 1, 'term' => 'A' ]);
        $this->assertTrue($this->pile1->canAdd($card));
        $this->pile1->addCard($card);
        
        $this->assertEquals(2, count($this->pile1));
        
        $card = new Card(['suit' => 'S', 'class' => 0], ['index' => 3, 'term' => '3' ]);
        $this->assertFalse($this->pile1->canAdd($card));
        
        FoundationPile::$baseCard = NULL;
    }
    
    function testFull() {
        $cards = ['7', '8', '9', '10', 'J', 'Q', 'K', 'A', '2', '3', '4', '5', '6'];
        foreach ($cards as $k => $c){
            $card = new Card(['suit' => 'H', 'class' => 1], ['index' => $k, 'term' => $c ]);
            $this->pile1->addCard($card);
        }
        
        $card = new Card(['suit' => 'S', 'class' => 0], ['index' => 2, 'term' => '2' ]);
        $this->assertTrue($this->pile1->isFull());
        $this->assertFalse($this->pile1->canAdd($card));
    }
}