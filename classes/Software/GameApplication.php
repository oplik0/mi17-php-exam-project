<?php
require_once(__DIR__ . '/Application.php');

require_once(__DIR__ . '/GameEngineLibrary.php');

class GameApplication extends Application
{
    protected string $genre;
    protected GameEngineLibrary $gameEngine;
    public function __construct(string $name = "unknown", string|array $versions = "0.0.0", string $author = "unknown", string $license = "unknown", string $icon = "unknown.ico", array $permissions = array(), OS $os = new OS(), GameEngineLibrary $engine = new GameEngineLibrary(), string $genre = "unknown")
    {
        parent::__construct($name, $versions, $author, $license, $icon, $permissions, $os);
        $this->setGameEngine($engine);
        $this->setGenre($genre);
    }

    public function getGenre(): string
    {
        return $this->genre;
    }
    public function getGameEngine(): GameEngineLibrary
    {
        return $this->gameEngine;
    }
    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }
    public function setGameEngine(GameEngineLibrary $engine): void
    {
        $this->gameEngine = $engine;
    }
    public function setNewGameEngine(string $name, string|array $versions, string $author, string $license, string $language, string $registry, Dimensions $dimensions, bool $revenueShare): void
    {
        $this->gameEngine = new GameEngineLibrary($name, $versions, $author, $license, $language, $registry, $dimensions, $revenueShare);
    }
}