<?php
require_once 'connect.php';

$dbConn = getDbConnection();

try {
    // 开始事务
    $dbConn->begin_transaction();

    // 插入课程
    $courses = ['Math', 'English', 'Physics'];
    $courseStmt = $dbConn->prepare("INSERT INTO Courses (description) VALUES (?)");

    foreach ($courses as $course) {
        $courseStmt->bind_param('s', $course);
        $courseStmt->execute();
    }

    // 插入用户
    $users = [];
    for ($i = 1; $i <= 20; $i++) {
        $users[] = [
            'first_name' => 'FirstName' . $i,
            'surname' => 'Surname' . $i
        ];
    }
    $userStmt = $dbConn->prepare("INSERT INTO Users (first_name, surname) VALUES (?, ?)");

    foreach ($users as $user) {
        $userStmt->bind_param('ss', $user['first_name'], $user['surname']);
        $userStmt->execute();
    }

    // 获取课程 ID 和用户 ID
    $courseIds = [];
    $courseResult = $dbConn->query("SELECT course_id FROM Courses");
    while ($row = $courseResult->fetch_assoc()) {
        $courseIds[] = $row['course_id'];
    }

    $userIds = [];
    $userResult = $dbConn->query("SELECT user_id FROM Users");
    while ($row = $userResult->fetch_assoc()) {
        $userIds[] = $row['user_id'];
    }

    $Enrolmentstmt = $dbConn->prepare("INSERT INTO Enrolments (user_id, course_id, completion_status) VALUES (?, ?, ?)");

    $enrollmentCount = 0;
    while ($enrollmentCount < 100) {
        $userId = $userIds[array_rand($userIds)];
        $courseId = $courseIds[array_rand($courseIds)];
        $completionStatus = ['not_started', 'in_progress', 'completed'][array_rand(['not_started', 'in_progress', 'completed'])];

        // 插入注册记录
        $Enrolmentstmt->bind_param('iis', $userId, $courseId, $completionStatus);
        $Enrolmentstmt->execute();

        $enrollmentCount++;
    }

    // 提交事务
    $dbConn->commit();

    echo "Seed data inserted successfully.";

} catch (Exception $e) {

    $dbConn->rollback();
    echo "Error inserting seed data: " . $e->getMessage();
}

// 关闭数据库连接
$dbConn->close();
?>
