<?php
$results_file = 'experiment_results.json';

// POSTデータを取得
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => '無効なデータ']);
    exit;
}

// 既存データを読み込む
$existing_data = [];
if (file_exists($results_file)) {
    $json = file_get_contents($results_file);
    $existing_data = json_decode($json, true) ?: [];
}

// 新しいデータを追加
$existing_data[] = $data;

// JSONファイルに保存
if (file_put_contents($results_file, json_encode($existing_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'データ保存に失敗しました']);
}
?>