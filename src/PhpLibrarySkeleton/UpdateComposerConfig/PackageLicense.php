<?php

namespace PhpLibrarySkeleton\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;

class PackageLicense extends AbstractFileIO
{
    /**
     * @return void
     * @throws \RuntimeException
     */
    public function updateContents()
    {
        $contents = $this->getFile()->getContents();

        $contents['license'] = $this->getIoHelper()->getPackageLicense();

        $this->getFile()->setContents($contents);
    }
}
