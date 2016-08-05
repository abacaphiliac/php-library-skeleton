<?php

namespace PhpLibrarySkeletonTest\UpdateDirectory;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\UpdateDirectory\ReplaceSourceDirectory;

class ReplaceSourceDirectoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|IOHelper */
    private $ioHelper;
    
    /** @var vfsStreamDirectory */
    private $root;
    
    protected function setUp()
    {
        parent::setUp();

        $this->root = vfsStream::setup('vfsTest');
        
        $sourceDir = vfsStream::newDirectory('src');
        $this->root->addChild($sourceDir);
        
        $oldDir = vfsStream::newDirectory('PhpLibrarySkeleton');
        $sourceDir->addChild($oldDir);

        $this->ioHelper = $this->getMockBuilder('\PhpLibrarySkeleton\Composer\IO\IOHelper')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    public function testReplaceSourceDirectory()
    {
        $this->ioHelper->method('getClassDirectory')->willReturn('Foo/Bar');
        
        self::assertTrue(is_dir($this->root->url() . '/src/PhpLibrarySkeleton'));
        self::assertFalse(is_dir($this->root->url() . '/src/Foo/Bar'));

        $sut = new ReplaceSourceDirectory($this->ioHelper, new \SplFileInfo($this->root->url()));
        $sut();

        self::assertFalse(is_dir($this->root->url() . '/src/PhpLibrarySkeleton'));
        self::assertTrue(is_dir($this->root->url() . '/src/Foo/Bar'));
    }
}
