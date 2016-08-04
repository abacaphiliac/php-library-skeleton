<?php

namespace PhpLibrarySkeleton\UpdateTravisConfig;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;
use PhpLibrarySkeleton\File\FileInterface;

class UpdateTravisConfig
{
    /** @var FileInterface */
    private $writableConfig;

    /** @var AbstractFileIO[] */
    private $fileCommands = array();

    /**
     * UpdateTravisConfig constructor.
     * @param FileInterface $writableConfig
     * @param AbstractFileIO[] $fileCommands
     */
    public function __construct(FileInterface $writableConfig, array $fileCommands)
    {
        $this->writableConfig = $writableConfig;
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
        $this->writableConfig->writeFile();
    }
}
