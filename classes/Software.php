<?php
require_once(__DIR__ . '../helpers/licenses.php');

class Software
{
    private string $name;
    private array $versions = array();
    private string $author;
    private string $license;
    private bool $OSIApproved;
    function __construct(string $name, string|array $versions, string $author, string $license)
    {
        $this->setName($name);
        $this->setVersions($versions);
        $this->setAuthor($author);
        $this->setLicense($license);
    }
    function getName(): string
    {
        return $this->name;
    }
    function getVersions(): array
    {
        return $this->version;
    }
    function getAuthor(): string
    {
        return $this->author;
    }
    function getLicense(): string
    {
        return $this->license;
    }
    function usesOSIApprovedLicense(): bool
    {
        return $this->OSIApproved;
    }
    function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setVersions(string|array $versions): void
    {
        if (gettype($versions) == 'string') {
            $versions = array($versions);
        }
        usort($versions, function ($a, $b) {
            $a = (int)preg_grep('/^[0-9]+/', $a);
            $b = (int)preg_grep('/^[0-9]+/', $b);
            if ($a === $b) return 0;
            return ($a > $b) ? -1 : 1;
        });
        foreach ($versions as $version) {
            if (!preg_match('/([\w\d]+[\.\-_]*)+/', $version)) {
                throw new Exception('Invalid version number!');
            }
            array_push($this->versions, $version);
        }
    }
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }
    public function setLicense(string $license): void
    {
        if (in_array($license, Licenses->$OSIApproved)) {
            $this->OSIApproved = true;
        } else {
            $this->OSIApproved = false;
        }
        $this->license = $license;
    }
    public function getLatestVersion(): string
    {
        return $this->versions[0];
    }
    public function countVersions(): int
    {
        return count($this->versions);
    }
    public function __toString()
    {
        return $this->name . ' ' . $this->getLatestVersion() . ' by ' . $this->author . ' (licensed under ' . $this->license . ')';
    }
}