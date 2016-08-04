<?php

namespace PhpLibrarySkeletonTest\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileInterface;
use PhpLibrarySkeleton\UpdateComposerConfig\PackageLicense;

/**
 * @covers \PhpLibrarySkeleton\UpdateComposerConfig\PackageLicense
 * @covers \PhpLibrarySkeleton\Composer\IO\AbstractFileIO
 */
class PackageLicenseTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|FileInterface */
    private $file;
    
    /** @var \PHPUnit_Framework_MockObject_MockObject|IOHelper */
    private $ioHelper;
    
    /** @var PackageLicense */
    private $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->file = $this->getMockBuilder('\PhpLibrarySkeleton\File\FileInterface')
            ->getMock();
        
        $this->ioHelper = $this->getMockBuilder('\PhpLibrarySkeleton\Composer\IO\IOHelper')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->sut = new PackageLicense($this->file, $this->ioHelper);
    }

    public function testFilterPackageLicense()
    {
        $this->file->method('getContents')->willReturn(array(
            'license' => 'Apache-2.0',
        ));
        
        $this->ioHelper->method('getPackageLicense')->willReturn('MIT');
        
        $this->file->method('setContents')->with(self::callback(function(array $actual) {
            $expected = array(
                'license' => 'MIT',
            );
            \PHPUnit_Framework_TestCase::assertArraySubset($expected, $actual);
            
            return true;
        }));
        
        $this->sut->updateContents();
    }
}
