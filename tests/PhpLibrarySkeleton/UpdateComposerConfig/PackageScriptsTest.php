<?php

namespace PhpLibrarySkeletonTest\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileInterface;
use PhpLibrarySkeleton\UpdateComposerConfig\PackageScripts;

class PackageScriptsTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|FileInterface */
    private $file;
    
    /** @var \PHPUnit_Framework_MockObject_MockObject|IOHelper */
    private $ioHelper;
    
    /** @var PackageScripts */
    private $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->file = $this->getMockBuilder('\PhpLibrarySkeleton\File\FileInterface')
            ->getMock();
        
        $this->ioHelper = $this->getMockBuilder('\PhpLibrarySkeleton\Composer\IO\IOHelper')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->sut = new PackageScripts($this->file, $this->ioHelper);
    }

    public function testFilterPackageScripts()
    {
        $this->file->method('getContents')->willReturn(array(
            'scripts' => array(
                'post-create-project-cmd' => 'Foo::bar',
            ),
        ));
        
        $this->file->method('setContents')->with(self::callback(function(array $actual) {
            \PHPUnit_Framework_TestCase::assertArrayNotHasKey('post-create-project-cmd', $actual['scripts']);
            
            return true;
        }));
        
        $this->sut->updateContents();
    }
}
