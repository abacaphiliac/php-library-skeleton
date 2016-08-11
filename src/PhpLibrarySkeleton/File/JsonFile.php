<?php

namespace PhpLibrarySkeleton\File;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonFile extends AbstractFile
{
    /** @var Serializer */
    private $serializer;

    /**
     * JsonFileSerializer constructor.
     * @param \SplFileInfo $file
     * @throws \InvalidArgumentException
     */
    public function __construct(\SplFileInfo $file)
    {
        parent::__construct($file);
        
        $normalizers = array(new ObjectNormalizer());
        $encoders = array(new JsonEncoder());

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @param mixed $data
     * @return mixed[]
     * @throws UnexpectedValueException
     */
    protected function decode($data)
    {
        return $this->serializer->decode($data, JsonEncoder::FORMAT);
    }

    /**
     * @param mixed[] $data
     * @return string
     * @throws UnexpectedValueException
     */
    protected function encode(array $data)
    {
        return str_replace('\/', '/', $this->serializer->encode($data, JsonEncoder::FORMAT));
    }
}
