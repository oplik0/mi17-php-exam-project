<?php
require_once(__DIR__ . '/Application.php');

require_once(__DIR__ . '/GameEngineLibrary.php');

class IDEApplication extends Application
{
    protected bool $supportsAddons;
    protected array $languages;
    public function __construct(string $name = "unknown", string|array $versions = "0.0.0", string $author = "unknown", string $license = "unknown", string $icon = "unknown.ico", array $permissions = array(), OS $os = new OS(), bool $supportsAddons = false, array $languages = array())
    {
        parent::__construct($name, $versions, $author, $license, $icon, $permissions, $os);
        $this->supportsAddons = $supportsAddons;
        $this->setLanguages($languages);
    }
    public function getSupportsAddons(): bool
    {
        return $this->supportsAddons;
    }
    public function getLanguages(): array
    {
        return $this->languages;
    }
    public function setLanguages(string|array $languages): void
    {
        if (gettype($languages) == 'string') {
            $languages = array($languages);
        }
        $this->languages = $languages;
    }
    public function setSupportsAddons(bool $supportsAddons): void
    {
        $this->supportsAddons = $supportsAddons;
    }
    public function getSupportedgamEngines(mysqli $db): array
    {
        $lookupStatement = $db->prepare("SELECT * FROM `GameEngineLibrary__objects` WHERE `language` in (?)");
        $lookupStatement->bind_param("s", implode(', ', $this->getLanguages()));
        $lookupStatement->execute();
        return array_map(fn ($values) => new GameEngineLibrary($values['name'], $values['versions'], $values['author'], $values['license'], $values['language'], $values['registry'], new Dimensions($values['width'], $values['height'], $values['depth']), $values['revenueShare']), $lookupStatement->get_result()->fetch_all(MYSQLI_ASSOC));
    }
    public function __toString(): string
    {
        $addonSupport = $this->supportsAddons ? "supports addons" : "does not support addons";
        $languages = implode(', ', $this->getLanguages());
        return str_replace("]", ", for $languages, $addonSupport]", parent::__toString());
    }
}