<?php

namespace PhpLibrarySkeletonTest\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileInterface;
use PhpLibrarySkeleton\UpdateComposerConfig\ClassNamespace;

/**
 * @covers \PhpLibrarySkeleton\UpdateComposerConfig\ClassNamespace
 * @covers \PhpLibrarySkeleton\Composer\IO\AbstractFileIO
 */
class ClassNamespaceTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|FileInterface */
    private $file;
    
    /** @var \PHPUnit_Framework_MockObject_MockObject|IOHelper */
    private $ioHelper;
    
    /** @var ClassNamespace */
    private $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->file = $this->getMockBuilder('\PhpLibrarySkeleton\File\FileInterface')
            ->getMock();
        
        $this->ioHelper = $this->getMockBuilder('\PhpLibrarySkeleton\Composer\IO\IOHelper')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->sut = new ClassNamespace($this->file, $this->ioHelper);
    }

    public function testFilterClassNamespace()
    {
        $this->file->method('getContents')->willReturn(array(
            'autoload' => array(
                'psr-4' => array(
                    'Foo\\Bar\\' => 'src/Foo/Bar',
                ),
            ),
        ));
        
        $this->ioHelper->method('getClassNamespace')->willReturn('Fizz\Buzz');
        
        $this->file->method('setContents')->with(self::callback(function(array $actual) {
            $expected = array(
                'autoload' => array(
                    'psr-4' => array(
                        'Fizz\\Buzz\\' => 'src/Fizz/Buzz',
                    ),
                ),
            );
            \PHPUnit_Framework_TestCase::assertArraySubset($expected, $actual);
            
            return true;
        }));
        
        $this->sut->updateContents();
    }
}
