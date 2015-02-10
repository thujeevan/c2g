<?php
namespace c2g\Traits;

use c2g\Core\Card;

/**
 * provides the generic concrete implementation to ArrayAccess interface's 
 * abstract methods 
 *
 * @author Thurairajah Thujeevan <thujee@gmail.com>
 */
trait ArrayAccess {
    
    protected abstract function &getContainer();
    
    /**
     * ArrayAccess related
     * @param int $index The index to test for existence.
     * @return boolean Returns true of the offset exists.
     */
    public function offsetExists($index) {
        $container = &$this->getContainer();
        return array_key_exists($index, $container);
    }

    /**
     * ArrayAccess related
     *
     * @param int $index The index to get..
     * @return mixed Returns the Card object at the location.
     */
    public function offsetGet($index) {
        $container = &$this->getContainer();
        return $this->offsetExists($index) ? $container[$index] : NULL;
    }

    /**
     * ArrayAccess related. Sets an index with the value, or adds a value if it
     * is null.
     * @param int|null $index The index to set, or null to add.
     * @param Card $value The card to set/add.
     * @return null
     */
    public function offsetSet($index, $value) {
        $container = &$this->getContainer();
        if (is_null($index)) {
            $container[] = $value;
        } else {
            $container[$index] = $value;
        }
    }

    /**
     * Unsets the index location.
     * @param int $index
     * @return void
     */
    public function offsetUnset($index) {
        if ($this->offsetExists($index)) {
            // since this Deck is numeric array/array like, this is safer to
            // have continuous array indexes than unset()
            array_splice($this->getContainer(), $index, 1);
        }
    }
}
