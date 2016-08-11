<?php

namespace PhpLibrarySkeleton\UpdateFile;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;
use PhpLibrarySkeleton\File\FileInterface;

class RemoveFile
{
    /** @var \SplFileInfo */
    private $file;

    /**
     * RemoveFile constructor.
     * @param \SplFileInfo $file
     */
    public function __construct(\SplFileInfo $file)
    {
        $this->file = $file;
    }

    /**
     * @return void
     */
    public function __invoke()
    {
        @unlink($this->file->getPathname());
    }
}
