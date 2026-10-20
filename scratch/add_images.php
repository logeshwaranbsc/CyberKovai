<?php
$file = __DIR__ . '/../services-data.php';
$content = file_get_contents($file);

$map = [
    'cybercrime-victim-assistance-account-recovery' => 'assets/images/investigation_01_victim_recovery.jpg',
    'digital-investigations-osint' => 'assets/images/investigation_02_osint.jpg',
    'social-media-investigations-impersonation-removal' => 'assets/images/investigation_03_social_media.jpg',
    'cyber-fraud-investigation-support' => 'assets/images/investigation_04_fraud_support.jpg',
    'digital-evidence-preservation-forensics' => 'assets/images/investigation_05_digital_forensics.jpg',
    'executive-family-digital-protection' => 'assets/images/investigation_06_executive_family.jpg',
    'cybersecurity-awareness-lea-training' => 'assets/images/investigation_07_lea_training.jpg',
    'child-digital-safety-protection' => 'assets/images/investigation_08_child_safety.jpg',
];

foreach ($map as $slug => $img) {
    $search = "'slug' => '{$slug}',";
    $replace = "'slug' => '{$slug}',\n        'image' => '{$img}',";
    if (strpos($content, $search) !== false && strpos($content, "'image' => '{$img}'") === false) {
        $content = str_replace($search, $replace, $content);
        echo "Added image for $slug\n";
    }
}

file_put_contents($file, $content);
echo "Done!\n";
