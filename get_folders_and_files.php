<?php
header('Content-Type: application/json');

// 親フォルダのパス
$parentFolder = './webdav'; // サーバー上の親フォルダ
$baseUrl = 'https://mizuuchi.lab.tuat.ac.jp/~ryunosuke/webdav'; // 実際の公開URL

function getFoldersAndFiles($parentFolder, $baseUrl) {
    $folders = [];
    if (!is_dir($parentFolder)) {
        return $folders;
    }

    // 親フォルダ内のサブフォルダを取得
    $subFolders = array_filter(glob($parentFolder . '/*'), 'is_dir');
    foreach ($subFolders as $subFolder) {
        $folderName = basename($subFolder);

        // 各サブフォルダ内の画像ファイルを取得
        $images = array_filter(glob($subFolder . '/captured_views_*/*.{jpg,jpeg,png,gif}', GLOB_BRACE), 'is_file');

        // URLを生成
        $folders[$folderName] = array_map(function ($path) use ($baseUrl, $parentFolder) {
            // $parentFolder を取り除いた相対パスを生成
            $relativePath = str_replace($parentFolder . '/', '', $path);

            // ベースURLと相対パスを結合
            return $baseUrl . '/' . $relativePath;
        }, $images);
    }
    return $folders;
}

// フォルダとファイル情報を取得し、JSONで出力
echo json_encode(getFoldersAndFiles($parentFolder, $baseUrl), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
