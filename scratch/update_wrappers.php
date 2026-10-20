<?php
$services = [
    'cybercrime-victim-assistance-account-recovery' => 'Cybercrime Victim Assistance & Account Recovery',
    'digital-investigations-osint' => 'Digital Investigations & OSINT',
    'social-media-investigations-impersonation-removal' => 'Social Media Investigations & Impersonation Removal',
    'cyber-fraud-investigation-support' => 'Cyber Fraud Investigation Support',
    'digital-evidence-preservation-forensics' => 'Digital Evidence Preservation & Forensics',
    'executive-family-digital-protection' => 'Executive & Family Digital Protection',
    'cybersecurity-awareness-lea-training' => 'Cybersecurity Awareness & LEA Training',
    'child-digital-safety-protection' => 'Child Digital Safety & Protection',
];

foreach ($services as $slug => $title) {
    $filePath = __DIR__ . '/../services/' . $slug . '.php';
    $code = "<?php\n/**\n * {$title}\n * Cyber Kovai Digital Investigation & Forensics Services\n */\n\$serviceSlug = '{$slug}';\n\$activeSection = 'forensics';\nrequire_once __DIR__ . '/../service.php';\n";
    file_put_contents($filePath, $code);
    echo "Updated $slug.php\n";
}
echo "All 8 service wrappers updated!\n";
