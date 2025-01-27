/**
 * Fetch upcoming events with their images
 */
function getAllEvents($limit = 9) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("
            SELECT *
            FROM Events
            WHERE EventID BETWEEN 1 AND 9
            ORDER BY EventDate ASC
            LIMIT :limit
        ");
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        error_log("Error fetching events: " . $e->getMessage());
        return [];
    }
} 