<?php
/**
 * Script to safely add 8 Digital Investigation services to services-data.php
 */

$dataFile = __DIR__ . '/../services-data.php';
require_once $dataFile;

$newServices = [
    'cybercrime-victim-assistance-account-recovery' => [
        'title' => 'Cybercrime Victim Assistance & Account Recovery',
        'nav_label' => 'Cybercrime Victim Assistance & Account Recovery',
        'category' => 'digital-investigations',
        'badge' => 'INCIDENT TRIAGE & RECOVERY',
        'tagline' => 'Emergency response, evidence preservation, and verified recovery for hacked accounts and cyber extortion.',
        'short_desc' => 'Forensic assistance for individuals, executives, and organizations affected by account takeovers, SIM swapping, extortion, phishing, and online identity theft.',
        'overview' => 'Cybercrime victimization can be traumatic, legally complex, and financially devastating. Our Cybercrime Victim Assistance & Account Recovery service provides immediate, discreet emergency response for individuals, public figures, and business leaders whose social media, email, banking, or cloud accounts have been compromised. We conduct forensic digital artifact preservation to capture attacker IP addresses, session token hijack traces, and unauthorized recovery phone/email alterations. Working in accordance with platform security escalation protocols and Indian cyber law (IT Act 2000 Section 43/66), we guide victims through evidence preservation, platform escalation, law enforcement complaint filing (National Cyber Crime Reporting Portal cybercrime.gov.in), and permanent account security re-fortification.',
        'why_needed' => 'Standard platform recovery forms are often automated, delayed, or manipulated by sophisticated hackers who lock out the rightful owner with 2FA bypass and recovery code replacements. Professional intervention ensures critical digital evidence is legally preserved before log rotation, preventing reputational extortion and secondary fraudulent transactions.',
        'key_features' => [
            [
                'title' => 'Emergency Incident Triage',
                'desc' => 'Immediate session termination, device isolation, and forensic snapshotting across compromised platforms.'
            ],
            [
                'title' => 'Forensic Session Hijack Tracing',
                'desc' => 'Analyzing cookie theft, OAuth token abuse, and credential stuffing vectors to establish the breach origin.'
            ],
            [
                'title' => 'Official Platform Escalation',
                'desc' => 'Structured legal escalations with Meta, Google, Microsoft, Apple, and X Trust & Safety enterprise teams.'
            ],
            [
                'title' => 'Cyber Extortion & Blackmail Defense',
                'desc' => 'Advisory and evidence packaging for sextortion, ransomware, and coercive threat actors.'
            ],
            [
                'title' => 'Law Enforcement Ready Dossier',
                'desc' => 'Preparing FIR-compliant evidence compliant with Section 65B of the Indian Evidence Act.'
            ],
            [
                'title' => 'Post-Recovery Hardening',
                'desc' => 'Hardware security keys (FIDO2/WebAuthn) setup, credential rotation, and device sanitization.'
            ]
        ],
        'methodology' => [
            [
                'step' => '01',
                'title' => 'Emergency Containment & Scoping',
                'desc' => 'Halting attacker access, isolating connected systems, and cataloging all compromised recovery vectors.'
            ],
            [
                'step' => '02',
                'title' => 'Digital Evidence Preservation',
                'desc' => 'Extracting immutable email headers, login IPs, and session tokens under ISO 27037 chain-of-custody standards.'
            ],
            [
                'step' => '03',
                'title' => 'Identity Verification & Escalation',
                'desc' => 'Submitting verified legal identity documentation directly to platform security and compliance desks.'
            ],
            [
                'step' => '04',
                'title' => 'Account Reclamation & Lockout',
                'desc' => 'Re-establishing administrative ownership, revoking rogue sessions, and purging attacker recovery backdoors.'
            ],
            [
                'step' => '05',
                'title' => 'Hardening & Legal Filing Support',
                'desc' => 'Implementing zero-trust 2FA, delivering Section 65B legal certificates, and filing National Cyber Crime reports.'
            ]
        ],
        'deliverables' => [
            'Incident Response & Evidence Preservation Dossier',
            'Court-Admissible Section 65B Electronic Evidence Certificate',
            'Compromised Account Forensic Timeline & Attacker IP Trace',
            'Platform Security Escalation Log & Case Reference Manifest',
            'Post-Breach Security Hardening & Zero-Trust Re-fortification Plan'
        ],
        'compliance' => [
            'IT Act 2000 (Section 43 & 66)',
            'Indian Evidence Act Section 65B',
            'ISO/IEC 27037 Digital Evidence Standards',
            'INTERPOL Cybercrime Victim Assistance Guidelines',
            'CERT-In Incident Reporting Directives'
        ],
        'faqs' => [
            [
                'q' => 'Can you guarantee recovery of a hacked Instagram, WhatsApp, or Google account?',
                'a' => 'While no ethical firm can guarantee 100% third-party platform actions, our certified investigators utilize authorized platform enterprise channels, verifiable identity documentation, and digital forensic affidavits that maximize recovery rates compared to automated web forms.'
            ],
            [
                'q' => 'What immediate steps should I take if I am being blackmailed or extorted online?',
                'a' => 'Do not pay the extorter and do not delete any chats or emails. Take full uncropped screenshots showing phone numbers, handles, and transaction IDs. Contact our emergency team immediately so we can preserve cryptographic headers before the attacker deletes messages.'
            ],
            [
                'q' => 'Will this evidence be valid in police complaints or court proceedings?',
                'a' => 'Yes. All digital artifacts, server logs, and communications are preserved following ISO/IEC 27037 chain-of-custody standards and accompanied by Section 65B Indian Evidence Act certificates valid in Indian courts.'
            ],
            [
                'q' => 'Can you help prevent the attacker from hacking my other accounts?',
                'a' => 'Yes. We perform a full cross-account security audit, revoking rogue OAuth app permissions, auditing connected recovery methods, and configuring FIDO2 hardware security keys.'
            ]
        ]
    ],

    'digital-investigations-osint' => [
        'title' => 'Digital Investigations & OSINT',
        'nav_label' => 'Digital Investigations & OSINT',
        'category' => 'digital-investigations',
        'badge' => 'OPEN-SOURCE INTELLIGENCE & RECONNAISSANCE',
        'tagline' => 'Actionable cyber reconnaissance, deep web intelligence, and online footprint verification.',
        'short_desc' => 'Comprehensive open-source intelligence (OSINT) and cyber reconnaissance to uncover hidden assets, verify identities, unmask threat actors, and support legal litigation.',
        'overview' => 'Modern adversaries and fraudsters leave extensive digital footprints across the surface, deep, and dark web. Our Digital Investigations & OSINT practice leverages advanced intelligence-gathering methodologies, graph link analysis, public records scraping, and dark web breach intelligence to uncover facts, locate missing digital identities, verify corporate counter-parties, and profile malicious actors. Whether for high-stakes corporate due diligence, litigation support, pre-employment executive screening, or tracing anonymous smear campaigns, we transform fragmented digital data into coherent, verified intelligence dossiers.',
        'why_needed' => 'Standard search engines index less than 5% of the internet. Without specialized OSINT tooling, link analysis engines, and dark web scraping crawlers, crucial risk indicators, undeclared liabilities, pseudonymous forum activities, and breach exposures remain completely hidden from corporate and personal decision-makers.',
        'key_features' => [
            [
                'title' => 'Entity & Identity De-anonymization',
                'desc' => 'Unmasking aliases, handles, disposable phone numbers, and proxy emails back to verifiable individuals.'
            ],
            [
                'title' => 'Dark Web & Forum Infiltration',
                'desc' => 'Scanning illicit marketplaces, Pastebin dumps, and breach forums for compromised credentials and data dumps.'
            ],
            [
                'title' => 'Social Graph & Affiliation Analysis',
                'desc' => 'Visualizing organizational connections, co-conspirators, and online networks using link analysis algorithms.'
            ],
            [
                'title' => 'Asset Tracing & Due Diligence',
                'desc' => 'Discovering hidden corporate holdings, foreign registries, offshore assets, and registered domain portfolios.'
            ],
            [
                'title' => 'Geolocation & EXIF Metadata Forensics',
                'desc' => 'Verifying real-world locations from image telemetry, IP routing, wireless BSSID data, and satellite archives.'
            ],
            [
                'title' => 'Corporate Counter-Party Vetting',
                'desc' => 'Uncovering undisclosed conflicts of interest, regulatory sanctions, litigation history, and reputational liabilities.'
            ]
        ],
        'methodology' => [
            [
                'step' => '01',
                'title' => 'Scoping & Threat Modeling',
                'desc' => 'Defining target identifiers, establishing objective parameters, and setting up strict operational security.'
            ],
            [
                'step' => '02',
                'title' => 'Multi-Vector Data Harvesting',
                'desc' => 'Querying global search indices, public registries, corporate filings, social graph nodes, and dark web archives.'
            ],
            [
                'step' => '03',
                'title' => 'Normalization & Graph Link Analysis',
                'desc' => 'Synthesizing disparate data points into structured entity profiles and relationship matrices.'
            ],
            [
                'step' => '04',
                'title' => 'Hypothesis Validation & Fact Checking',
                'desc' => 'Corroborating digital leads against primary records, DNS telemetry, and real-world documentation.'
            ],
            [
                'step' => '05',
                'title' => 'Intelligence Dossier Delivery',
                'desc' => 'Producing comprehensive executive summaries, evidentiary link charts, and actionable strategic findings.'
            ]
        ],
        'deliverables' => [
            'Comprehensive OSINT Intelligence Dossier with Visual Link Graphs',
            'Digital Footprint & Threat Exposure Map',
            'De-anonymization Matrix with Corroborating Source References',
            'Dark Web Compromise & Credential Exposure Report',
            'Executive Strategic Decision-Making Summary'
        ],
        'compliance' => [
            'OSINT Framework & Bellingcat Standards',
            'ISO/IEC 27037 Evidence Handling',
            'GDPR & Digital Personal Data Protection Act (DPDP)',
            'ACPO Good Practice Guide for Digital Evidence'
        ],
        'faqs' => [
            [
                'q' => 'Is OSINT investigation legal and ethical?',
                'a' => 'Yes. Open-Source Intelligence relies strictly on publicly accessible data, deep-web databases, digital archives, and legal intelligence feeds. We never perform illegal wiretapping, hacking, or unauthorized system intrusions.'
            ],
            [
                'q' => 'How long does a thorough OSINT investigation take?',
                'a' => 'Standard background or entity OSINT audits typically take 3 to 5 business days, while complex cross-border corporate investigations or deep dark-web actor tracking can take 7 to 14 days.'
            ],
            [
                'q' => 'Can OSINT unmask anonymous cyberbullies or smear campaign coordinators?',
                'a' => 'Yes. By analyzing linguistic patterns, registration timing, reused email fragments, cryptographic hashes, and linked infrastructure, we frequently establish probable identity linkages that support legal subpoenas and police action.'
            ]
        ]
    ],

    'social-media-investigations-impersonation-removal' => [
        'title' => 'Social Media Investigations & Impersonation Removal',
        'nav_label' => 'Social Media Investigations & Impersonation Removal',
        'category' => 'digital-investigations',
        'badge' => 'BRAND DEFENSE & EXPEDITED TAKEDOWNS',
        'tagline' => 'Unmasking fake profiles, combating brand impersonation, and executing expedited platform takedowns.',
        'short_desc' => 'Forensic investigation of fake profiles, malicious brand impersonation, defamatory smear campaigns, and unauthorized intellectual property misuse across global social platforms.',
        'overview' => 'Impersonation and malicious social media campaigns can destroy hard-earned personal reputations, siphon corporate customer revenue, and facilitate financial phishing. Our Social Media Investigations & Impersonation Removal team specializes in identifying, documenting, and eliminating unauthorized copycat accounts, fake customer support channels, executive impersonations, and defamatory content across Instagram, Facebook, LinkedIn, X (Twitter), YouTube, Telegram, and TikTok. Combining forensic screenshotting with legal DMCA, trademark infringement, and platform security escalations, we deliver permanent content removal and identify the operators behind malicious accounts.',
        'why_needed' => 'Automated platform reporting forms frequently reject valid user reports with generic responses like "this account does not violate our community standards." Our investigators utilize formal trademark filings, notarized identity affidavits, and direct legal escalations that bypass automated bots and force rapid manual review by trust and safety teams.',
        'key_features' => [
            [
                'title' => 'Automated Impersonation Radar',
                'desc' => 'Continuous 24/7 scanning for newly registered brand clones, lookalike handles, and executive names.'
            ],
            [
                'title' => 'Cryptographic Forensic Archival',
                'desc' => 'Capturing immutable, time-stamped proof of defamatory posts and profile changes with Section 65B validity.'
            ],
            [
                'title' => 'Legal Takedown Escalations',
                'desc' => 'Executing expedited DMCA, copyright, trademark, and right-of-publicity takedown requests.'
            ],
            [
                'title' => 'Coordinated Inauthentic Behavior Tracking',
                'desc' => 'Identifying botnets, engagement pods, and automated troll networks orchestrating smear campaigns.'
            ],
            [
                'title' => 'Telegram & Messaging Group Takedowns',
                'desc' => 'Investigating and dismantling unauthorized private groups, channels, and financial scam bots.'
            ],
            [
                'title' => 'Executive Reputation Defense',
                'desc' => 'Rapid-response shielding for corporate leadership and celebrities during viral digital attacks.'
            ]
        ],
        'methodology' => [
            [
                'step' => '01',
                'title' => 'Threat Identification & Mapping',
                'desc' => 'Cataloging all unauthorized profiles, clone pages, and defamatory posts across social ecosystems.'
            ],
            [
                'step' => '02',
                'title' => 'Forensic Preservation & Time-Stamping',
                'desc' => 'Archiving server headers, post metadata, and full page captures under strict chain-of-custody protocols.'
            ],
            [
                'step' => '03',
                'title' => 'Operator Attribution Analysis',
                'desc' => 'Cross-referencing connected phone numbers, linked emails, and posting habits to trace the perpetrator.'
            ],
            [
                'step' => '04',
                'title' => 'Platform Legal Escalation',
                'desc' => 'Filing expedited statutory notices with platform Trust & Safety and Legal Enforcement divisions.'
            ],
            [
                'step' => '05',
                'title' => 'Deletion Verification & Monitoring',
                'desc' => 'Verifying permanent account removal and maintaining active radar to prevent clone resurgence.'
            ]
        ],
        'deliverables' => [
            'Impersonation Forensic Incident Dossier',
            'Formal Platform Takedown Notices & Escalation Receipts',
            'Operator Profiling Report (IP, email, and connected entity leads)',
            'Certificate of Content Removal & Link De-indexing',
            '30-Day Anti-Resurgence Monitoring Report'
        ],
        'compliance' => [
            'Digital Millennium Copyright Act (DMCA) 17 U.S.C. § 512',
            'IT Act 2000 (Section 66D - Cheating by Personation, Section 67)',
            'Meta, Google, LinkedIn & X Verified Rights Enforcement Standards',
            'Indian Trademarks Act 1999'
        ],
        'faqs' => [
            [
                'q' => 'How quickly can an impersonation account be taken down?',
                'a' => 'Standard takedowns with complete trademark or identity proof typically succeed within 24 to 72 hours. High-priority executive fraud accounts with acute financial risk can be expedited within hours.'
            ],
            [
                'q' => 'Can you remove scam Telegram channels using our brand name?',
                'a' => 'Yes. We track and escalate scam Telegram channels, bots, and group administrators to Telegram\'s legal and anti-scam divisions, securing channel bans and warning labels.'
            ],
            [
                'q' => 'What documentation is required to remove an impersonator?',
                'a' => 'For individuals: a government-issued photo ID. For businesses: trademark registration certificate, incorporation documents, or an official letter of authorization from an executive officer.'
            ]
        ]
    ],

    'cyber-fraud-investigation-support' => [
        'title' => 'Cyber Fraud Investigation Support',
        'nav_label' => 'Cyber Fraud Investigation Support',
        'category' => 'digital-investigations',
        'badge' => 'FINANCIAL CRIMES & CRYPTO TRACING',
        'tagline' => 'Investigating financial scams, cryptocurrency fraud, business email compromise, and investment syndicates.',
        'short_desc' => 'End-to-end investigative support for victims of investment scams, crypto theft, romance fraud, fake trading platforms, and corporate wire transfer diversion.',
        'overview' => 'Cyber fraud has evolved into organized, cross-border financial operations executing complex multi-layered scams including pig butchering investment fraud, bogus crypto trading platforms, advance-fee scams, and Business Email Compromise (BEC). Our Cyber Fraud Investigation Support unit brings together seasoned forensic accountants, certified cryptocurrency investigators, and digital evidence specialists. We trace transaction flows through fiat banking networks, identify money mule accounts, reconstruct the communication trail, analyze fraudulent mobile APKs/web applications, and map stolen cryptocurrency across Bitcoin, Ethereum, Tron (USDT), and other blockchains to identify exchange cash-out points.',
        'why_needed' => 'Local law enforcement agencies often face resource constraints and jurisdictional hurdles when dealing with offshore syndicates and cryptocurrency mixers. A professionally prepared, court-admissible forensic fraud dossier accelerates police investigation, facilitates bank account freezing under CrPC 102/105, and provides the necessary documentation for civil recovery and insurance claims.',
        'key_features' => [
            [
                'title' => 'Cryptocurrency Blockchain Tracing',
                'desc' => 'On-chain forensic tracing across TRC-20 USDT, BTC, ETH, and layer-2 networks to identify exchange deposits.'
            ],
            [
                'title' => 'Money Mule & Bank Account Mapping',
                'desc' => 'Tracking fiat remittance paths, beneficiary bank accounts, IFSC/SWIFT routings, and UPI money trails.'
            ],
            [
                'title' => 'BEC & Email Spoofing Deconstruction',
                'desc' => 'Analyzing SPF/DKIM/DMARC headers, rogue mailbox forwarding rules, and invoice spoofing alterations.'
            ],
            [
                'title' => 'Scam Application Reverse-Engineering',
                'desc' => 'Decompiling malicious APKs and fake trading web apps to locate command-and-control servers and database endpoints.'
            ],
            [
                'title' => 'Law Enforcement Ready Dossier',
                'desc' => 'Drafting formal complaints with categorized annexures for Cyber Police, CBI, ED, and overseas authorities.'
            ],
            [
                'title' => 'Exchange Subpoena Preparation',
                'desc' => 'Identifying centralized exchange deposit addresses (CEX) to request emergency account freezing.'
            ]
        ],
        'methodology' => [
            [
                'step' => '01',
                'title' => 'Fraud Intake & Timeline Mapping',
                'desc' => 'Cataloging transaction hashes (TxIDs), bank UTR receipts, chat logs, and financial loss amounts.'
            ],
            [
                'step' => '02',
                'title' => 'Blockchain & Fiat Tracking',
                'desc' => 'Tracing asset hops through intermediate mixers and identifying beneficiary exchange deposit accounts.'
            ],
            [
                'step' => '03',
                'title' => 'Infrastructure & Communication Analysis',
                'desc' => 'Unmasking scam hosting providers, domain registars, and IP telemetry used by the syndicate.'
            ],
            [
                'step' => '04',
                'title' => 'Attribution & CEX Node Identification',
                'desc' => 'Linking on-chain wallet clusters with known KYC-verified centralized exchange deposit addresses.'
            ],
            [
                'step' => '05',
                'title' => 'Dossier Delivery & Law Enforcement Briefing',
                'desc' => 'Submitting comprehensive forensic dossiers ready for police freezing orders and judicial subpoenas.'
            ]
        ],
        'deliverables' => [
            'Comprehensive Cyber Fraud Investigation Report',
            'On-Chain Cryptocurrency Flow Diagram & Clustered Wallet Map',
            'Fiat Beneficiary Account & Transaction Reconciliation Ledger',
            'Malicious Domain & Hosting Server Infrastructure Attribution',
            'Formal Law Enforcement Complaint Dossier with Evidence Annexures'
        ],
        'compliance' => [
            'FATF Guidance for Virtual Assets & VASPs',
            'Prevention of Money Laundering Act (PMLA) 2002',
            'IT Act 2000 Section 66D & IPC 420',
            'Chainalysis / TRM Labs On-Chain Forensic Methodologies',
            'ISO/IEC 27037 Evidence Integrity'
        ],
        'faqs' => [
            [
                'q' => 'Can lost cryptocurrency (like USDT or Bitcoin) actually be traced?',
                'a' => 'Yes. All public blockchains maintain an unalterable permanent public ledger. Using forensic link analysis, we follow funds through intermediate hops and unmask the centralized exchanges where the fraudsters attempt to convert crypto into fiat.'
            ],
            [
                'q' => 'Can Cyber Kovai freeze the fraudster\'s bank account directly?',
                'a' => 'Only law enforcement agencies and judicial authorities have legal authority to issue formal freezing orders (e.g. under CrPC Section 102). We provide the verified evidence dossier that enables police officers to issue immediate freezing notices to banks and crypto exchanges.'
            ],
            [
                'q' => 'What should I do immediately after realizing I have been scammed?',
                'a' => 'Immediately record all transaction hash IDs (TxIDs), bank account numbers, UTR numbers, screenshot all chats before the scammer deletes them, and file an initial complaint on the National Cyber Crime portal (cybercrime.gov.in or helpline 1930).'
            ]
        ]
    ],

    'digital-evidence-preservation-forensics' => [
        'title' => 'Digital Evidence Preservation & Forensics',
        'nav_label' => 'Digital Evidence Preservation & Forensics',
        'category' => 'digital-investigations',
        'badge' => 'ISO/IEC 27037 & COURT-ADMISSIBLE STANDARDS',
        'tagline' => 'Bit-stream forensic imaging, volatile memory extraction, and Section 65B certified legal documentation.',
        'short_desc' => 'Forensically sound acquisition, preservation, and analysis of digital evidence from hard drives, mobile phones, servers, cloud storage, and messaging platforms.',
        'overview' => 'Digital evidence is fragile, volatile, and easily compromised by improper handling. Our Digital Evidence Preservation & Forensics service adheres strictly to international ISO/IEC 27037 standards and Indian legal mandates under Section 65B of the Indian Evidence Act. We deploy hardware write-blockers and certified forensic acquisition tools to create bit-by-bit forensic images (E01 / raw dd) of computers, smartphones (iOS & Android), external storage media, enterprise servers, and cloud repositories. We reconstruct deleted artifacts, extract unallocated space data, parse SQLite chat databases, analyze registry hives, and verify chain-of-custody with cryptographic SHA-256 and MD5 hashing.',
        'why_needed' => 'In corporate fraud, employee intellectual property theft, divorce litigation, and criminal defense, opposing counsel routinely challenges digital evidence based on improper collection methods. Evidence collected without hardware write-blockers or strict hash verification is frequently thrown out of court as tainted or inadmissible.',
        'key_features' => [
            [
                'title' => 'Hardware Write-Blocked Acquisition',
                'desc' => 'Guaranteeing zero alteration to original source media during imaging using forensic hardware bridges.'
            ],
            [
                'title' => 'Mobile Device Forensic Extraction',
                'desc' => 'Physical, file-system, and logical dumps of locked or encrypted smartphones (iOS and Android).'
            ],
            [
                'title' => 'Cryptographic Hash Verification',
                'desc' => 'Generating dual SHA-256 and MD5 hashes at acquisition and verification to establish mathematical proof of integrity.'
            ],
            [
                'title' => 'Deleted Data & Artifact Carving',
                'desc' => 'Recovering deleted WhatsApp/Telegram chats, emails, browser histories, and photos from unallocated space.'
            ],
            [
                'title' => 'Volatile RAM Memory Dump & Analysis',
                'desc' => 'Capturing unencrypted memory artifacts, running processes, active network connections, and crypto keys.'
            ],
            [
                'title' => 'Section 65B Legal Evidence Certification',
                'desc' => 'Issuing expert electronic evidence certificates signed by certified forensic examiners for Indian courts.'
            ]
        ],
        'methodology' => [
            [
                'step' => '01',
                'title' => 'Intake & Chain-of-Custody Logging',
                'desc' => 'Cataloging device model, serial numbers, physical condition, and sealing in anti-static tamper-evident packaging.'
            ],
            [
                'step' => '02',
                'title' => 'Forensic Bit-Stream Acquisition',
                'desc' => 'Extracting bit-by-bit E01 forensic disk images through hardware write-blockers with dual hash manifests.'
            ],
            [
                'step' => '03',
                'title' => 'Artifact Parsing & Timeline Analysis',
                'desc' => 'Reconstructing chronological system events, file access records, chat logs, and deleted database entries.'
            ],
            [
                'step' => '04',
                'title' => 'Verification & Integrity Audit',
                'desc' => 'Re-hashing forensic copies to verify exact byte-for-byte match against original evidence acquisition records.'
            ],
            [
                'step' => '05',
                'title' => 'Expert Report & 65B Certification',
                'desc' => 'Publishing certified technical forensic reports ready for judicial scrutiny, litigation, and internal tribunals.'
            ]
        ],
        'deliverables' => [
            'Forensic Acquisition Log & Chain-of-Custody Manifest',
            'Dual-Hashed Bit-Stream Master Forensic Image Archives',
            'Detailed Forensic Analysis Report with Chronological Artifact Timelines',
            'Formal Certificate under Section 65B Indian Evidence Act',
            'Court-Ready Technical Witness Summary'
        ],
        'compliance' => [
            'ISO/IEC 27037 (Digital Evidence Handling Guidelines)',
            'Indian Evidence Act Section 65B / Bharatiya Sakshya Adhiniyam',
            'NIST SP 800-86 Forensic Integration Guide',
            'Scientific Working Group on Digital Evidence (SWGDE) Standards'
        ],
        'faqs' => [
            [
                'q' => 'What makes digital evidence court-admissible in India?',
                'a' => 'Under Section 65B of the Indian Evidence Act, digital evidence must be accompanied by an official certificate describing how the device was operated, confirming its lawful custody, and proving that the evidence has not been tampered with or altered.'
            ],
            [
                'q' => 'Can you recover WhatsApp messages that were deleted months ago?',
                'a' => 'In many cases, yes. While end-to-end encryption protects messages in transit, local SQLite database caches, unallocated flash memory blocks, and automated device backups often retain fragments of deleted conversations that forensic tools can carve and reconstruct.'
            ],
            [
                'q' => 'What is a hardware write-blocker and why is it mandatory?',
                'a' => 'A write-blocker allows forensic workstations to read data from a suspect hard drive or flash drive without allowing the computer\'s operating system to write even a single byte (such as changing access timestamps), ensuring complete integrity of original evidence.'
            ]
        ]
    ],

    'executive-family-digital-protection' => [
        'title' => 'Executive & Family Digital Protection',
        'nav_label' => 'Executive & Family Digital Protection',
        'category' => 'digital-investigations',
        'badge' => 'VIP PRIVACY & RESIDENTIAL CYBER SHIELD',
        'tagline' => 'Bespoke privacy defense, home network security, and anti-surveillance protection for leaders and high-profile families.',
        'short_desc' => 'Tailored cybersecurity, threat intelligence, and digital privacy shielding protecting corporate executives, board members, public figures, and high-net-worth families from targeted cyber risks.',
        'overview' => 'C-suite executives, high-net-worth individuals, and public figures represent prime targets for sophisticated cybercriminals seeking corporate secrets, ransom opportunities, and private personal disclosures. Our Executive & Family Digital Protection service delivers 360-degree digital perimeter defense. We conduct comprehensive vulnerability audits of personal residences, executive smart home IoT devices, personal smartphones, tablets, and private email accounts. We scrub sensitive personal identifying information (PII) from data broker registries, implement secure encrypted communications, deploy SIM-swap protection, and monitor dark web channels for emerging threats against the family.',
        'why_needed' => 'While corporate offices are fortified with enterprise firewalls and SOC monitoring, executives frequently access sensitive corporate data from vulnerable home Wi-Fi networks and personal devices. Hackers actively target family members\' unsecured laptops and social accounts to gain lateral access into corporate crown jewels.',
        'key_features' => [
            [
                'title' => 'Residential & Smart Home Network Hardening',
                'desc' => 'Securing home routers, Wi-Fi 6 networks, smart TVs, and IoT cameras against unauthorized remote access.'
            ],
            [
                'title' => 'Personal Device Forensic Health Checks',
                'desc' => 'Scanning personal phones and laptops for commercial spyware, stalkerware, and rogue configuration profiles.'
            ],
            [
                'title' => 'SIM-Swap & Telecommunications Shielding',
                'desc' => 'Setting up carrier PIN protections, port-out freezes, and eSIM security to eliminate mobile hijacking.'
            ],
            [
                'title' => 'Data Broker Privacy Scrubbing',
                'desc' => 'Removing home addresses, phone numbers, and family records from public search directories and data aggregators.'
            ],
            [
                'title' => 'Dark Web Executive Threat Monitoring',
                'desc' => 'Continuous alerts for leaked personal credentials, passwords, and private records across illicit forums.'
            ],
            [
                'title' => 'Travel Cybersecurity Protocols',
                'desc' => 'Hardened portable routers, burner configurations, and secure encrypted VPNs for international travel.'
            ]
        ],
        'methodology' => [
            [
                'step' => '01',
                'title' => 'Threat Modeling & Reconnaissance',
                'desc' => 'Assessing the public digital footprint, family exposure levels, and personal device attack vectors.'
            ],
            [
                'step' => '02',
                'title' => 'Residential Network & Device Audit',
                'desc' => 'Penetration testing home Wi-Fi, smart home IoT hubs, personal laptops, smartphones, and tablets.'
            ],
            [
                'step' => '03',
                'title' => 'Forensic Sanitization & Hardening',
                'desc' => 'Eliminating identified stalkerware, configuring DNS filtering, and enforcing zero-trust access controls.'
            ],
            [
                'step' => '04',
                'title' => 'PII Scrubbing & Carrier Shielding',
                'desc' => 'Excising family records from public data broker sites and locking carrier accounts with high-security PINs.'
            ],
            [
                'step' => '05',
                'title' => '24/7 Threat Concierge Support',
                'desc' => 'Continuous dark web surveillance, VIP emergency response line, and periodic scheduled checkups.'
            ]
        ],
        'deliverables' => [
            'Executive Cyber Risk Scorecard & Threat Profile',
            'Residential Network Hardening & Architecture Blueprint',
            'Device Sanitization & Spyware Audit Certificates',
            'PII Data Scrubbing Completion Report',
            'Dedicated Incident Concierge Hotline & Emergency Playbook'
        ],
        'compliance' => [
            'NIST Privacy Framework (Cybersecurity for High-Value Targets)',
            'Digital Personal Data Protection Act (DPDP) 2023',
            'ISO/IEC 27701 Privacy Information Management',
            'OSAC High-Risk Executive Protection Standards'
        ],
        'faqs' => [
            [
                'q' => 'How do you detect if an executive\'s personal phone has been tapped or infected with spyware?',
                'a' => 'We perform deep mobile forensic analysis, inspecting outbound network telemetry, examining system log files, checking for unauthorized root/jailbreak profiles, and analyzing installed certificates against known commercial stalkerware signatures.'
            ],
            [
                'q' => 'Does this service disrupt our family\'s normal daily internet use?',
                'a' => 'Not at all. We design protections to operate invisibly in the background. Family members continue using their favorite apps and devices with enhanced, effortless security.'
            ],
            [
                'q' => 'What happens if an executive or family member experiences an emergency while traveling abroad?',
                'a' => 'Our clients have 24/7 access to our dedicated emergency concierge. We provide remote emergency triage, account containment, and secure replacement device deployment anywhere in the world.'
            ]
        ]
    ],

    'cybersecurity-awareness-lea-training' => [
        'title' => 'Cybersecurity Awareness & LEA Training',
        'nav_label' => 'Cybersecurity Awareness & LEA Training',
        'category' => 'digital-investigations',
        'badge' => 'LAW ENFORCEMENT & INSTITUTIONAL ACADEMY',
        'tagline' => 'Specialized training programs in digital forensics, cybercrime investigation, and corporate fraud defense.',
        'short_desc' => 'Hands-on, practitioner-led capacity-building programs designed for police departments, law enforcement officers, judiciary personnel, corporate security teams, and academic institutions.',
        'overview' => 'As cybercrime tactics grow increasingly sophisticated, law enforcement personnel and corporate security officers require up-to-date, practical investigative techniques. Cyber Kovai\'s Cybersecurity Awareness & LEA Training division conducts specialized, interactive workshops and simulation labs. Led by certified digital forensic examiners and cyber intelligence practitioners, our modules cover end-to-end cybercrime investigations: electronic evidence seizure at crime scenes, mobile device extraction, cryptocurrency transaction tracing, open-source intelligence (OSINT), and preparation of Section 65B court evidence.',
        'why_needed' => 'Over 70% of electronic evidence in criminal prosecutions is contested due to procedural errors committed during first-response seizure. Specialized training empowers officers and corporate investigators to handle digital evidence correctly from day one, drastically boosting conviction rates and organizational resilience.',
        'key_features' => [
            [
                'title' => 'Crime Scene Digital Evidence Handling',
                'desc' => 'Hands-on training in Faraday packaging, volatile triage, and chain-of-custody documentation under ISO 27037.'
            ],
            [
                'title' => 'Cryptocurrency Investigation & Seizure',
                'desc' => 'Tracing on-chain wallet hops, interacting with exchanges, and executing lawful wallet asset seizures.'
            ],
            [
                'title' => 'Advanced OSINT & Social Media Reconnaissance',
                'desc' => 'De-anonymizing threat actors, geolocating imagery, and analyzing digital footprints using open-source tools.'
            ],
            [
                'title' => 'CDR, IPDR & Tower Dump Analytics',
                'desc' => 'Parsing telecom Call Detail Records and Internet Protocol Detail Records for criminal movement mapping.'
            ],
            [
                'title' => 'Dark Web & Cybercrime Syndicate Operations',
                'desc' => 'Navigating Tor hidden services, understanding escrow markets, and identifying malware-as-a-service kits.'
            ],
            [
                'title' => 'Corporate Security & Employee Awareness',
                'desc' => 'Simulated phishing attacks, social engineering defenses, and incident escalation protocols for staff.'
            ]
        ],
        'methodology' => [
            [
                'step' => '01',
                'title' => 'Training Needs Assessment',
                'desc' => 'Evaluating organizational proficiency levels, jurisdiction requirements, and specific threat landscape.'
            ],
            [
                'step' => '02',
                'title' => 'Hands-On Scenario Design',
                'desc' => 'Formulating realistic simulated cybercrime case files, forensic images, and blockchain audit scenarios.'
            ],
            [
                'step' => '03',
                'title' => 'Interactive Workshop Execution',
                'desc' => 'Conducting practitioner-led intensive bootcamps with 80% practical hands-on laboratory exercises.'
            ],
            [
                'step' => '04',
                'title' => 'Simulation Drills & Practical Exam',
                'desc' => 'Testing participants on live forensic artifact extraction, reporting, and evidence defense.'
            ],
            [
                'step' => '05',
                'title' => 'Certification & Ongoing Resources',
                'desc' => 'Issuing verified certificates of competency, field handbooks, and post-training advisory access.'
            ]
        ],
        'deliverables' => [
            'Comprehensive Cybercrime Investigation Field Manual & SOPs',
            'Practical Forensic Toolkits & Open-Source Software Resource Pack',
            'Real-World Simulated Case Datasets for Ongoing Practice',
            'Official Certificate of Completion (Authorized by Cyber Kovai Academy)',
            '6 Months Post-Training Technical Advisory Access'
        ],
        'compliance' => [
            'Bureau of Police Research & Development (BPR&D) Guidelines',
            'National Cyber Crime Training Centre (NCCTC) Curricula',
            'ISO/IEC 27037 Digital Evidence Standards',
            'Information Technology Act 2000 & Criminal Procedure Code'
        ],
        'faqs' => [
            [
                'q' => 'Are your training sessions theoretical or hands-on?',
                'a' => 'All our training modules are 80% hands-on practical exercises. Participants analyze real (anonymized) digital forensic images, trace actual blockchain transactions, and build complete case dossiers in sandbox environments.'
            ],
            [
                'q' => 'Can you conduct on-premise training sessions for police departments or corporate headquarters?',
                'a' => 'Yes. We conduct both on-premise intensive workshops at police academies and corporate facilities across India, as well as live virtual interactive bootcamps.'
            ],
            [
                'q' => 'Are the certificates recognized for professional credentials?',
                'a' => 'Yes. Certificates issued by Cyber Kovai attest to verifiable practical competencies in digital forensics, OSINT, and cybercrime investigation recognized by legal and corporate sectors.'
            ]
        ]
    ],

    'child-digital-safety-protection' => [
        'title' => 'Child Digital Safety & Protection',
        'nav_label' => 'Child Digital Safety & Protection',
        'category' => 'digital-investigations',
        'badge' => 'CHILD SAFEGUARDING & CSAM PREVENTION',
        'tagline' => 'Confidential investigation of cyberbullying, predatory grooming, and child sexual abuse material (CSAM) reporting.',
        'short_desc' => 'Specialized, highly sensitive investigations to protect children and adolescents from online predators, cyberbullying, extortion, and digital exploitation risks.',
        'overview' => 'The digital landscape presents severe risks for children and adolescents, ranging from predatory grooming on gaming platforms and social apps to severe cyberbullying, sextortion, and non-consensual image distribution. Cyber Kovai\'s Child Digital Safety & Protection unit provides confidential, trauma-informed investigation services for concerned parents, educational institutions, child protection NGOs, and legal guardians. We conduct discrete forensic audits of devices to identify predatory communications, preserve evidence of cyberbullying for school and police interventions, track anonymous harassers, and execute immediate mandatory reporting of Child Sexual Abuse Material (CSAM) to national and international authorities (NCMEC / CyberTipline and National Cyber Crime Portal).',
        'why_needed' => 'Children often hesitate to tell parents about online threats out of fear, shame, or confusion, allowing predatory grooming or cyberbullying to escalate unchecked. Professional, compassionate investigation uncovers the truth, stops victimization, preserves legal evidence, and restores digital safety and emotional peace of mind.',
        'key_features' => [
            [
                'title' => 'Anti-Grooming & Predator Investigation',
                'desc' => 'Identifying predatory behavioral patterns, fake underage profiles, and coercion attempts across messaging platforms.'
            ],
            [
                'title' => 'Cyberbullying & Defamation Documentation',
                'desc' => 'Forensically capturing abusive group chats, smear pages, and anonymous harassment accounts with legal validity.'
            ],
            [
                'title' => 'Minor Sextortion Emergency Response',
                'desc' => 'Immediate containment, non-payment guidance, and takedown of compromised personal imagery.'
            ],
            [
                'title' => 'CSAM Detection & Mandatory Reporting',
                'desc' => 'Zero-tolerance identification and expedited reporting to NCMEC CyberTipline and Indian Cyber Crime units.'
            ],
            [
                'title' => 'Gaming Platform & App Security Audits',
                'desc' => 'Reviewing Discord, Roblox, Minecraft, Snapchat, and Instagram privacy configurations and communication permissions.'
            ],
            [
                'title' => 'Parental Digital Safety Consultation',
                'desc' => 'Equipping parents with discreet monitoring techniques and age-appropriate digital safety guidelines.'
            ]
        ],
        'methodology' => [
            [
                'step' => '01',
                'title' => 'Confidential Consultation & Triage',
                'desc' => 'Understanding the situation with empathy, assessing imminent danger, and establishing a discrete action plan.'
            ],
            [
                'step' => '02',
                'title' => 'Discrete Device & Chat Forensic Audit',
                'desc' => 'Extracting unallocated chats, hidden media caches, and app interaction logs under strict privacy controls.'
            ],
            [
                'step' => '03',
                'title' => 'Predator & Harasser Attribution',
                'desc' => 'Cross-referencing digital handles, phone numbers, and IP traces to identify the individual behind the harassment.'
            ],
            [
                'step' => '04',
                'title' => 'Emergency Takedown & Statutory Reporting',
                'desc' => 'Reporting CSAM or acute threats immediately to national law enforcement and international child protection bodies.'
            ],
            [
                'step' => '05',
                'title' => 'Resolution Dossier & Parental Shielding',
                'desc' => 'Delivering evidence for school interventions or police FIRs, followed by robust parental control hardening.'
            ]
        ],
        'deliverables' => [
            'Confidential Child Safety Investigation Dossier',
            'Comprehensive Evidence Timeline with Attributed Communication Transcripts',
            'Emergency Takedown Confirmations & Escalation Records',
            'Law Enforcement / NCMEC Official Reporting Confirmation',
            'Personalized Child Digital Protection & Device Hardening Blueprint'
        ],
        'compliance' => [
            'Protection of Children from Sexual Offences (POCSO) Act 2012',
            'IT Act 2000 (Section 67B - Child Sexual Abuse Material Prohibition)',
            'NCMEC (National Center for Missing & Exploited Children) Standards',
            'Interpol Specialist Group on Crimes Against Children Guidelines',
            'Children\'s Online Privacy Protection Act (COPPA) Principles'
        ],
        'faqs' => [
            [
                'q' => 'Will my child know that their phone or laptop is being investigated?',
                'a' => 'We discuss the approach with parents in advance. We can conduct the forensic examination discretely while the child is asleep or at school, or collaboratively with the child in a compassionate, non-judgmental manner.'
            ],
            [
                'q' => 'What happens if Child Sexual Abuse Material (CSAM) is discovered?',
                'a' => 'We have a strict zero-tolerance legal and ethical policy. Any discovered CSAM is immediately sealed under chain of custody and reported through mandatory statutory channels to the National Cyber Crime Reporting Portal and NCMEC without delay.'
            ],
            [
                'q' => 'Can you help stop anonymous cyberbullies targeting my child at school?',
                'a' => 'Yes. We forensically document all defamatory posts and messages with Section 65B certificates and trace the origins of anonymous accounts. This provides undeniable proof that school principals and police cyber cells must act upon.'
            ]
        ]
    ]
];

