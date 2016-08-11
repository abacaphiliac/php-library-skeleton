<?php

namespace PhpLibrarySkeletonTest\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileInterface;
use PhpLibrarySkeleton\UpdateComposerConfig\PackageScripts;

/**
 * @covers \PhpLibrarySkeleton\UpdateComposerConfig\PackageScripts
 * @covers \PhpLibrarySkeleton\Composer\IO\AbstractFileIO
 */
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

    public function testRemovePostCreateProjectCmdScripts()
    {
        $this->file->method('getContents')->willReturn(array(
            'scripts' => array(
                'post-create-project-cmd' => 'Foo::bar',
                'test' => 'vendor/bin/phpunit',
            ),
        ));
        
        $this->file->method('setContents')->with(self::callback(function(array $actual) {
            \PHPUnit_Framework_TestCase::assertArrayNotHasKey('post-create-project-cmd', $actual['scripts']);
            
            return true;
        }));
        
        $this->sut->updateContents();
    }

    public function testFilterEmptyScripts()
    {
        $this->file->method('getContents')->willReturn(array(
            'scripts' => array(
                
            ),
        ));
        
        $this->file->method('setContents')->with(self::callback(function(array $actual) {
            \PHPUnit_Framework_TestCase::assertArrayNotHasKey('scripts', $actual);
            
            return true;
        }));
        
        $this->sut->updateContents();
    }
}
