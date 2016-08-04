<?php

namespace PhpLibrarySkeletonTest\File;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use PhpLibrarySkeleton\File\YmlFile;

/**
 * @covers \PhpLibrarySkeleton\File\YmlFile
 * @covers \PhpLibrarySkeleton\File\AbstractFile
 */
class YmlFileTest extends \PHPUnit_Framework_TestCase
{
    /** @var vfsStreamDirectory */
    private $root;

    /** @var vfsStreamFile */
    private $file;
    
    /** @var YmlFile */
    private $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->root = vfsStream::setup('vfsTest');

        $this->file = vfsStream::newFile('file.json');
        $this->root->addChild($this->file);

        $this->sut = new YmlFile(new \SplFileInfo($this->file->url()));
    }
    
    public function testGetContentsReadsFile()
    {
        file_put_contents($this->file->url(), 'Foo: Bar');
        
        $actual = $this->sut->getContents();
        
        self::assertArraySubset(array('Foo' => 'Bar'), $actual);
    }
    
    public function testSetContentsDoesNotWriteFile()
    {
        self::assertStringEqualsFile($this->file->url(), '');
        
        $this->sut->setContents(array(
            'Foo' => 'Bar',
        ));
        
        self::assertStringEqualsFile($this->file->url(), '');
        
        $actual = $this->sut->getContents();
        
        self::assertArraySubset(array('Foo' => 'Bar'), $actual);
    }
    
    public function testWriteFile()
    {
        self::assertStringEqualsFile($this->file->url(), '');
        
        $this->sut->setContents(array(
            'Foo' => 'Bar',
        ));
        
        $this->sut->writeFile();
        
        self::assertStringEqualsFile($this->file->url(), "Foo: Bar\n");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFileNotFound()
    {
        new YmlFile(new \SplFileInfo($this->root->url() . '/FooBar.yml'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFileNotReadable()
    {
        $file = vfsStream::newFile('FooBar.ynl', 0);
        $this->root->addChild($file);

        new YmlFile(new \SplFileInfo($file->url()));
    }

    public function testGetFile()
    {
        self::assertInstanceOf('\SplFileInfo', $this->sut->getFile());
    }
}
