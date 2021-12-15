<?php

/**
 * A generic operating system class
 * @author @oplik0
 * @version 0.1
 * @package php-exam
 */

require_once(__DIR__ . "/Software.php");

class OS extends Software
{

    protected string $architecture;
    protected string $distributionOf;
    protected string $kernelVersion;
    protected string $kernelName;
    public function __construct(string $name = "unknown", string|array $versions = "0.0.0", string $author = "unknown", string $license = "unknown", string $architecture = "unknown", string $distributionOf = "unknown", string $kernelName = "unknown", string $kernelVersion = "0.0.0")
    {
        parent::__construct($name, $versions, $author, $license);
        $this->architecture = $architecture;
        $this->distributionOf = $distributionOf;
        $this->kernelName = $kernelName;
        $this->kernelVersion = $kernelVersion;
    }
    public function getArchitecture(): string
    {
        return $this->architecture;
    }
    public function getDistribution(): string
    {
        return $this->distributionOf;
    }
    public function getKernelVersion(): string
    {
        return $this->kernelVersion;
    }
    public function getKernelName(): string
    {
        return $this->kernelName;
    }
    public function setArchitecture(string $architecture): void
    {
        if (in_array($architecture, self::ARCHITECTURES)) {
            $this->architecture = $architecture;
        } else {
            throw new Exception("Invalid architecture! Supported architectures are: " . implode(", ", self::ARCHITECTURES));
        }
    }
    public function __toString(): string
    {
        return parent::__toString() . " is an OS distributionOf of " . $this->distributionOf . "using " . $this->kernelName . " version " . $this->kernelVersion . " kernel";
    }

    const ARCHITECTURES = array(
        'x86',
        'x86-64',
        'amd64',
        'arm',
        'arm64',
        'aarch64',
        'mips',
        'mips64',
        'ppc',
        'ppc64',
        'sparc',
        'avr',
        'avr32',
        'itanium',
        'rv32i',
        'rv32e',
        'rv64i',
        'rv128i',
        'unknown'
    );
}