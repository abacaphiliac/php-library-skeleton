<?php

namespace PhpLibrarySkeleton\File;

abstract class AbstractFile implements FileInterface
{
    /** @var \SplFileInfo */
    private $file;
    
    /** @var mixed[] */
    private $contents;

    /**
     * AbstractFileSerializer constructor.
     * @param \SplFileInfo $file
     * @throws \InvalidArgumentException
     */
    public function __construct(\SplFileInfo $file)
    {
        if (!$file->isFile()) {
            throw new \InvalidArgumentException($file->getFilename() . ' is not a file.');
        }
        
        if (!$file->isReadable()) {
            throw new \InvalidArgumentException($file->getFilename() . ' is not readable.');
        }
        
        $this->file = $file;
    }

    /**
     * @param mixed $data
     * @return mixed[]
     */
    abstract protected function decode($data);

    /**
     * @param mixed[] $data
     * @return mixed
     */
    abstract protected function encode(array $data);

    /**
     * @return \SplFileInfo
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return mixed[]
     */
    public function getContents()
    {
        if ($this->contents === null) {
            $encoded = file_get_contents($this->file->getPathname());
            
            $this->contents = $this->decode($encoded) ?: array();
        }
        
        return $this->contents;
    }

    /**
     * @param mixed[] $contents
     * @return void
     */
    public function setContents(array $contents)
    {
        $this->contents = $contents;
    }

    /**
     * @return int
     */
    public function writeFile()
    {
        $encoded = $this->encode($this->contents);

        return file_put_contents($this->file->getPathname(), $encoded);
    }
}
