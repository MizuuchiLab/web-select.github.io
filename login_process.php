<?php
$storage_file = 'user_data.json'; // 保存されたユーザーデータファイル

// 入力データを取得
$userId = $_POST['userId'] ?? '';
$password = $_POST['password'] ?? '';

// データが入力されていない場合
if (empty($userId) || empty($password)) {
    echo '<p class="error">IDまたはパスワードを入力してください。</p>';
    exit;
}

// 保存されたユーザーデータを読み込む
if (!file_exists($storage_file)) {
    echo '<p class="error">ユーザーデータが見つかりません。</p>';
    exit;
}

$existingData = json_decode(file_get_contents($storage_file), true);

// ユーザーが存在するか確認
if (!array_key_exists($userId, $existingData)) {
    echo '<p class="error">ユーザーIDが見つかりません。</p>';
    exit;
}

// パスワードを検証
$storedPassword = $existingData[$userId]['password'];
if (password_verify($password, $storedPassword)) {
    // 認証成功時
    header('Location: experimentPage.html');
    exit;
} else {
    // 認証失敗時
    echo '<p class="error">パスワードが間違っています。</p>';
    exit;
}
?>
