<?php

namespace PhpLibrarySkeleton\File;

interface FileInterface
{
    /**
     * @return \SplFileInfo
     */
    public function getFile();

    /**
     * @return mixed[]
     */
    public function getContents();

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
