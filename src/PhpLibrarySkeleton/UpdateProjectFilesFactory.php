<?php

namespace PhpLibrarySkeleton;

use Composer\IO\IOInterface;
use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileHelper;
use PhpLibrarySkeleton\File\JsonFile;
use PhpLibrarySkeleton\File\YmlFile;
use PhpLibrarySkeleton\FindAndReplace\FindAndReplace;
use PhpLibrarySkeleton\UpdateComposerConfig;
use PhpLibrarySkeleton\UpdateDirectoryStructure\UpdateDirectoryStructure;
use PhpLibrarySkeleton\UpdateTravisConfig;

class UpdateProjectFilesFactory
{
    /**
     * @param \SplFileInfo $root
     * @param IOInterface $io
     * @return UpdateProjectFiles
     * @throws \InvalidArgumentException
     */
    public static function createCommand(\SplFileInfo $root, IOInterface $io)
    {
        // Provide root to the file helper so that we can do recursive find-and-replace later.
        $fileHelper = new FileHelper($root);
        
        // Wrap IO so that questions are not asked multiple times (maintains state).
        $ioHelper = new IOHelper($io);
        
        // Get a Composer config handle which can be used as a read-only copy while we're processing updates.
        $readOnlyComposerConfig = new JsonFile(new \SplFileInfo($root->getPathname() . '/composer.json'));
        $readOnlyComposerConfig->getContents();

        // Get a Composer config handle and build the update objects.
        $composerConfig = new JsonFile(new \SplFileInfo($root->getPathname() . '/composer.json'));
        $composerUpdates = array(
            new UpdateComposerConfig\ClassNamespace($composerConfig, $ioHelper),
            new UpdateComposerConfig\MinimumPhpVersion($composerConfig, $ioHelper),
            new UpdateComposerConfig\MinimumStability($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageAuthor($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageDescription($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageKeywords($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageLicense($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageName($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageScripts($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageType($composerConfig, $ioHelper),
        );

        // Get a Travis config handle and build the update objects.
        $travisConfig = new YmlFile(new \SplFileInfo($root->getPathname() . '/.travis.yml'));
        $travisUpdates = array(
            new UpdateTravisConfig\MinimumPhpVersion($travisConfig, $ioHelper),
        );
        
        // Update README description.
        // Remove README Usage.
        // Remove README TODO.

        return new UpdateProjectFiles(array(
            new UpdateTravisConfig\UpdateTravisConfig($travisConfig, $travisUpdates),
            new UpdateComposerConfig\UpdateComposerConfig($composerConfig, $composerUpdates),
            new FindAndReplace($fileHelper, $ioHelper, $readOnlyComposerConfig),
            new UpdateDirectoryStructure($ioHelper, $root),
        ));
    }
}
