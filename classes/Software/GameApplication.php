<?php
require_once(__DIR__ . '/Application.php');

require_once(__DIR__ . '/GameEngineLibrary.php');

class GameApplication extends Application
{
    protected string $genre;
    protected GameEngineLibrary $gameEngine;
    public function __construct(GameEngineLibrary $engine)
    {
        parent::__construct();
        $this->name = 'Game';
        $this->gameEngine = $engine;
    }
}