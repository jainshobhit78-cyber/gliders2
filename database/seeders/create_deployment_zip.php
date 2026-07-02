<?php

$zipFile = 'C:\Users\ojasv\OneDrive\Desktop\GlidersCode_Deployment.zip';
$sourceDir = 'C:\Users\ojasv\OneDrive\Desktop\GlidersCode';

$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    die("Cannot open <$zipFile>\n");
}

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($files as $name => $file) {
    if ($file->isDir()) {
        continue;
    }

    $filePath = $file->getRealPath();
    $relativePath = substr($filePath, strlen($sourceDir) + 1);

    // Skip node_modules, .git, and temporary cache folders
    if (
        strpos($relativePath, 'node_modules') === 0 || 
        strpos($relativePath, '.git') === 0 || 
        strpos($relativePath, 'storage\\framework\\cache') === 0 ||
        strpos($relativePath, 'storage\\framework\\sessions') === 0 ||
        strpos($relativePath, 'storage\\framework\\views') === 0 ||
        strpos($relativePath, 'bootstrap\\cache') === 0 ||
        $relativePath === 'database\\database.sqlite'
    ) {
        continue;
    }

    // Replace backslashes with forward slashes for zip compatibility
    $zipPath = str_replace('\\', '/', $relativePath);
    $zip->addFile($filePath, $zipPath);
}

$zip->close();
echo "Zip created successfully at: $zipFile\n";
