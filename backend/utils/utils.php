<?php
declare(strict_types=1);
require_once "database.php";
require_once "../models/User.php";
require_once "../models/Teacher.php";
require_once "../models/Student.php";
require_once "../models/Classroom.php";
require_once "../models/Item.php";


function teacherCreateClassroom(Teacher $teacher): void
{
    $teacherId = $teacher->getId();
    try {
        $stmt = $db->prepare("INSERT INTO classrooms (teacher_id) VALUES (:teacher_id)");
        $stmt->execute(array(':teacher_id' => $teacherId));

        $id = $db->lastInsertId();
        $teacher->createClassroom($id);
    } catch (PDOException $e) {
        echo "Teacher $teacherId could not create classroom: " . $e->getMessage();
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