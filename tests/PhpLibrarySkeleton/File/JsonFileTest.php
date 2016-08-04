<?php

namespace PhpLibrarySkeletonTest\File;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use PhpLibrarySkeleton\File\JsonFile;

class JsonFileTest extends \PHPUnit_Framework_TestCase
{
    /** @var vfsStreamFile */
    private $file;
    
    /** @var JsonFile */
    private $sut;

    protected function setUp()
    {
        parent::setUp();
        
        $dir = vfsStream::setup('vfsTest');

        $this->file = vfsStream::newFile('file.json');
        $dir->addChild($this->file);

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
        
        self::assertStringEqualsFile($this->file->url(), '{"Foo":"Bar"}');
    }
}
