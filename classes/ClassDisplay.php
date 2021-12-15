<?php

class ClassDisplay
{
    private int $id;
    private string $name;
    private string $imgSrc;
    private string $title;
    private int $level;
    private int $parentId;
    private array $children;
    public function __construct(int $id, string $name, string $imgSrc, string $title, int $level, int $parentId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->imgSrc = $imgSrc;
        $this->title = $title;
        $this->level = $level;
        $this->parentId = $parentId;
    }
    public function addChild(ClassDisplay $child)
    {
        $this->children[] = $child;
    }
    public function toHTML()
    {
        $nextLevel = $this->level + 1;
        $childrenString = "";
        foreach ($this->children as $child) {
            $childrenString .= $child->toHTML();
        }
        return <<<EOD
        <div class="classCard">
            <div class="classCard__info">
                <img src="$this->imgSrc" alt="$this->title">
                <h3>$this->title</h3>
                <p>$this->name</p>
            </div>
            <div class="classChildren level level$nextLevel">
                $childrenString
            </div>
        </div>
        EOD;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getImgSrc(): string
    {
        return $this->imgSrc;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getLevel(): int
    {
        return $this->level;
    }
    public function getParentId(): int
    {
        return $this->parentId;
    }
    public function __toString()
    {
        return $this->toHTML();
    }
}