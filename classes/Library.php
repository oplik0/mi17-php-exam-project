<?php
require_once(__DIR__ . "Software.php");

class Library extends Software
{
    private string $language;
    private string $registry;
    private bool $isSemVer;
    public function __construct(string $name, string|array $versions, string $author, string $license, string $language, string $registry)
    {
        parent::__construct($name, $versions, $author, $license);
        $this->language = $language;
        $this->registry = $registry;
        $this->isSemVer = true;
        foreach ($this->versions as $version) {
            if (!preg_match("/^((([0-9]+)\.([0-9]+)\.([0-9]+)(?:-([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?)(?:\+([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?)$/", $version)) {
                $this->isSemVer = false;
                break;
            }
        }
    }
    public function getLanguage(): string
    {
        return $this->language;
    }
    public function getRegistry(): string
    {
        return $this->registry;
    }
    public function isSemVer(): bool
    {
        return $this->isSemVer;
    }
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }
    public function setRegistry(string $registry): void
    {
        if (preg_match("https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)"))
            $this->registry = $registry;
    }
}