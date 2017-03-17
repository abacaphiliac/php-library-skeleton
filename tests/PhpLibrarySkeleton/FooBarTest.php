<?php

namespace AbacaphiliacTest\LibrarySkeleton;

use Abacaphiliac\PhpLibrarySkeleton\FooBar;
use Klever\Tutor\AccessMethod\AbstractTestCase;

class FooBarTest extends AbstractTestCase
{
    public function getClassAccessMethodTestConfiguration()
    {
        return [
            'accessors' => [
                'foo' => [
                    'default_value' => 'fiz',
                    'injectable_value' => 'Alice',
                ],
                'bar' => [
                    'default_value' => 'buz',
                    'injectable_value' => 'Bob',
                ],
            ],
        ];
    }
    
    public function getSubjectUnderTest()
    {
        return new FooBar();
    }
}
