<?php
declare(strict_types=1);
require_once "User.php";
require_once "Classroom.php";

class Teacher extends User
{
    const TYPE = 'teacher';

    private $teacherId;
    private $classrooms;

    public function __construct(string $name, string $email, string $password)
    {
        parent::__construct($name, $email, $password);
        $this->teacherId = $this->uid;
        $this->type = self::TYPE;
        $this->classrooms = array();
    }

    public function getId(): int
    {
        return $this->teacherId;
    }

    public function getClassrooms(): array
    {
        return $this->classrooms;
    }

    public function createClassroom(): void
    {
        $classroom = new Classroom($this->teacherId);
        $this->classrooms[] = $classroom;
    }

    public function createItemForClassroom(Classroom $classroom): void
    {
        if (in_array($classroom, $this->classrooms)) {
            $item = new Item($this->teacherId, $classroom->classroomId);
            $classroom->addItem($item);
        }
    }
}
?>