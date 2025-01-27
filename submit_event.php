<?php
require_once 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $data = [
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'location' => $_POST['location'] ?? '',
        'event_date' => $_POST['event_date'] ?? null,
        'max_attendees' => $_POST['max_attendees'] ?? null,
        'registration_deadline' => $_POST['registration_deadline'] ?? null,
        'status' => 'upcoming'
    ];

    $conn->beginTransaction();

    // Handle single image upload
    if (!empty($_FILES['event_image']) && $_FILES['event_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/events/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($_FILES['event_image']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['event_image']['tmp_name'], $targetPath)) {
            $data['image_url'] = $targetPath;
        }
    }

    // Insert event
    $stmt = $conn->prepare("
        INSERT INTO Events (
            Title, Description, Location, EventDate, 
            MaxAttendees, RegistrationDeadline, Status, ImageURL
        ) VALUES (
            :title, :description, :location, :event_date,
            :max_attendees, :registration_deadline, :status, :image_url
        )
    ");

    $stmt->execute($data);
    $eventId = $conn->lastInsertId();

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Event submitted successfully']);

} catch (PDOException $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
} 