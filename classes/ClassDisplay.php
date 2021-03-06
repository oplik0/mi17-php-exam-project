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
    public function __construct(int $id, string $name, string $imgSrc, string $title, int $level, int $parentId, array $children = array())
    {
        $this->id = $id;
        $this->name = $name;
        $this->imgSrc = $imgSrc;
        $this->title = $title;
        $this->level = $level;
        $this->parentId = $parentId;
        $this->children = $children;
    }
    public function addChild(ClassDisplay $child)
    {
        array_push($this->children, $child);
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
                <a class="classCard__info-link" href="/class/$this->name"><img class="classCard__info-img" src="$this->imgSrc" alt="$this->title"></a>
                <h4><a class="classCard__info-link" href="/class/$this->name">$this->title</a></h4>
                <form class="uploadForm" action='/index.php' method='post' enctype='multipart/form-data'>
                    <input type='hidden' name='classId' value='$this->id'>
                    <input type='file' name='classImage'>
                    <input type='submit' name='imageUpload' value='Upload'>
                </form>
            </div>
            <div class="classChildren level level$nextLevel">
                $childrenString
            </div>
            </form>
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