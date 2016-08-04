<?php

namespace PhpLibrarySkeletonTest;

use Composer\IO\IOInterface;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PhpLibrarySkeleton\UpdateProjectFilesFactory;

class UpdateProjectFilesFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|IOInterface */
    private $io;
    
    /** @var vfsStreamDirectory */
    private $root;

    protected function setUp()
    {
        parent::setUp();

        $this->root = vfsStream::setup('vfsTest');
        
        $this->io = $this->getMockBuilder('\Composer\IO\IOInterface')->getMock();
    }
    
    public function testCreateCommand()
    {
        $composerConfig = vfsStream::newFile('composer.json');
        $this->root->addChild($composerConfig);
        
        $travisConfig = vfsStream::newFile('.travis.yml');
        $this->root->addChild($travisConfig);
     
        $root = new \SplFileInfo($this->root->url());
           
        $actual = UpdateProjectFilesFactory::createCommand(
            $root,
            $this->io
        );
        
        self::assertInstanceOf('\PhpLibrarySkeleton\UpdateProjectFiles', $actual);
    }
}
