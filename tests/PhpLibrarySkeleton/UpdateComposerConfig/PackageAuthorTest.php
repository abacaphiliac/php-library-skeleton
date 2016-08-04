<?php

namespace PhpLibrarySkeletonTest\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileInterface;
use PhpLibrarySkeleton\UpdateComposerConfig\PackageAuthor;

/**
 * @covers \PhpLibrarySkeleton\UpdateComposerConfig\PackageAuthor
 * @covers \PhpLibrarySkeleton\Composer\IO\AbstractFileIO
 */
class PackageAuthorTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|FileInterface */
    private $file;
    
    /** @var \PHPUnit_Framework_MockObject_MockObject|IOHelper */
    private $ioHelper;
    
    /** @var PackageAuthor */
    private $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->file = $this->getMockBuilder('\PhpLibrarySkeleton\File\FileInterface')
            ->getMock();
        
        $this->ioHelper = $this->getMockBuilder('\PhpLibrarySkeleton\Composer\IO\IOHelper')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->sut = new PackageAuthor($this->file, $this->ioHelper);
    }

    public function testFilterPackageAuthor()
    {
        $this->file->method('getContents')->willReturn(array(
            'authors' => array(
                array(
                    'name' => 'Foo Bar',
                    'email' => 'foo@bar.com',
                ),
            ),
        ));
        
        $this->ioHelper->method('getAuthorName')->willReturn('Fizz Buzz');
        $this->ioHelper->method('getAuthorEmail')->willReturn('fizz@buzz.com');
        
        $this->file->method('setContents')->with(self::callback(function(array $actual) {
            $expected = array(
                'authors' => array(
                    array(
                        'name' => 'Fizz Buzz',
                        'email' => 'fizz@buzz.com',
                    ),
                ),
            );
            \PHPUnit_Framework_TestCase::assertArraySubset($expected, $actual);
            
            return true;
        }));
        
        $this->sut->updateContents();
    }
}
