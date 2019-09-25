<?php
declare(strict_types=1);

class Item
{
    private $itemId;
    private $classroomId;
    private $teacherId;
    private $title;
    private $content;
    private $filesUrl;

    public function __construct(int $itemId, int $classroomId, int $teacherId, string $title)
    {
        $this->itemId = $itemId;
        $this->teacherId = $teacherId;
        $this->classroomId = $classroomId;
        $this->title = $title;
    }

    public function getId(): int
    {
        return $this->itemId;
    }

    public function getClassroomId(): int
    {
        return $this->classroomId;
    }

    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getFilesUrl(): string
    {
        return $this->filesUrl;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setFilesUrl(string $filesUrl): void
    {
        $this->filesUrl = $filesUrl;
    }
}
?>