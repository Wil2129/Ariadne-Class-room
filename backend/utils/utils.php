<?php
declare(strict_types=1);
require_once "database.php";
require_once "../models/User.php";
require_once "../models/Teacher.php";
require_once "../models/Student.php";
require_once "../models/Classroom.php";
require_once "../models/Item.php";


function createClassroom(Teacher $teacher, string $name): void
{
    $teacherId = $teacher->getId();
    try {
        $stmt = $db->prepare("INSERT INTO classrooms (teacher_id, name) VALUES (:teacher_id, :name)");
        $stmt->execute(array(':teacher_id' => $teacherId, ':name' => $name));

        $id = $db->lastInsertId();
        $teacher->createClassroom($id, $name);
    } catch (PDOException $e) {
        echo "Teacher $teacherId could not create classroom $name: " . $e->getMessage();
    }
}

function addItemToClassroom(Teacher $teacher, Classroom $classroom, string $title): void
{
    $teacherId = $teacher->getId();
    $classroomId = $classroom->getId();
    try {
        $stmt = $db->prepare("INSERT INTO items (classroom_id, teacher_id, title) VALUES (:classroom_id, :teacher_id, :title)");
        $stmt->execute(array(':classroom_id' => $classroomId, ':teacher_id' => $teacherId, ':title' => $title));

        $id = $db->lastInsertId();
        $teacher->addItemToClassroom($id,  $classroom, $title);
    } catch (PDOException $e) {
        echo "Teacher $teacherId could not create classroom $name: " . $e->getMessage();
    }
}

function registerStudentToClassroom(Classroom $classroom, Student $student): void
{
    $classroomId = $classroom->getId();
    $teacherId = $classroom->getTeacherId();
    $studentId = $student->getId();
    
    try {
        $stmt = $db->prepare("INSERT INTO classrooms_have_students (classroom_id, teacher_id, student_id) VALUES (:classroom_id, :teacher_id, :student_id)");
        $stmt->execute(array(':classroom_id' => $classroomId, ':teacher_id' => $teacherId, ':student_id' => $studentId));

        $student->registerToClassroom($classroom);
    } catch (PDOException $e) {
        echo "Could not register student $studentId to classroom $classroomId: " . $e->getMessage();
    }
}
?>