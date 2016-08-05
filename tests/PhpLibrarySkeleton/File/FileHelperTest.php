<?php

namespace PhpLibrarySkeletonTest\File;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PhpLibrarySkeleton\File\FileHelper;

/**
 * @covers \PhpLibrarySkeleton\File\FileHelper
 */
class FileHelperTest extends \PHPUnit_Framework_TestCase
{
    /** @var vfsStreamDirectory */
    private $root;
    
    /** @var FileHelper */
    private $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->root = vfsStream::setup('vfsTest');

        $phpStormDir = vfsStream::newDirectory('.idea');
        $phpStormFile = vfsStream::newFile('workspace.xml');
        $phpStormDir->addChild($phpStormFile);
        $this->root->addChild($phpStormDir);

        $gitDir = vfsStream::newDirectory('.git');
        $gitFile = vfsStream::newFile('index');
        $gitDir->addChild($gitFile);
        $this->root->addChild($gitDir);

        $vendorDir = vfsStream::newDirectory('vendor');
        $vendorFile = vfsStream::newFile('autoload.php');
        $vendorDir->addChild($vendorFile);
        $this->root->addChild($vendorDir);
        
        $composerFile = vfsStream::newFile('composer.lock');
        $this->root->addChild($composerFile);
        
        $this->sut = new FileHelper(new \SplFileInfo($this->root->url()));
    }
    
    public function testGetFiles()
    {
        $projectFile = vfsStream::newFile('FooBar.txt');
        $this->root->addChild($projectFile);
        
        $actual = $this->sut->getFiles();
        
        self::assertCount(1, $actual);
        self::assertArrayHasKey($projectFile->url(), $actual);
        self::assertInstanceOf('\SplFileInfo', $actual[$projectFile->url()]);
        self::assertEquals($projectFile->url(), $actual[$projectFile->url()]->getPathname());
    }
    
    public function testWalkFiles()
    {
        $projectFile = vfsStream::newFile('FooBar.txt');
        $this->root->addChild($projectFile);
        
        $walkedFiles = array();
        
        $this->sut->walkFiles(function (\SplFileInfo $file) use (&$walkedFiles) {
            $walkedFiles[] = $file->getPathname();
        });
        
        self::assertContains($projectFile->url(), $walkedFiles);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWalkFilesWithoutCallable()
    {
        /** @var callable $callable */
        $callable = new \stdClass();
        
        $this->sut->walkFiles($callable);
    }
    
    public function testFindAndReplaceInFile()
    {
        $projectFile = vfsStream::newFile('FooBar.txt');
        $this->root->addChild($projectFile);
        
        file_put_contents($projectFile->url(), 'Fizz FooBar Buzz');
        
        FileHelper::findAndReplaceInFile($projectFile->url(), 'FooBar', 'FizzBuzz');
        
        self::assertEquals('Fizz FizzBuzz Buzz', file_get_contents($projectFile->url()));
    }
    
    public function testFindAndReplaceInFiles()
    {
        $projectFile = vfsStream::newFile('FooBar.txt');
        $this->root->addChild($projectFile);
        
        file_put_contents($projectFile->url(), 'Fizz FooBar Buzz');
        
        $this->sut->findAndReplaceInFiles('FooBar', 'FizzBuzz');
        
        self::assertEquals('Fizz FizzBuzz Buzz', file_get_contents($projectFile->url()));
    }
    
    public function testRemoveSourceDirectory()
    {
        $dir = vfsStream::newDirectory('src');
        $this->root->addChild($dir);
        
        $file = vfsStream::newFile('FooBar.php');
        $dir->addChild($file);
        
        self::assertTrue(is_dir($this->root->url()));
        self::assertTrue(is_dir($dir->url()));
        self::assertFileExists($file->url());
        
        FileHelper::removeDirectory($dir->url());
        
        self::assertFileNotExists($file->url());
        self::assertFalse(is_dir($dir->url()));
        self::assertTrue(is_dir($this->root->url()));
    }
    
    public function testRemoveTestDirectory()
    {
        $dir = vfsStream::newDirectory('tests');
        $this->root->addChild($dir);
        
        $file = vfsStream::newFile('FooBarTest.php');
        $dir->addChild($file);
        
        self::assertTrue(is_dir($this->root->url()));
        self::assertTrue(is_dir($dir->url()));
        self::assertFileExists($file->url());
        
        FileHelper::removeDirectory($dir->url());
        
        self::assertFileNotExists($file->url());
        self::assertFalse(is_dir($dir->url()));
        self::assertTrue(is_dir($this->root->url()));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNotRemovesDirectory()
    {
        $dir = vfsStream::newDirectory('FooBar');
        $this->root->addChild($dir);
        
        FileHelper::removeDirectory($dir->url());
    }
}
