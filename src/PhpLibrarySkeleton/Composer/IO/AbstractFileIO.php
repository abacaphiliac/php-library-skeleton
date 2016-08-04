<?php

namespace PhpLibrarySkeleton\Composer\IO;

use PhpLibrarySkeleton\File\FileInterface;

abstract class AbstractFileIO
{
    /**
     * @var FileInterface
     */
    private $file;
    
    /**
     * @var IOHelper
     */
    private $ioHelper;

    /**
     * AbstractFileIO constructor.
     * @param FileInterface $file
     * @param IOHelper $ioHelper
     */
    public function __construct(FileInterface $file, IOHelper $ioHelper)
    {
        $this->file = $file;
        $this->ioHelper = $ioHelper;
    }

    /**
     * @return void
     */
    abstract public function updateContents();

    /**
     * @return FileInterface
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return IOHelper
     */
    public function getIoHelper()
    {
        return $this->ioHelper;
    }
}
