<?php
declare(strict_types=1);
require_once "User.php";
require_once "Classroom.php";
require_once "Item.php";

class Teacher extends User
{
    const TYPE = 'teacher';

    private $type = self::TYPE;
    private $teacherId;
    private $classrooms;

    public function __construct(int $teacherId, string $name, string $email, string $password)
    {
        parent::__construct($teacherId, $name, $email, $password);
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

    public function createClassroom(int $classroomId): void
    {
        $classroom = new Classroom($classroomId, $this->teacherId);
        $this->classrooms[] = $classroom;
    }

    public function createItemForClassroom(int $itemId, Classroom $classroom): void
    {
        if (in_array($classroom, $this->classrooms)) {
            $item = new Item($itemId, $this->teacherId, $classroom->classroomId);
            $classroom->addItem($item);
        }
    }
}
?>