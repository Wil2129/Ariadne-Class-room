<?php
declare(strict_types=1);

class Item
{
    private $itemId;
    private $classroomId;
    private $teacherId;

    public function __construct(int $teacherId, int $classroomId)
    {
        $this->teacherId = $teacherId;
        $this->classroomId = $classroomId;
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
}
?>