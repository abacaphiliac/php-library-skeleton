<?php

namespace PhpLibrarySkeletonTest\UpdateFile;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;
use PhpLibrarySkeleton\File\FileInterface;
use PhpLibrarySkeleton\UpdateFile\UpdateFile;

class UpdateFileTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|AbstractFileIO */
    private $updateCommand;
    
    /** @var \PHPUnit_Framework_MockObject_MockObject|FileInterface */
    private $file;
    
    protected function setUp()
    {
        parent::setUp();

        $this->file = $this->getMockBuilder('\PhpLibrarySkeleton\File\FileInterface')->getMock();

        $this->updateCommand = $this->getMockBuilder('\PhpLibrarySkeleton\Composer\IO\AbstractFileIO')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
    }
    
    public function testInvokesUpdateAndWritesFile()
    {
        $this->updateCommand->expects(self::once())->method('updateContents');
        
        $this->file->expects(self::once())->method('writeFile');
        
        $sut = new UpdateFile($this->file, array(
            $this->updateCommand
        ));
        
        $sut();
    }
}
