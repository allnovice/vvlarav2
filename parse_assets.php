<?php

$file = __DIR__ . '/cmms.sql';
$sql = file_get_contents($file);

preg_match('/INSERT INTO\s+`assets`.*?VALUES\s*(.*);/is', $sql, $matches);

$values = trim($matches[1]);
$rows = preg_split('/\),\s*\(/', trim($values, "()"));

$out = fopen(__DIR__ . '/migration.sql', 'w');

foreach ($rows as $row) {

    $cols = str_getcsv($row, ',', "'");

    // Desktop only
if (($cols[2] ?? '') !== 'Desktop' || ($cols[8] ?? '') !== 'HP') {
    continue;
}

    $description = str_replace('\r\n', ' ', $cols[3]);

    preg_match_all(
        '/(.*?)(20\d{2}-1060-5030-[A-Z0-9-]+)/',
        $description,
        $parts,
        PREG_SET_ORDER
    );

$updateParent = sprintf(
    "UPDATE assets
SET type = 'Monitor'
WHERE property_number = '%s'
  AND type = 'Desktop';\n",
    addslashes($cols[1])
);

fwrite($out, $updateParent);


    foreach ($parts as $part) {

$component = trim($part[1]);
$component = str_replace(['\"', '"'], '', $component);

$property = trim($part[2]);

        // Skip the asset that already exists
        if ($property === $cols[1]) {
            continue;
        }

        preg_match('/^([^,]+)/', $component, $m);
        $type = trim($m[1] ?? '');

        preg_match('/,\s*(.*?)\s*(?:Sn#|$)/i', $component, $m);
        $brand = trim($m[1] ?? '');

        preg_match('/Sn#\s*(.+)$/i', $component, $m);
        $serial = trim($m[1] ?? '');

        $model = $type === 'CPU' ? $cols[9] : '';
        $manufacturer = $brand ?: $cols[11];

        $insert = sprintf(
            "INSERT IGNORE INTO assets (property_number,type,description,status,brand,model,serial_number,manufacturer,assigned_to,location,department,created_at,updated_at) VALUES ('%s','%s','','Active','%s','%s','%s','%s','%s','%s','%s',NOW(),NOW());\n",
            addslashes($property),
            addslashes($type),
            addslashes($brand),
            addslashes($model),
            addslashes($serial),
            addslashes($manufacturer),
            addslashes($cols[12]),
            addslashes($cols[13]),
            addslashes($cols[14])
        );

        fwrite($out, $insert);

        $update = sprintf(
            "UPDATE assets child
        JOIN assets parent
            ON parent.property_number = '%s'
        SET child.parent_asset_id = parent.id
        WHERE child.property_number = '%s';\n",
            addslashes($cols[1]),   // Parent (Desktop)
            addslashes($property)   // Child (CPU, Monitor, etc.)
        );

        fwrite($out, $update);


    }
}

fclose($out);

echo "migration.sql generated.\n";
