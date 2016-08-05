<?php

namespace PhpLibrarySkeleton\UpdateDirectory;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileHelper;

class ReplaceSourceDirectory
{
    /** @var IOHelper */
    private $ioHelper;

    /** @var \SplFileInfo */
    private $root;

    /**
     * UpdateDirectoryStructure constructor.
     * @param IOHelper $ioHelper
     * @param \SplFileInfo $root
     */
    public function __construct(IOHelper $ioHelper, \SplFileInfo $root)
    {
        $this->ioHelper = $ioHelper;
        $this->root = $root;
    }

    /**
     * @return void
     * @throws \BuildException
     * @throws \InvalidArgumentException
     * @throws \IOException
     * @throws \NullPointerException
     * @throws \RuntimeException
     */
    public function __invoke()
    {
        $root = $this->root->getPathname();
        $classDirectory = $this->ioHelper->getClassDirectory();

        $newDirectory = $root . '/src/' . $classDirectory;
        $oldDirectory = $root . '/src/PhpLibrarySkeleton';
        
        FileHelper::replaceDirectory($oldDirectory, $newDirectory);
    }
}
