<?php

namespace PhpLibrarySkeleton\UpdateComposerConfig;

use Composer\Script\ScriptEvents;
use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;

class PackageScripts extends AbstractFileIO
{
    /**
     * @return void
     * @throws \RuntimeException
     */
    public function updateContents()
    {
        $contents = $this->getFile()->getContents();

        unset($contents['scripts'][ScriptEvents::POST_CREATE_PROJECT_CMD]);

        $this->getFile()->setContents($contents);
    }
}
