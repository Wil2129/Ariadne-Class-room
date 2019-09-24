<?php
declare(strict_types=1);
require_once "Item.php";
require_once "Student.php";

class Classroom
{
    private $classroomId;
    private $teacherId;
    private $items;
    private $students;

    public function __construct(int $classroomId, int $teacherId)
    {
        $this->classroomId = $classroomId;
        $this->teacherId = $teacherId;
        $this->items = array();
        $this->students = array();
    }

    public function getId(): int
    {
        return $this->classroomId;
    }

    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    public function addStudent(Student $student): void
    {
        $this->students[] = $student;
    }
}
?>