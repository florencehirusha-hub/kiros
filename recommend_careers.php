<?php
require 'db.php';

$student_id = isset($_GET['student_id']) ? (int) $_GET['student_id'] : 0;

if ($student_id <= 0) {
    die("Invalid student ID.");
}

try {
    // Get student scores
    $stmt = $pdo->prepare("
        SELECT c.category_code, scs.total_score
        FROM student_category_scores scs
        JOIN career_categories c ON scs.category_id = c.id
        WHERE scs.student_id = ?
    ");
    $stmt->execute([$student_id]);

    $studentScores = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $studentScores[$row['category_code']] = (int) $row['total_score'];
    }

    // Get all careers
    $careerStmt = $pdo->query("SELECT id, career_name, description FROM careers");
    $careerResults = [];

    while ($career = $careerStmt->fetch(PDO::FETCH_ASSOC)) {
        $career_id = (int) $career['id'];

        $profileStmt = $pdo->prepare("
            SELECT cc.category_code, ccp.required_score
            FROM career_category_profile ccp
            JOIN career_categories cc ON ccp.category_id = cc.id
            WHERE ccp.career_id = ?
        ");
        $profileStmt->execute([$career_id]);

        $totalRequired = 0;
        $matched = 0;

        while ($profile = $profileStmt->fetch(PDO::FETCH_ASSOC)) {
            $categoryCode = $profile['category_code'];
            $required = (int) $profile['required_score'];
            $studentValue = $studentScores[$categoryCode] ?? 0;

            $totalRequired += $required;
            $matched += min($studentValue, $required);
        }

        $matchPercent = $totalRequired > 0 ? round(($matched / $totalRequired) * 100, 2) : 0;

        $careerResults[] = [
            'career_name' => $career['career_name'],
            'description' => $career['description'],
            'match_percent' => $matchPercent
        ];
    }

    usort($careerResults, function ($a, $b) {
        return $b['match_percent'] <=> $a['match_percent'];
    });

    echo "<h2>Top Career Recommendations</h2>";
    echo "<ol>";
    foreach (array_slice($careerResults, 0, 5) as $career) {
        echo "<li>";
        echo "<strong>" . htmlspecialchars($career['career_name']) . "</strong> - ";
        echo $career['match_percent'] . "% match<br>";
        echo htmlspecialchars($career['description']);
        echo "</li><br>";
    }
    echo "</ol>";

} catch (Exception $e) {
    die("Recommendation error: " . $e->getMessage());
}
?>