<?php
namespace c2g\Traits;

/**
 * provides the generic concrete implementation to Countable interface's 
 * abstract method
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
trait Countable {
    
    protected abstract function &getContainer(); 
    

    /**
     * Used by Countable
     * @return integer count of the current cards in the deck
     */
    public function count() {
        $container = &$this->getContainer();
        return count($container);
    }
}
