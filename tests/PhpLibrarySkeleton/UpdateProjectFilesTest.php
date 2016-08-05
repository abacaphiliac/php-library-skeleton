<?php

namespace PhpLibrarySkeletonTest;

use PhpLibrarySkeleton\UpdateProjectFiles;

class UpdateProjectFilesTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $wasCalled = false;
        
        $sut = new UpdateProjectFiles(array(
            function () use (&$wasCalled) {
                $wasCalled = true;
            }
        ));
        
        $sut();
        
        self::assertTrue($wasCalled);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidCallable()
    {
        new UpdateProjectFiles(array(
            new \stdClass(),
        ));
    }
}
