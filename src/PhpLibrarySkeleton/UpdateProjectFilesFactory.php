<?php

namespace PhpLibrarySkeleton;

use Composer\IO\IOInterface;
use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileHelper;
use PhpLibrarySkeleton\File\JsonFile;
use PhpLibrarySkeleton\File\YmlFile;
use PhpLibrarySkeleton\FindAndReplace\FindAndReplaceAuthorEmail;
use PhpLibrarySkeleton\FindAndReplace\FindAndReplaceAuthorName;
use PhpLibrarySkeleton\FindAndReplace\FindAndReplacePackageName;
use PhpLibrarySkeleton\UpdateComposerConfig;
use PhpLibrarySkeleton\UpdateDirectory\ReplaceSourceDirectory;
use PhpLibrarySkeleton\UpdateDirectory\ReplaceTestDirectory;
use PhpLibrarySkeleton\UpdateFile\RemoveFile;
use PhpLibrarySkeleton\UpdateFile\UpdateFile;
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
            new UpdateComposerConfig\PackageName($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageDescription($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageType($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageKeywords($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageLicense($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageAuthor($composerConfig, $ioHelper),
            new UpdateComposerConfig\MinimumPhpVersion($composerConfig, $ioHelper),
            new UpdateComposerConfig\ClassNamespace($composerConfig, $ioHelper),
            new UpdateComposerConfig\MinimumStability($composerConfig, $ioHelper),
            new UpdateComposerConfig\PackageScripts($composerConfig, $ioHelper),
        );

        // Get a Travis config handle and build the update objects.
        $travisConfig = new YmlFile(new \SplFileInfo($root->getPathname() . '/.travis.yml'));
        $travisUpdates = array(
            new UpdateTravisConfig\MinimumPhpVersion($travisConfig, $ioHelper),
        );
        
        // Update README description.
        // Remove README Usage.
        // Remove README TODO.

        // Build a set of invokable project updates.
        $callables = array(
            new UpdateFile($composerConfig, $composerUpdates),
            new UpdateFile($travisConfig, $travisUpdates),
            new FindAndReplacePackageName($fileHelper, $ioHelper, $readOnlyComposerConfig),
            new FindAndReplaceAuthorName($fileHelper, $ioHelper, $readOnlyComposerConfig),
            new FindAndReplaceAuthorEmail($fileHelper, $ioHelper, $readOnlyComposerConfig),
            new ReplaceTestDirectory($ioHelper, $root),
            new ReplaceSourceDirectory($ioHelper, $root),
            new RemoveFile(new \SplFileInfo($root->getPathname() . '/composer.lock'))
        );

        return new UpdateProjectFiles($callables);
    }
}
