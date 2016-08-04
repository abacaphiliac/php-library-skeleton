<?php

namespace PhpLibrarySkeletonTest\Composer\IO;

use Composer\IO\IOInterface;
use PhpLibrarySkeleton\Composer\IO\IOHelper;

/**
 * @covers \PhpLibrarySkeleton\Composer\IO\IOHelper
 */
class IOHelperTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|IOInterface */
    private $io;
    
    /** @var IOHelper */
    private $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->io = $this->getMockBuilder('\Composer\IO\IOInterface')->getMock();
        
        $this->sut = new IOHelper($this->io);
    }
    
    public function testAskUntilTruthy()
    {
        $this->io->method('ask')
            ->willReturnOnConsecutiveCalls(0, false, null, '', array(), 'FooBar');
        
        self::assertEquals('FooBar', $this->sut->askUntilTruthy('Fizz buzz?'));
    }
    
    public function testGetAuthorName()
    {
        $this->io->expects(self::once())->method('ask')
            ->willReturn('Foo Bar');
        
        self::assertEquals('Foo Bar', $this->sut->getAuthorName());
        self::assertEquals('Foo Bar', $this->sut->getAuthorName());
    }
    
    public function testGetAuthorEmail()
    {
        $this->io->expects(self::once())->method('ask')
            ->willReturn('foo@bar.com');
        
        self::assertEquals('foo@bar.com', $this->sut->getAuthorEmail());
        self::assertEquals('foo@bar.com', $this->sut->getAuthorEmail());
    }
    
    public function testGetClassNamespace()
    {
        $this->io->expects(self::once())->method('ask')
            ->willReturn('Foo\Bar');
        
        self::assertEquals('Foo\Bar', $this->sut->getClassNamespace());
        self::assertEquals('Foo\Bar', $this->sut->getClassNamespace());
    }
    
    public function testGetMinimumPhpVersion()
    {
        $this->io->expects(self::once())->method('ask')
            ->willReturn('7.0');
        
        self::assertEquals('7.0', $this->sut->getMinimumPhpVersion());
        self::assertEquals('7.0', $this->sut->getMinimumPhpVersion());
    }
    
    public function testGetPackageDescription()
    {
        $this->io->expects(self::once())->method('ask')
            ->willReturn('Foo is bar.');
        
        self::assertEquals('Foo is bar.', $this->sut->getPackageDescription());
        self::assertEquals('Foo is bar.', $this->sut->getPackageDescription());
    }
    
    public function testGetPackageKeywords()
    {
        $this->io->expects(self::once())->method('ask')
            ->willReturn('Foo , Bar,Bizz, Buzz,');
        
        self::assertInternalType('array', $this->sut->getPackageKeywords());
        self::assertContains('Foo', $this->sut->getPackageKeywords());
        self::assertContains('Bar', $this->sut->getPackageKeywords());
        self::assertContains('Bizz', $this->sut->getPackageKeywords());
        self::assertContains('Buzz', $this->sut->getPackageKeywords());
    }

    public function testGetPackageLicense()
    {
        $this->io->expects(self::once())->method('ask')
            ->willReturn('Apache-2.0');

        self::assertEquals('Apache-2.0', $this->sut->getPackageLicense());
        self::assertEquals('Apache-2.0', $this->sut->getPackageLicense());
    }

    public function testGetPackageMinimumStability()
    {
        $this->io->expects(self::once())->method('ask')
            ->willReturn('dev');

        self::assertEquals('dev', $this->sut->getPackageMinimumStability());
        self::assertEquals('dev', $this->sut->getPackageMinimumStability());
    }

    public function testGetPackageName()
    {
        $this->io->expects(self::once())->method('ask')
            ->willReturn('foo/bar');

        self::assertEquals('foo/bar', $this->sut->getPackageName());
        self::assertEquals('foo/bar', $this->sut->getPackageName());
    }

    public function testGetPackageType()
    {
        $this->io->expects(self::once())->method('ask')
            ->willReturn('project');

        self::assertEquals('project', $this->sut->getPackageType());
        self::assertEquals('project', $this->sut->getPackageType());
    }
}