// Merge into $allServicesData
foreach ($newServices as $slug => $data) {
    $allServicesData[$slug] = $data;
}

// Generate the updated services-data.php
$content = "<?php\n/**\n * Cyber Kovai - Cybersecurity Services Registry & Content Database\n * Contains core categories and all specialized services.\n */\n\nif (!defined('SITE_NAME')) {\n    require_once __DIR__ . '/config.php';\n}\n\n";

$content .= '$serviceCategories = ' . var_export($serviceCategories, true) . ";\n\n";
$content .= '$allServicesData = ' . var_export($allServicesData, true) . ";\n\n";

$content .= <<<'CODE'
/**
 * Helper function to retrieve all services by category
 */
function getServicesByCategory($categorySlug) {
    global $allServicesData, $serviceCategories;
    if (!isset($serviceCategories[$categorySlug])) {
        return [];
    }
    $list = [];
    foreach ($serviceCategories[$categorySlug]['services'] as $slug) {
        if (isset($allServicesData[$slug])) {
            $list[$slug] = $allServicesData[$slug];
        }
    }
    return $list;
}

/**
 * Helper function to get service by slug
 */
function getServiceBySlug($slug) {
    global $allServicesData;
    return $allServicesData[$slug] ?? null;
}
CODE;

file_put_contents($dataFile, $content);
echo "Successfully updated services-data.php with 8 investigation services!\n";
