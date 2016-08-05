<?php

namespace PhpLibrarySkeletonTest\UpdateDirectory;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\UpdateDirectory\ReplaceTestDirectory;

class ReplaceTestDirectoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|IOHelper */
    private $ioHelper;
    
    /** @var vfsStreamDirectory */
    private $root;

    protected function setUp()
    {
        parent::setUp();

        $this->root = vfsStream::setup('vfsTest');
        
        $testDir = vfsStream::newDirectory('tests');
        $this->root->addChild($testDir);
        
        $oldDir = vfsStream::newDirectory('PhpLibrarySkeleton');
        $testDir->addChild($oldDir);

        $this->ioHelper = $this->getMockBuilder('\PhpLibrarySkeleton\Composer\IO\IOHelper')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    public function testReplaceTestDirectory()
    {
        $this->ioHelper->method('getClassDirectory')->willReturn('Foo/Bar');
        
        self::assertTrue(is_dir($this->root->url() . '/tests/PhpLibrarySkeleton'));
        self::assertFalse(is_dir($this->root->url() . '/tests/Foo/Bar'));

        $sut = new ReplaceTestDirectory($this->ioHelper, new \SplFileInfo($this->root->url()));
        $sut();

        self::assertFalse(is_dir($this->root->url() . '/tests/PhpLibrarySkeleton'));
        self::assertTrue(is_dir($this->root->url() . '/tests/Foo/Bar'));
    }
}
