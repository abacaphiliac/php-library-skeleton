<?php

namespace Abacaphiliac\PhpLibrarySkeleton;

class FooBar
{
    /** @var string */
    private $foo = 'fiz';
    
    /** @var string */
    private $bar = 'buz';
    
    /**
     * @return string
     */
    public function getFoo()
    {
        return $this->foo;
    }
    
    /**
     * @param string $foo
     * @return void
     */
    public function setFoo($foo)
    {
        $this->foo = $foo;
    }
    
    /**
     * @return string
     */
    public function getBar()
    {
        return $this->bar;
    }
    
    /**
     * @param string $bar
     * @return void
     */
    public function setBar($bar)
    {
        $this->bar = $bar;
    }
}
