<?php
$storage_file = 'user_data.json'; // ローカルに保存するJSONファイル

// ランダムIDを生成する関数
function generateRandomId($length = 8) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    return substr(str_shuffle(str_repeat($chars, $length)), 0, $length);
}

// 既存データを読み込む
$existingData = [];
if (file_exists($storage_file)) {
    $json = file_get_contents($storage_file);
    $existingData = json_decode($json, true);
}

// IDを生成して重複を確認
do {
    $newId = generateRandomId();
} while (array_key_exists($newId, $existingData));

// 結果を返す
header('Content-Type: application/json');
echo json_encode(['success' => true, 'userId' => $newId]);
exit;
?>