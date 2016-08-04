<?php

namespace PhpLibrarySkeletonTest\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileInterface;
use PhpLibrarySkeleton\UpdateComposerConfig\MinimumPhpVersion;

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
            'requires' => array(
                'php' => '>=5.3',
            ),
        ));
        
        $this->ioHelper->method('getMinimumPhpVersion')->willReturn('5.6');
        
        $this->file->method('setContents')->with(self::callback(function(array $actual) {
            $expected = array(
                'requires' => array(
                    'php' => '>=5.6',
                ),
            );
            \PHPUnit_Framework_TestCase::assertArraySubset($expected, $actual);
            
            return true;
        }));
        
        $this->sut->updateContents();
    }
}
