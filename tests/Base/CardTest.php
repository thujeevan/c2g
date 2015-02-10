<?php

namespace c2g\Test\Base;

use PHPUnit_Framework_TestCase;
use c2g\Base\Card;

/**
 * CardTest
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
class CardTest extends PHPUnit_Framework_TestCase {
    
    protected $card;

    protected function setUp() {
        // new card Hearts A which is initially faced down
        $this->card = new Card(['suit' => 'H', 'class' => 1], ['index' => 1, 'term' => 'A' ]);
    }
    
    function testInstance(){
        $this->assertTrue($this->card instanceof Card);
    }
    
    function testGetSuit(){
        $this->assertEquals(['suit' => 'H', 'class' => 1], $this->card->getSuit());
    }
    
    function testGetRank(){
        $this->assertEquals(['index' => 1, 'term' => 'A' ], $this->card->getRank());
    }
    
    function testIsFacedUp(){
        $this->assertFalse($this->card->isFacedUp());
    }
    
    function testFlip(){
        $this->assertFalse($this->card->isFacedUp());
        $this->card->flip();
        $this->assertTrue($this->card->isFacedUp());
    }
    
    function testIsSameSuit(){
        $card = new Card(['suit' => 'H', 'class' => 1], ['index' => 2, 'term' => '2' ]);
        $this->assertTrue($this->card->isSameSuit($card));
        $this->assertNotEquals($card, $this->card);
    }
    
    function testIsAlternate(){
        $card = new Card(['suit' => 'C', 'class' => 0], ['index' => 1, 'term' => 'A' ]);
        $this->assertTrue($this->card->isAlternate($card));
    }
    
    function testIsGreaterThan(){
        $card = new Card(['suit' => 'C', 'class' => 0], ['index' => 2, 'term' => '2' ]);
        $this->assertFalse($this->card->isGreaterThan($card));
    }
    
    function testIsLessThan(){
        $card = new Card(['suit' => 'C', 'class' => 0], ['index' => 2, 'term' => '2' ]);
        $this->assertTrue($this->card->isLessThan($card));
    }
    
    function testIsEqualInRank(){
        $card = new Card(['suit' => 'C', 'class' => 0], ['index' => 1, 'term' => 'A' ]);
        $this->assertTrue($this->card->isEqual($card));
    }
    
    function testIsLessThanByOne(){
        $card = new Card(['suit' => 'C', 'class' => 0], ['index' => 2, 'term' => '2' ]);
        $this->assertTrue($this->card->isLessThanByOne($card));
        $card = new Card(['suit' => 'C', 'class' => 0], ['index' => 3, 'term' => '3' ]);
        $this->assertFalse($this->card->isLessThanByOne($card));
    }
    
    function testIsGreaterThanByOne(){
        $card1 = new Card(['suit' => 'C', 'class' => 0], ['index' => 2, 'term' => '2' ]);
        $this->assertTrue($card1->isGreaterThanByOne($this->card));
        $card2 = new Card(['suit' => 'C', 'class' => 0], ['index' => 3, 'term' => '3' ]);
        $this->assertFalse($card2->isGreaterThanByOne($this->card));
    }
    
    function testIsFirstInRank(){
        $this->assertTrue($this->card->isFirstInRank());
        $card = new Card(['suit' => 'C', 'class' => 0], ['index' => 3, 'term' => '3' ]);
        $this->assertFalse($card->isFirstInRank());
    }
    
    function testIsLastInRank(){
        $card1 = new Card(['suit' => 'C', 'class' => 0], ['index' => 13, 'term' => 'K' ]);
        $this->assertTrue($card1->isLastInRank());
        $this->assertFalse($this->card->isLastInRank());
    }
    
    function testToString(){
        $this->assertContains('faced down', sprintf('%s', $this->card));
        $this->card->flip();
        $this->assertNotContains('HA', sprintf('%s', $this->card));
        $this->assertContains('AH', sprintf('%s', $this->card));
    }
}
