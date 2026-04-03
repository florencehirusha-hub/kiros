<?php
require 'db.php';

$student_id = isset($_GET['student_id']) ? (int) $_GET['student_id'] : 0;

if ($student_id <= 0) {
    die("Invalid student ID.");
}

// category_code => score
$scores = [
    'technology' => 0,
    'business' => 0,
    'creative' => 0,
    'science' => 0,
    'social' => 0,
    'leadership' => 0,
    'practical' => 0
];

try {
    // Fetch category id map
    $catStmt = $pdo->query("SELECT id, category_code FROM career_categories");
    $categoryMap = [];
    while ($row = $catStmt->fetch(PDO::FETCH_ASSOC)) {
        $categoryMap[$row['id']] = $row['category_code'];
    }

    // 1. Analyze radio answers using option_score_map
    $radioStmt = $pdo->prepare("
        SELECT osm.category_id, osm.score
        FROM survey_responses sr
        JOIN option_score_map osm ON sr.option_id = osm.option_id
        WHERE sr.student_id = ?
    ");
    $radioStmt->execute([$student_id]);

    while ($row = $radioStmt->fetch(PDO::FETCH_ASSOC)) {
        $categoryCode = $categoryMap[$row['category_id']] ?? null;
        if ($categoryCode) {
            $scores[$categoryCode] += (int) $row['score'];
        }
    }

    // 2. Analyze scale questions
    $scaleStmt = $pdo->prepare("
        SELECT question_id, answer_numeric
        FROM survey_responses
        WHERE student_id = ? AND answer_numeric IS NOT NULL
    ");
    $scaleStmt->execute([$student_id]);

    while ($row = $scaleStmt->fetch(PDO::FETCH_ASSOC)) {
        $question_id = (int) $row['question_id'];
        $value = (int) $row['answer_numeric'];

        // Example custom rules by question
        if ($question_id === 7) { // confidence in solving difficult problems
            $scores['technology'] += $value;
            $scores['science'] += $value;
        }

        if ($question_id === 9) { // working with technology
            $scores['technology'] += $value;
        }

        if ($question_id === 11) { // handling challenges
            $scores['leadership'] += $value;
            $scores['practical'] += $value;
        }

        if ($question_id === 22) { // work-life balance
            $scores['social'] += $value;
        }
    }

    // 3. Analyze text answers using keyword matching
    $textStmt = $pdo->prepare("
        SELECT answer_text
        FROM survey_responses
        WHERE student_id = ? AND answer_text IS NOT NULL
    ");
    $textStmt->execute([$student_id]);

    while ($row = $textStmt->fetch(PDO::FETCH_ASSOC)) {
        $text = strtolower($row['answer_text']);

        // Technology keywords
        if (preg_match('/computer|software|coding|programming|it|technology|ai|data|cyber/', $text)) {
            $scores['technology'] += 3;
        }

        // Business keywords
        if (preg_match('/business|marketing|finance|sales|money|entrepreneur|management/', $text)) {
            $scores['business'] += 3;
        }

        // Creative keywords
        if (preg_match('/design|drawing|art|music|creative|photography|video/', $text)) {
            $scores['creative'] += 3;
        }

        // Science keywords
        if (preg_match('/science|research|lab|doctor|engineering|physics|chemistry|biology/', $text)) {
            $scores['science'] += 3;
        }

        // Social keywords
        if (preg_match('/help|teacher|counsel|community|society|care|guide/', $text)) {
            $scores['social'] += 3;
        }

        // Leadership keywords
        if (preg_match('/leader|leadership|manage|captain|organize|direct/', $text)) {
            $scores['leadership'] += 3;
        }

        // Practical keywords
        if (preg_match('/repair|machine|technical|practical|hands-on|mechanic|build/', $text)) {
            $scores['practical'] += 3;
        }
    }

    // 4. Save scores to student_category_scores
    $pdo->beginTransaction();

    $deleteOld = $pdo->prepare("DELETE FROM student_category_scores WHERE student_id = ?");
    $deleteOld->execute([$student_id]);

    $insertScore = $pdo->prepare("
        INSERT INTO student_category_scores (student_id, category_id, total_score)
        VALUES (?, ?, ?)
    ");

    foreach ($categoryMap as $category_id => $category_code) {
        $insertScore->execute([$student_id, $category_id, $scores[$category_code]]);
    }

    $pdo->commit();

    echo "<pre>";
    print_r($scores);
    echo "</pre>";

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die("Analysis error: " . $e->getMessage());
}
?>