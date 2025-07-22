#!/bin/env php
<?php

// Define the directories to search in
$directories = [
    'd:\\PC\\Downloads\\FinalAssignment_2123110235_TranBichLien\\app\\Http\\Controllers\\Admin',
    'd:\\PC\\Downloads\\FinalAssignment_2123110235_TranBichLien\\resources\\views\\admin'
];

// Define the route prefixes to be replaced
$routePrefixes = [
    'categories' => 'admin.categories',
    'brands' => 'admin.brands',
    'products' => 'admin.products',
    'users' => 'admin.users',
    'customers' => 'admin.customers',
    'orders' => 'admin.orders',
    'banners' => 'admin.banners',
    'order-items' => 'admin.order-items'
];

// Function to recursively search files in a directory
function searchFiles($directory, &$files)
{
    $items = scandir($directory);

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $path = $directory . DIRECTORY_SEPARATOR . $item;

        if (is_dir($path)) {
            searchFiles($path, $files);
        } else if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $files[] = $path;
        }
    }
}

// Get all PHP files
$files = [];
foreach ($directories as $directory) {
    searchFiles($directory, $files);
}

// Process each file
foreach ($files as $file) {
    $content = file_get_contents($file);
    $modified = false;

    foreach ($routePrefixes as $oldPrefix => $newPrefix) {
        // Replace route calls
        $pattern = '/route\(\'' . preg_quote($oldPrefix, '/') . '\./';
        $replacement = 'route(\'' . $newPrefix . '.';
        $newContent = preg_replace($pattern, $replacement, $content);

        if ($newContent !== $content) {
            $content = $newContent;
            $modified = true;
        }
    }

    // Save the file if modified
    if ($modified) {
        file_put_contents($file, $content);
        echo "Updated: $file\n";
    }
}

echo "Done!\n";
