<?php

namespace PhpLibrarySkeletonTest\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileInterface;
use PhpLibrarySkeleton\UpdateComposerConfig\PackageDescription;

/**
 * @covers \PhpLibrarySkeleton\UpdateComposerConfig\PackageDescription
 * @covers \PhpLibrarySkeleton\Composer\IO\AbstractFileIO
 */
class PackageDescriptionTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|FileInterface */
    private $file;
    
    /** @var \PHPUnit_Framework_MockObject_MockObject|IOHelper */
    private $ioHelper;
    
    /** @var PackageDescription */
    private $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->file = $this->getMockBuilder('\PhpLibrarySkeleton\File\FileInterface')
            ->getMock();
        
        $this->ioHelper = $this->getMockBuilder('\PhpLibrarySkeleton\Composer\IO\IOHelper')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->sut = new PackageDescription($this->file, $this->ioHelper);
    }

    public function testFilterPackageDescription()
    {
        $this->file->method('getContents')->willReturn(array(
            'description' => 'Foo is bar.',
        ));
        
        $this->ioHelper->method('getPackageDescription')->willReturn('Fizz is buzz.');
        
        $this->file->method('setContents')->with(self::callback(function(array $actual) {
            $expected = array(
                'description' => 'Fizz is buzz.',
            );
            \PHPUnit_Framework_TestCase::assertArraySubset($expected, $actual);
            
            return true;
        }));
        
        $this->sut->updateContents();
    }
}
