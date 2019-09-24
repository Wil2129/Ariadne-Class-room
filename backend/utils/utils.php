<?php
declare(strict_types=1);
require_once "database.php";
require_once "../models/Student.php";
require_once "../models/Classroom.php";

function registerStudentToClassroom(Student $student, Classroom $classroom): void
{
    $studentId = $student->getId();
    $classroomId = $classroom->getId();
    $teacherId = $classroom->getTeacherId();
    
    try {
        $stmt = $db->prepare("INSERT INTO class_has_students (student_id, class_id, teacher_id) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $studentId);
        $stmt->bindParam(2, $classroomId);
        $stmt->bindParam(3, $teacherId);
        $stmt->execute();

        $student->registerToClassroom($classroom);
    } catch (PDOException $e) {
        echo "Could not register student $studentId to classroom $classroomId" . $e->getMessage();
    }
}
?>