<?php

namespace PhpLibrarySkeleton\UpdateDirectoryStructure;

use PhpLibrarySkeleton\Composer\IO\IOHelper;

class UpdateDirectoryStructure
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
     */
    public function __invoke()
    {
        $root = $this->root->getPathname();
        $namespace = $this->ioHelper->getClassNamespace();

        // Create new directories.
        $source = $root . '/src/' . $namespace;
        if (!@mkdir($source) && !is_dir($source)) {
            throw new \RuntimeException();
        }

        $tests = $root . '/tests/' . $namespace;
        if (!@mkdir($tests) && !is_dir($tests)) {
            throw new \RuntimeException();
        }

        // Remove old directories.
        $deleteTask = new \DeleteTask();
        $deleteTask->setDir(new \PhingFile($root . '/src/PhpLibrarySkeleton'));
        $deleteTask->main();

        $deleteTask->setDir(new \PhingFile($root . '/tests/PhpLibrarySkeleton'));
        $deleteTask->main();
    }
}
