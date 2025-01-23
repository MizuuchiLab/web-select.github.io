<?php
$storage_file = 'user_data.json'; // データ保存先
$password = $_POST['password'];
$userId = $_POST['userId'];

// 入力値のチェック
if (empty($userId) || empty($password)) {
    echo 'ユーザーIDまたはパスワードが空です。';
    exit;
}

// パスワードをハッシュ化
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// ユーザーデータを保存する配列
$newUser = [
    'userId' => $userId,
    'password' => $hashedPassword,
    'nationality' => $_POST['nationality'] ?? '',
    'gender' => $_POST['gender'] ?? '',
    'age' => $_POST['age'] ?? ''
];

// 既存データを読み込む
$existingData = [];
if (file_exists($storage_file)) {
    $json = file_get_contents($storage_file);
    $existingData = json_decode($json, true) ?: [];
}

// 新しいユーザーを追加
$existingData[$userId] = $newUser;

// データを保存
if (file_put_contents($storage_file, json_encode($existingData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    // 登録成功後のページにリダイレクト
    header('Location: experimentPage.html');
    exit;
} else {
    echo 'データの保存に失敗しました。';
    exit;
}
?>