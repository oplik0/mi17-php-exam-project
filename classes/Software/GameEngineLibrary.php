<?php

use MyCLabs\Enum\Enum;

require_once(__DIR__ . '/Library.php');
require_once(__DIR__ . '/../../utils/php-enum.php');
class Dimensions extends Enum
{
    private const SIDE2D = 'SIDE2D';
    private const ISOMETRIC2D = 'ISOMETRIC2D';
    private const SIDE2_5D = 'SIDE2_5D';
    private const ISOMETRIC2_5D = 'ISOMETRIC2_5D';
    private const PSUEDO3D = 'PSUEDO3D';
    private const FULL3D = 'FULL3D';
}



class GameEngineLibrary extends Library
{
    protected Dimensions $dimensions;
    protected bool $revenueShare;

    public function __construct(string $name = "unknown", string|array $versions = "0.0.0", string $author = "unknown", string $license = "unknown", string $language = "unknown", string $registry = 'http://localhost', string|Dimensions $dimensions = 'SIDE2D', bool $revenueShare = false)
    {
        parent::__construct($name, $versions, $author, $license, $language, $registry);
        $this->setDimensions($dimensions);
        $this->revenueShare = $revenueShare;
    }

    public function getDimensions(): Dimensions
    {
        return $this->dimensions;
    }
    public function usesRevenueShare(): bool
    {
        return $this->revenueShare;
    }
    public function setDimensions(string|Dimensions $dimensions): void
    {
        if ($dimensions instanceof Dimensions) {
            $this->dimensions = $dimensions;
        } else if (Dimensions::isValid($dimensions)) {
            $this->dimensions = Dimensions::from($dimensions);
        } else {
            throw new InvalidArgumentException("Invalid dimensions");
        }
    }
    public function setRevenueShare(bool $revenueShare): void
    {
        $this->revenueShare = $revenueShare;
    }
    public function isFullyOpenSource(): bool
    {
        return $this->usesOSIApprovedLicense() && !$this->revenueShare;
    }
    public function __toString(): string
    {
        $revenueShare = ($this->revenueShare) ? "requires revenue share" : "does not require revenue share";
        return str_replace("]", ", supports $this->Dimensions, $revenueShare]", parent::__toString());
    }
}