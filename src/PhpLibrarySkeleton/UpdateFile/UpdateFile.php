<?php

namespace PhpLibrarySkeleton\UpdateFile;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;
use PhpLibrarySkeleton\File\FileInterface;

class UpdateFile
{
    /** @var FileInterface */
    private $file;

    /** @var AbstractFileIO[] */
    private $fileCommands = array();

    /**
     * UpdateTravisConfig constructor.
     * @param FileInterface $file
     * @param AbstractFileIO[] $fileCommands
     */
    public function __construct(FileInterface $file, array $fileCommands)
    {
        $this->file = $file;
        array_walk($fileCommands, array($this, 'addFileCommand'));
    }

    /**
     * @param AbstractFileIO $command
     * @return void
     */
    private function addFileCommand(AbstractFileIO $command)
    {
        $this->fileCommands[] = $command;
    }

    /**
     * @return void
     */
    public function __invoke()
    {
        // Update Travis config in-memory.
        foreach ($this->fileCommands as $travisUpdate) {
            $travisUpdate->updateContents();
        }

        // Write updates to disk.
        $this->file->writeFile();
    }
}
