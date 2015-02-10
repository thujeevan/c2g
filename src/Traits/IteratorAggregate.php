<?php
namespace c2g\Traits;

use ArrayIterator;

/**
 * provides the generic concrete implementation to IteratorAggregate interface's 
 * abstract methods 
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
trait IteratorAggregate {
    
    protected abstract function &getContainer();
    
    /**
     * IteratorAggregate related, used to loop over the object.
     * @return ArrayIterator
     */
    public function getIterator() {
        $container = &$this->getContainer();
        return new ArrayIterator($container);
    }
}
