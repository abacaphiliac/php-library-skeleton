<?php

namespace PhpLibrarySkeleton\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;

class MinimumStability extends AbstractFileIO
{
    /**
     * @return void
     * @throws \RuntimeException
     */
    public function updateContents()
    {
        $contents = $this->getFile()->getContents();

        $contents['minimum-stability'] = $this->getIoHelper()->getPackageMinimumStability();

        $this->getFile()->setContents($contents);
    }
}
