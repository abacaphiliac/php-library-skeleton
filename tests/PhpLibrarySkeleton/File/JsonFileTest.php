<?php

namespace PhpLibrarySkeletonTest\File;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use PhpLibrarySkeleton\File\JsonFile;

/**
 * @covers \PhpLibrarySkeleton\File\JsonFile
 * @covers \PhpLibrarySkeleton\File\AbstractFile
 */
class JsonFileTest extends \PHPUnit_Framework_TestCase
{
    /** @var vfsStreamDirectory */
    private $root;
    
    /** @var vfsStreamFile */
    private $file;
    
    /** @var JsonFile */
    private $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->root = vfsStream::setup('vfsTest');

        $this->file = vfsStream::newFile('file.json');
        $this->root->addChild($this->file);

        $this->sut = new JsonFile(new \SplFileInfo($this->file->url()));
    }
    
    public function testGetContentsReadsFile()
    {
        file_put_contents($this->file->url(), '{"Foo": "Bar"}');
        
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
        
        self::assertStringEqualsFile($this->file->url(), <<<'JSON'
{
    "Foo": "Bar"
}
JSON
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFileNotFound()
    {
        new JsonFile(new \SplFileInfo($this->root->url() . '/FooBar.json'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFileNotReadable()
    {
        $file = vfsStream::newFile('FooBar.json', 0);
        $this->root->addChild($file);
        
        new JsonFile(new \SplFileInfo($file->url()));
    }
    
    public function testGetFile()
    {
        self::assertInstanceOf('\SplFileInfo', $this->sut->getFile());
    }
}
