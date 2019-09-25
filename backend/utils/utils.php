<?php
declare(strict_types=1);
require_once "database.php";
require_once "../models/User.php";
require_once "../models/Teacher.php";
require_once "../models/Student.php";
require_once "../models/Classroom.php";
require_once "../models/Item.php";


function createClassroom(Teacher $teacher, string $name, string $description = NULL): void
{
    $teacherId = $teacher->getId();
    try {
        $stmt = $db->prepare("INSERT INTO classrooms (teacher_id, name, description) VALUES (:teacher_id, :name, :description)");
        $stmt->execute(array(':teacher_id' => $teacherId, ':name' => $name, ':description' => $description));

        $id = $db->lastInsertId();
        $teacher->createClassroom($id, $name, $description);
    } catch (PDOException $e) {
        echo "Teacher $teacherId could not create classroom $name: " . $e->getMessage();
    }
}

function addItemToClassroom(Teacher $teacher, Classroom $classroom, string $title, string $content = NULL, string $filesUrl = NULL): void
{
    $teacherId = $teacher->getId();
    $classroomId = $classroom->getId();
    try {
        $stmt = $db->prepare("INSERT INTO items (classroom_id, teacher_id, title, content, files_url) VALUES (:classroom_id, :teacher_id, :title, :content, :files_url)");
        $stmt->execute(array(':classroom_id' => $classroomId, ':teacher_id' => $teacherId, ':title' => $title, ':content' => $content, ':files_url' => $filesUrl));

        $id = $db->lastInsertId();
        $teacher->addItemToClassroom($id,  $classroom, $title, $content, $filesUrl);
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