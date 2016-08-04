<?php

namespace PhpLibrarySkeleton\File;

interface FileInterface extends ReadOnlyFileInterface
{
    /**
     * @param mixed[] $contents
     * @return void
     */
    public function setContents(array $contents);

    /**
     * @return void
     */
    public function writeFile();
}
