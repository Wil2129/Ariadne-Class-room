<?php
declare(strict_types=1);
require_once "database.php";
require_once "../models/Student.php";
require_once "../models/Classroom.php";

function registerStudentToClassroom(Classroom $classroom, Student $student): void
{
    $classroomId = $classroom->getId();
    $teacherId = $classroom->getTeacherId();
    $studentId = $student->getId();
    
    try {
        $stmt = $db->prepare("INSERT INTO classrooms_have_students (classroom_id, teacher_id, student_id) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $classroomId);
        $stmt->bindParam(2, $teacherId);
        $stmt->bindParam(3, $studentId);
        $stmt->execute();

        $student->registerToClassroom($classroom);
    } catch (PDOException $e) {
        echo "Could not register student $studentId to classroom $classroomId: " . $e->getMessage();
    }
}
?>