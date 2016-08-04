<?php

namespace PhpLibrarySkeleton\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;

class MinimumPhpVersion extends AbstractFileIO
{
    /**
     * @return void
     * @throws \RuntimeException
     */
    public function updateContents()
    {
        $contents = $this->getFile()->getContents();

        $contents['requires']['php'] = '>=' . $this->getIoHelper()->getMinimumPhpVersion();

        $this->getFile()->setContents($contents);
    }
}
