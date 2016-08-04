<?php

namespace PhpLibrarySkeletonTest\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileInterface;
use PhpLibrarySkeleton\UpdateComposerConfig\PackageKeywords;

class PackageKeywordsTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|FileInterface */
    private $file;
    
    /** @var \PHPUnit_Framework_MockObject_MockObject|IOHelper */
    private $ioHelper;
    
    /** @var PackageKeywords */
    private $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->file = $this->getMockBuilder('\PhpLibrarySkeleton\File\FileInterface')
            ->getMock();
        
        $this->ioHelper = $this->getMockBuilder('\PhpLibrarySkeleton\Composer\IO\IOHelper')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->sut = new PackageKeywords($this->file, $this->ioHelper);
    }

    public function testFilterPackageKeywords()
    {
        $this->file->method('getContents')->willReturn(array(
            'keywords' => array(
                'Foo',
                'Bar',
            ),
        ));
        
        $this->ioHelper->method('getPackageKeywords')->willReturn('Fizz, Buzz,');
        
        $this->file->method('setContents')->with(self::callback(function(array $actual) {
            \PHPUnit_Framework_TestCase::assertArrayHasKey('keywords', $actual);
            \PHPUnit_Framework_TestCase::assertContains('Fizz', $actual['keywords']);
            \PHPUnit_Framework_TestCase::assertContains('Fizz', $actual['keywords']);
            \PHPUnit_Framework_TestCase::assertNotContains('Foo', $actual['keywords']);
            \PHPUnit_Framework_TestCase::assertNotContains('Bar', $actual['keywords']);
            
            return true;
        }));
        
        $this->sut->updateContents();
    }
}
