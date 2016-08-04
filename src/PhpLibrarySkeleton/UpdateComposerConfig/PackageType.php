<?php

namespace PhpLibrarySkeleton\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;

class PackageType extends AbstractFileIO
{
    /**
     * @return void
     * @throws \RuntimeException
     */
    public function updateContents()
    {
        $contents = $this->getFile()->getContents();

        $contents['type'] = $this->getIoHelper()->getPackageType();

        $this->getFile()->setContents($contents);
    }
}
