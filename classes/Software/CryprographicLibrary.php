<?php

require_once(__DIR__ . '/Library.php');

class CryprographicLibrary extends Library
{
    protected string $algorithm;
    protected int $minKeyLength;
    protected int $maxKeyLength;
    public function __construct(string $name, string|array $versions, string $author, string $license, string $language, string $registry, string $algorithm, int $minKeyLength, int $maxKeyLength)
    {
        parent::__construct($name, $versions, $author, $license, $language, $registry);
        $this->algorithm = $algorithm;
        $this->setMinKeyLength($minKeyLength);
        $this->setMaxKeyLength($maxKeyLength);
    }

    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }
    public function getMinKeyLength(): int
    {
        return $this->minKeyLength;
    }
    public function getMaxKeyLength(): int
    {
        return $this->maxKeyLength;
    }
    public function setAlgorithm(string $algorithm)
    {
        $this->algorithm = $algorithm;
    }
    public function setMinKeyLength(int $minKeyLength)
    {
        if ($minKeyLength < 0) {
            throw new Exception('Key length has to be above 0');
        } else if ($minKeyLength > $this->maxKeyLength) {
            throw new Exception('Min key length has to be below max key length');
        }
        $this->minKeyLength = $minKeyLength;
    }
    public function setMaxKeyLength(int $maxKeyLength)
    {
        if ($maxKeyLength < 0) {
            throw new Exception('Key length has to be above 0');
        } else if ($maxKeyLength > $this->minKeyLength) {
            throw new Exception('Max key length has to be above min key length');
        }
        $this->maxKeyLength = $maxKeyLength;
    }

    public function hashProperties(): string
    {
        return hash("sha256", implode(get_object_vars($this)));
    }
    public function __toString(): string
    {
        return parent::__toString() . $this->algorithm . " " . $this->minKeyLength . " " . $this->maxKeyLength;
    }
}