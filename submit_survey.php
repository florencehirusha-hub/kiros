<?php
header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['student_id']) || !isset($data['answers'])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request data."
    ]);
    exit;
}

$student_id = (int)$data['student_id'];
$answers = $data['answers'];

if ($student_id <= 0 || empty($answers)) {
    echo json_encode([
        "success" => false,
        "message" => "Missing student ID or answers."
    ]);
    exit;
}

try {
    $pdo->beginTransaction();

    $deleteStmt = $pdo->prepare("DELETE FROM survey_responses WHERE student_id = ?");
    $deleteStmt->execute([$student_id]);

    $questionStmt = $pdo->prepare("SELECT id, question_type FROM questions WHERE id = ?");
    $optionStmt = $pdo->prepare("SELECT id FROM question_options WHERE question_id = ? AND option_text = ?");
    $insertStmt = $pdo->prepare("
        INSERT INTO survey_responses (student_id, question_id, option_id, answer_text, answer_numeric)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($answers as $question_id => $value) {
        $question_id = (int)$question_id;

        $questionStmt->execute([$question_id]);
        $question = $questionStmt->fetch(PDO::FETCH_ASSOC);

        if (!$question) {
            continue;
        }

        $type = $question['question_type'];
        $option_id = null;
        $answer_text = null;
        $answer_numeric = null;

        if ($type === 'radio') {
            $optionStmt->execute([$question_id, $value]);
            $option = $optionStmt->fetch(PDO::FETCH_ASSOC);
            if ($option) {
                $option_id = (int)$option['id'];
            }
            $answer_text = $value;
        } elseif ($type === 'scale') {
            $answer_numeric = (int)$value;
        } elseif ($type === 'text' || $type === 'textarea') {
            $answer_text = trim($value);
        }

        $insertStmt->execute([$student_id, $question_id, $option_id, $answer_text, $answer_numeric]);
    }

    $scores = [
        'technology' => 0,
        'business' => 0,
        'creative' => 0,
        'science' => 0,
        'social' => 0,
        'leadership' => 0,
        'practical' => 0
    ];

    $catStmt = $pdo->query("SELECT id, category_code FROM career_categories");
    $categoryMap = [];
    while ($row = $catStmt->fetch(PDO::FETCH_ASSOC)) {
        $categoryMap[$row['id']] = $row['category_code'];
    }

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
            $scores[$categoryCode] += (int)$row['score'];
        }
    }

    $scaleStmt = $pdo->prepare("
        SELECT question_id, answer_numeric
        FROM survey_responses
        WHERE student_id = ? AND answer_numeric IS NOT NULL
    ");
    $scaleStmt->execute([$student_id]);

    while ($row = $scaleStmt->fetch(PDO::FETCH_ASSOC)) {
        $question_id = (int)$row['question_id'];
        $value = (int)$row['answer_numeric'];

        if ($question_id === 7) {
            $scores['technology'] += $value;
            $scores['science'] += $value;
        }

        if ($question_id === 9) {
            $scores['technology'] += $value;
        }

        if ($question_id === 11) {
            $scores['leadership'] += $value;
            $scores['practical'] += $value;
        }

        if ($question_id === 22) {
            $scores['social'] += $value;
        }
    }

    $textStmt = $pdo->prepare("
        SELECT answer_text
        FROM survey_responses
        WHERE student_id = ? AND answer_text IS NOT NULL
    ");
    $textStmt->execute([$student_id]);

    while ($row = $textStmt->fetch(PDO::FETCH_ASSOC)) {
        $text = strtolower($row['answer_text']);

        if (preg_match('/computer|software|coding|programming|it|technology|ai|data|cyber/', $text)) {
            $scores['technology'] += 3;
        }
        if (preg_match('/business|marketing|finance|sales|money|entrepreneur|management/', $text)) {
            $scores['business'] += 3;
        }
        if (preg_match('/design|drawing|art|music|creative|photography|video/', $text)) {
            $scores['creative'] += 3;
        }
        if (preg_match('/science|research|lab|doctor|engineering|physics|chemistry|biology/', $text)) {
            $scores['science'] += 3;
        }
        if (preg_match('/help|teacher|counsel|community|society|care|guide/', $text)) {
            $scores['social'] += 3;
        }
        if (preg_match('/leader|leadership|manage|captain|organize|direct/', $text)) {
            $scores['leadership'] += 3;
        }
        if (preg_match('/repair|machine|technical|practical|hands-on|mechanic|build/', $text)) {
            $scores['practical'] += 3;
        }
    }

    $deleteScores = $pdo->prepare("DELETE FROM student_category_scores WHERE student_id = ?");
    $deleteScores->execute([$student_id]);

    $insertScore = $pdo->prepare("
        INSERT INTO student_category_scores (student_id, category_id, total_score)
        VALUES (?, ?, ?)
    ");

    foreach ($categoryMap as $category_id => $category_code) {
        $insertScore->execute([$student_id, $category_id, $scores[$category_code] ?? 0]);
    }

    $careerStmt = $pdo->query("SELECT id, career_name, description FROM careers");
    $careerResults = [];

    while ($career = $careerStmt->fetch(PDO::FETCH_ASSOC)) {
        $career_id = (int)$career['id'];

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
            $required = (int)$profile['required_score'];
            $studentValue = $scores[$categoryCode] ?? 0;

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

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Survey submitted and analyzed successfully.",
        "category_scores" => $scores,
        "recommendations" => array_slice($careerResults, 0, 5)
    ]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        "success" => false,
        "message" => "Server error: " . $e->getMessage()
    ]);
}
?>