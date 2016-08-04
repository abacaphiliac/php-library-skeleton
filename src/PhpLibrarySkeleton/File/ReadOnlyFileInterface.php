<?php

namespace PhpLibrarySkeleton\File;

interface ReadOnlyFileInterface
{
    /**
     * @return \SplFileInfo
     */
    public function getFile();

    /**
     * @return mixed[]
     */
    public function getContents();
}
