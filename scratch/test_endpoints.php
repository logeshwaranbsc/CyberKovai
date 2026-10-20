<?php
$slugs = [
    'cybercrime-victim-assistance-account-recovery',
    'digital-investigations-osint',
    'social-media-investigations-impersonation-removal',
    'cyber-fraud-investigation-support',
    'digital-evidence-preservation-forensics',
    'executive-family-digital-protection',
    'cybersecurity-awareness-lea-training',
    'child-digital-safety-protection'
];

foreach ($slugs as $s) {
    $html = @file_get_contents('http://localhost:8000/services/' . $s . '.php');
    $hasImg = (strpos($html, 'svc-hero-preview-img') !== false) ? 'YES' : 'NO';
    $title = preg_match('/<title>(.*?)<\/title>/', $html, $m) ? $m[1] : 'NOT FOUND';
    $faqCount = substr_count($html, 'ci-faq-item');
    $featCount = substr_count($html, 'svc-feature-card');
    echo "$s => Img: $hasImg | Feats: $featCount | FAQs: $faqCount | Title: $title\n";
}
