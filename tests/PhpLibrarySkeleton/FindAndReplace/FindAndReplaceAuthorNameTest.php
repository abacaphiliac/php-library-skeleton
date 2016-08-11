<?php

namespace PhpLibrarySkeletonTest\FindAndReplace;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileHelperInterface;
use PhpLibrarySkeleton\File\ReadOnlyFileInterface;
use PhpLibrarySkeleton\FindAndReplace\FindAndReplaceAuthorName;

class FindAndReplaceAuthorNameTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|IOHelper */
    private $ioHelper;
    
    /** @var \PHPUnit_Framework_MockObject_MockObject|ReadOnlyFileInterface */
    private $originalComposerConfig;
    
    /** @var \PHPUnit_Framework_MockObject_MockObject|FileHelperInterface */
    private $fileHelper;

    protected function setUp()
    {
        parent::setUp();

        $this->fileHelper = $this->getMockBuilder('\PhpLibrarySkeleton\File\FileHelperInterface')
            ->getMock();
        
        $this->ioHelper = $this->getMockBuilder('\PhpLibrarySkeleton\Composer\IO\IOHelper')
            ->disableOriginalConstructor()
            ->getMock();

        $this->originalComposerConfig = $this->getMockBuilder('\PhpLibrarySkeleton\File\ReadOnlyFileInterface')
            ->getMock();
    }
    
    public function testFindAndReplaceInFiles()
    {
        $this->originalComposerConfig->method('getContents')
            ->willReturn(array(
                'authors' => array(
                    array(
                        'name' => $search = 'Foo Bar',
                    ),
                ),
            ));
        
        $this->ioHelper->method('getAuthorName')
            ->willReturn($replace = 'Fizz Buzz');

        $this->fileHelper->expects(self::atLeastOnce())->method('findAndReplaceInFiles')
            ->with($search, $replace);
        
        $sut = new FindAndReplaceAuthorName($this->fileHelper, $this->ioHelper, $this->originalComposerConfig);
        
        $sut();
    }
}
