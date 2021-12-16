<?php

/**
 * A generic software application class
 * @author @oplik0
 * @version 0.1
 * @package php-exam
 */

require_once(__DIR__ . "/Software.php");
require_once(__DIR__ . "/OS.php");

class Application extends Software
{
    protected OS $os;
    protected string $icon;
    protected array $permissions;

    public function __construct(string $name = "unknown", string|array $versions = "0.0.0", string $author = "unknown", string $license = "unknown", string $icon = "unknown.ico", array $permissions = array(), OS $os = new OS())
    {
        parent::__construct($name, $versions, $author, $license);
        $this->icon = $icon;
        $this->permissions = $permissions;
        $this->os = $os;
    }
    public function getIcon(): string
    {
        return $this->icon;
    }
    public function getPermissions(): array
    {
        return $this->permissions;
    }
    public function getOS(): OS
    {
        return $this->os;
    }
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }
    public function setPermissions(array $permissions): void
    {
        $this->permissions = $permissions;
    }
    public function setOS(OS $os): void
    {
        $this->os = $os;
    }
    public function __toString(): string
    {
        $perms = implode(", ", $this->permissions);
        return str_replace("]", ", for $this->os os, icon: $this->icon, requires $perms permissions]", parent::__toString());
    }
}