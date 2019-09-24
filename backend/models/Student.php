<?php
declare(strict_types=1);
require_once "User.php";
require_once "Classroom.php";

class Student extends User
{
    const TYPE = 'student';

    private $type = self::TYPE;
    private $studentId;
    private $classrooms;

    public function __construct(string $name, string $email, string $password)
    {
        parent::__construct($name, $email, $password);
        $this->studentId = $this->uid;
        $this->type = self::TYPE;
        $this->classrooms = array();
    }

    public function getId(): int
    {
        return $this->studentId;
    }

    public function getClassrooms(): array
    {
        return $this->classrooms;
    }

    public function registerToClassroom(Classroom $classroom): void
    {
        $this->classrooms[] = $classroom;
        $classroom->addStudent($this);
    }

    public function getItems(Classroom $classroom): array
    {
        if (in_array($classroom, $this->classrooms)) {
            return $classroom->items;
        }
    }
}
?>