<?php

namespace PhpLibrarySkeleton\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;

class PackageDescription extends AbstractFileIO
{
    /**
     * @return void
     * @throws \RuntimeException
     */
    public function updateContents()
    {
        $contents = $this->getFile()->getContents();

        $contents['description'] = $this->getIoHelper()->getPackageDescription();

        $this->getFile()->setContents($contents);
    }
}
