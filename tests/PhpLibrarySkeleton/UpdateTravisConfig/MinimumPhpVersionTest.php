<?php

namespace PhpLibrarySkeletonTest\UpdateTravisConfig;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileInterface;
use PhpLibrarySkeleton\UpdateTravisConfig\MinimumPhpVersion;

class MinimumPhpVersionTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|FileInterface */
    private $file;
    
    /** @var \PHPUnit_Framework_MockObject_MockObject|IOHelper */
    private $ioHelper;
    
    /** @var MinimumPhpVersion */
    private $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->file = $this->getMockBuilder('\PhpLibrarySkeleton\File\FileInterface')
            ->getMock();
        
        $this->ioHelper = $this->getMockBuilder('\PhpLibrarySkeleton\Composer\IO\IOHelper')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->sut = new MinimumPhpVersion($this->file, $this->ioHelper);
    }

    public function testFilterMinimumPhpVersion()
    {
        $this->file->method('getContents')->willReturn(array(
            'php' => array(
                '5.3',
                '5.4',
                '5.5',
                '5.6',
                '7.0',
            ),
        ));
        
        $this->ioHelper->method('getMinimumPhpVersion')->willReturn('5.6');
        
        $this->file->method('setContents')->with(self::callback(function(array $actual) {
            \PHPUnit_Framework_TestCase::assertArrayHasKey('php', $actual);
            \PHPUnit_Framework_TestCase::assertNotContains('5.3', $actual['php']);
            \PHPUnit_Framework_TestCase::assertNotContains('5.4', $actual['php']);
            \PHPUnit_Framework_TestCase::assertNotContains('5.5', $actual['php']);
            \PHPUnit_Framework_TestCase::assertContains('5.6', $actual['php']);
            \PHPUnit_Framework_TestCase::assertContains('7.0', $actual['php']);
            
            return true;
        }));
        
        $this->sut->updateContents();
    }
}
