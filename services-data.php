<?php
/**
 * Cyber Kovai - Cybersecurity Services Registry & Content Database
 * Contains core categories and all specialized services.
 */

if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/config.php';
}

$serviceCategories = array (
  'application-security' => 
  array (
    'name' => 'Application Security',
    'column' => 1,
    'order' => 1,
    'badge' => 'APPSEC & CODE ASSURANCE',
    'icon' => '🛡️',
    'short_desc' => 'Comprehensive vulnerability assessments, penetration tests, and secure architecture for modern web, mobile, and API platforms.',
    'services' => 
    array (
      0 => 'vulnerability-assessment-penetration-testing',
      1 => 'web-application-penetration-testing',
      2 => 'mobile-app-penetration-testing',
      3 => 'api-penetration-testing',
      4 => 'secure-source-code-review',
      5 => 'ecommerce-security',
      6 => 'saas-security',
      7 => 'devsecops',
    ),
  ),
  'network-security' => 
  array (
    'name' => 'Network Security',
    'column' => 2,
    'order' => 1,
    'badge' => 'INFRASTRUCTURE & PERIMETER',
    'icon' => '🌐',
    'short_desc' => 'Securing corporate network perimeters, wireless topologies, firewall configs, and routing appliances.',
    'services' => 
    array (
      0 => 'network-penetration-testing',
      1 => 'wireless-penetration-testing',
      2 => 'firewall-security-audit',
    ),
  ),
  'cloud-security' => 
  array (
    'name' => 'Cloud Security',
    'column' => 3,
    'order' => 1,
    'badge' => 'CLOUD & CONTAINER SECURITY',
    'icon' => '☁️',
    'short_desc' => 'Multi-cloud architecture auditing, CASA compliance, Kubernetes container security, and server hardening across AWS, GCP, and Azure.',
    'services' => 
    array (
      0 => 'cloud-configuration-review',
      1 => 'cloud-application-security-assessment-casa',
      2 => 'cloud-container-security',
      3 => 'gcp-server-hardening',
      4 => 'aws-server-hardening',
      5 => 'azure-server-hardening',
    ),
  ),
  'enterprise-security' => 
  array (
    'name' => 'Enterprise Security',
    'column' => 4,
    'order' => 1,
    'badge' => 'ORGANIZATIONAL RESILIENCE',
    'icon' => '🏢',
    'short_desc' => 'Virtual CISO advisory, black box simulations, Microsoft 365 hardening, ERP audits, and zero-trust security architecture.',
    'services' => 
    array (
      0 => 'virtual-ciso-services',
      1 => 'black-box-testing',
      2 => 'email-security-audit',
      3 => 'server-hardening',
      4 => 'microsoft-365-security',
      5 => 'erp-security-audit-assessment',
      6 => 'security-architecture-review',
      7 => 'wordpress-security',
    ),
  ),
  'digital-investigations' => 
  array (
    'name' => 'Digital Investigation & Forensics',
    'column' => 5,
    'order' => 5,
    'badge' => 'CRIMINAL & DIGITAL FORENSICS',
    'icon' => '🕵️‍♂️',
    'short_desc' => 'Court-admissible forensic preservation, OSINT intelligence, financial fraud tracing, and executive protection.',
    'services' => 
    array (
      0 => 'cybercrime-victim-assistance-account-recovery',
      1 => 'digital-investigations-osint',
      2 => 'social-media-investigations-impersonation-removal',
      3 => 'cyber-fraud-investigation-support',
      4 => 'digital-evidence-preservation-forensics',
      5 => 'executive-family-digital-protection',
      6 => 'cybersecurity-awareness-lea-training',
      7 => 'child-digital-safety-protection',
    ),
  ),
);

$allServicesData = array (
  'vulnerability-assessment-penetration-testing' => 
  array (
    'title' => 'Comprehensive VAPT Assessment',
    'nav_label' => 'Vulnerability Assessment & Penetration Testing',
    'category' => 'application-security',
    'badge' => 'OWASP Top 10 & SANS 25',
    'tagline' => 'Uncover, exploit, and eliminate vulnerabilities before malicious adversaries do.',
    'short_desc' => 'Comprehensive security evaluations combining automated vulnerability scanning with manual exploit simulation across digital infrastructure.',
    'overview' => 'Vulnerability Assessment and Penetration Testing (VAPT) is an essential cybersecurity measure that simulates real-world cyber attacks against your systems, networks, and applications. Our certified ethical hackers identify exploitable weaknesses, misconfigurations, and software flaws, providing you with actionable remediation roadmaps to harden your defenses against ransomware and data breaches.',
    'why_needed' => 'Over 80% of corporate data breaches originate from known vulnerabilities that went unpatched or unmonitored. VAPT validates the real-world strength of your defensive posture, guarantees regulatory compliance, and protects your brand reputation against catastrophic downtime.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Dual Methodology',
        'desc' => 'Combines broad automated vulnerability assessment with deep manual exploit verification to eliminate false positives.',
      ),
      1 => 
      array (
        'title' => 'Threat Modeling',
        'desc' => 'Tailored attack scenarios reflecting the exact tactics, techniques, and procedures (TTPs) of modern cyber adversaries.',
      ),
      2 => 
      array (
        'title' => 'Business Logic Flaws',
        'desc' => 'Identifies nuanced authorization, rate-limiting, and state-machine flaws that automated scanners inherently miss.',
      ),
      3 => 
      array (
        'title' => 'Detailed CVSS Scoring',
        'desc' => 'Prioritized vulnerability ratings using CVSS v3.1 metrics for clear executive and technical decision-making.',
      ),
      4 => 
      array (
        'title' => 'Zero-Day Discovery',
        'desc' => 'In-depth fuzzing and edge-case testing to uncover zero-day security gaps in proprietary code.',
      ),
      5 => 
      array (
        'title' => 'Complimentary Re-Testing',
        'desc' => 'Verification testing post-remediation with a formal Certificate of Security Attestation.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Reconnaissance & Scoping',
        'desc' => 'Mapping target assets, passive intelligence gathering, and establishing rules of engagement.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Vulnerability Identification',
        'desc' => 'Automated and semi-automated surface scanning to detect unpatched CVEs and configuration drift.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Manual Exploitation',
        'desc' => 'Controlled exploitation of discovered flaws to verify impact without interrupting production operations.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Risk Analysis & Reporting',
        'desc' => 'Compiling detailed technical reports with proof-of-concept exploits, CVSS scores, and remediation code snippets.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Fix Verification & Attestation',
        'desc' => 'Re-assessing patched vulnerabilities and issuing compliance-ready certification of security health.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Executive Risk Briefing with business-level risk metrics',
      1 => 'Comprehensive Technical Vulnerability Report with PoC exploits',
      2 => 'Prioritized Remediation Roadmap with source-code recommendations',
      3 => 'Official Certificate of Security Assessment (Attestation Letter)',
    ),
    'compliance' => 
    array (
      0 => 'ISO 27001',
      1 => 'PCI DSS 4.0',
      2 => 'HIPAA Security Rule',
      3 => 'NIST SP 800-115',
      4 => 'SOC 2 Type II',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'What is the difference between Vulnerability Assessment and Penetration Testing?',
        'a' => 'A vulnerability assessment scans and lists potential vulnerabilities across your network or app. Penetration testing goes a step further by actively attempting to exploit those vulnerabilities to measure their real-world damage and reach.',
      ),
      1 => 
      array (
        'q' => 'Will VAPT cause downtime in our production environment?',
        'a' => 'No. Our testing is carefully controlled, scheduled in advance, and conducted according to strict rules of engagement to ensure business continuity without system interruption.',
      ),
      2 => 
      array (
        'q' => 'How often should an organization undergo VAPT?',
        'a' => 'Industry standards and compliance mandates recommend undergoing VAPT at least annually, or following any major architecture change, system upgrade, or feature rollout.',
      ),
    ),
  ),
  'web-application-penetration-testing' => 
  array (
    'title' => 'Web Application Security Testing',
    'nav_label' => 'Web Application Penetration Testing',
    'category' => 'application-security',
    'badge' => 'OWASP ASVS & WSTG Standards',
    'tagline' => 'Rigorous security evaluation of modern web apps, single-page architectures, and portals.',
    'short_desc' => 'In-depth manual penetration testing targeting OWASP Top 10 vulnerabilities, business logic weaknesses, and complex session hijacking risks.',
    'overview' => 'Web applications serve as the primary gateway for customer interaction, making them prime targets for malicious intrusions. Our Web Application Penetration Testing service evaluates custom-built web apps, SaaS portals, and enterprise microservices. We test for injection attacks, cross-site scripting (XSS), insecure deserialization, broken access controls, and authentication bypasses using industry-standard OWASP Web Security Testing Guides (WSTG).',
    'why_needed' => 'Web vulnerabilities can lead to customer data theft, unauthorized financial transfers, and brand devastation. Comprehensive web application penetration testing ensures that your critical code is resilient against both opportunistic scanners and sophisticated targeted adversaries.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'OWASP Top 10 Coverage',
        'desc' => 'Rigorous assessment covering Injection, Broken Authentication, IDOR, SSRF, and Security Misconfiguration.',
      ),
      1 => 
      array (
        'title' => 'Business Logic Testing',
        'desc' => 'Verifying payment bypasses, privilege escalation, coupon abuse, and workflow integrity.',
      ),
      2 => 
      array (
        'title' => 'Session & Token Security',
        'desc' => 'Evaluating JWT token implementation, session fixation, entropy, and CORS policy enforcement.',
      ),
      3 => 
      array (
        'title' => 'Modern Framework Testing',
        'desc' => 'Specialized exploits tailored for React, Angular, Vue, Next.js, Node.js, Laravel, and Django stacks.',
      ),
      4 => 
      array (
        'title' => 'Third-Party Library Audits',
        'desc' => 'Identifying vulnerable dependencies, outdated package components, and supply-chain threats.',
      ),
      5 => 
      array (
        'title' => 'Executive & Developer Reports',
        'desc' => 'Clear executive summaries accompanied by step-by-step developer remediation instructions.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Target Profiling & Mapping',
        'desc' => 'Crawling the application, mapping all input vectors, APIs, state parameters, and user roles.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Authentication & Authz Testing',
        'desc' => 'Testing horizontal and vertical privilege escalation, session handling, and MFA bypasses.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Client-Side & Server Injection',
        'desc' => 'Executing payload injections (SQLi, NoSQLi, XSS, XXE, SSRF, SSTI, Command Injection).',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Business Logic Verification',
        'desc' => 'Testing edge cases, order manipulation, race conditions, and bypass of checkout controls.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Remediation Review & Sign-Off',
        'desc' => 'Guiding dev teams through code fixes and performing validation re-tests.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'OWASP-Aligned Web Security Assessment Report',
      1 => 'Proof-of-Concept Exploit Screenshots and HTTP Request/Response Dumps',
      2 => 'Developer Remediation Code Guidance and Configuration Snippets',
      3 => 'Executive Risk Scorecard and Official Security Attestation',
    ),
    'compliance' => 
    array (
      0 => 'OWASP ASVS',
      1 => 'PCI DSS Requirement 6.6',
      2 => 'ISO 27001 Annex A.14',
      3 => 'HIPAA Security Rule',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Do you test both authenticated and unauthenticated user roles?',
        'a' => 'Yes. We test multiple user privilege tiers (e.g., anonymous, registered user, tenant manager, super admin) to detect horizontal and vertical privilege escalation flaws.',
      ),
      1 => 
      array (
        'q' => 'Can you test staging/pre-production environments?',
        'a' => 'Yes, testing staging environments is highly recommended so that vulnerabilities can be patched before features are exposed to public production traffic.',
      ),
      2 => 
      array (
        'q' => 'What frameworks and technologies do you support?',
        'a' => 'We test all web architectures including React, Next.js, Angular, Vue, PHP, ASP.NET, Python/Django, Ruby on Rails, Java Spring, and serverless architectures.',
      ),
    ),
  ),
  'mobile-app-penetration-testing' => 
  array (
    'title' => 'Mobile Application Security (iOS & Android)',
    'nav_label' => 'Mobile App Penetration Testing',
    'category' => 'application-security',
    'badge' => 'OWASP MASVS / MSTG Certified',
    'tagline' => 'Hardening iOS and Android applications against decompilation, runtime manipulation, and insecure storage.',
    'short_desc' => 'Static and dynamic mobile security assessment (SAST/DAST) covering binary reverse engineering, secure local storage, IPC, and API communications.',
    'overview' => 'Mobile devices operate in untrusted environments where malicious users have full physical and root access to inspect and tamper with your application code. Our Mobile Application Penetration Testing service assesses both iOS (IPA) and Android (APK/AAB) binaries using the OWASP Mobile Application Security Verification Standard (MASVS). We evaluate client-side cryptography, jailbreak/root detection, runtime hooking (Frida/Objection), and backend API interfaces.',
    'why_needed' => 'Mobile apps often store sensitive credentials, cached tokens, and personal data locally on devices. Without rigorous testing, reverse engineers can bypass licensing, extract hardcoded API secrets, or manipulate app runtime logic to steal customer data.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Binary Reverse Engineering',
        'desc' => 'Decompiling bytecode to inspect obfuscation, hardcoded API keys, and sensitive business logic.',
      ),
      1 => 
      array (
        'title' => 'Runtime Manipulation',
        'desc' => 'Hooking methods using Frida to bypass biometric authentication, SSL pinning, and root detection.',
      ),
      2 => 
      array (
        'title' => 'Insecure Local Storage',
        'desc' => 'Inspecting SQLite databases, SharedPreferences, Keychain, and NSUserDefaults for unencrypted secrets.',
      ),
      3 => 
      array (
        'title' => 'Network Communication Security',
        'desc' => 'Validating TLS certificate pinning, cipher suite configurations, and man-in-the-middle resilience.',
      ),
      4 => 
      array (
        'title' => 'Inter-Process Communication',
        'desc' => 'Assessing exported Activities, Broadcast Receivers, Content Providers, and deep-link vulnerabilities.',
      ),
      5 => 
      array (
        'title' => 'Both iOS & Android Platforms',
        'desc' => 'Equal depth across Apple App Store and Google Play Store security requirements.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Static Application Analysis (SAST)',
        'desc' => 'Decompilation, manifest review, dependency audit, and automated code weakness scanning.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Dynamic Testing & Instrumentation (DAST)',
        'desc' => 'Running app on rooted/jailbroken devices, intercepting traffic, and runtime hooking.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Local Data Storage Inspection',
        'desc' => 'Analyzing cache, memory dumps, logs, and sandbox directories for data leakage.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Backend API Testing',
        'desc' => 'Evaluating server-side APIs invoked by mobile endpoints for authorization flaws and IDORs.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Reporting & Re-Testing',
        'desc' => 'Actionable fix guidelines for mobile engineers followed by verified re-testing.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'OWASP MASVS Compliance Audit Report',
      1 => 'Reverse Engineering & Binary Analysis Breakdown',
      2 => 'Runtime Instrumentation Proof-of-Concept Exploit Records',
      3 => 'Mobile Security Hardening Guidelines & Security Certificate',
    ),
    'compliance' => 
    array (
      0 => 'OWASP MASVS',
      1 => 'Google Play Developer Policy',
      2 => 'Apple App Store Review Guidelines',
      3 => 'PCI DSS Mobile Guidelines',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Do you require source code to test mobile applications?',
        'a' => 'We can perform black-box testing using only the IPA/APK binaries, or gray-box/white-box testing with source code access for the highest depth of coverage.',
      ),
      1 => 
      array (
        'q' => 'Can you bypass SSL certificate pinning during testing?',
        'a' => 'Yes, our analysts utilize dynamic instrumentation frameworks to bypass SSL pinning in order to thoroughly assess the underlying REST/GraphQL traffic.',
      ),
      2 => 
      array (
        'q' => 'Does this testing help satisfy Google Play / Apple App Store requirements?',
        'a' => 'Yes, our reports explicitly map findings to App Store and Play Store security standards.',
      ),
    ),
  ),
  'api-penetration-testing' => 
  array (
    'title' => 'REST & GraphQL API Security Testing',
    'nav_label' => 'API Penetration Testing',
    'category' => 'application-security',
    'badge' => 'OWASP API Security Top 10',
    'tagline' => 'Protect REST, GraphQL, and microservice endpoints connecting your critical data pipelines.',
    'short_desc' => 'Targeted security evaluations for modern APIs detecting broken object-level authorization (BOLA), mass assignment, rate limiting flaws, and injection.',
    'overview' => 'APIs constitute the backbone of modern web, cloud, and mobile architectures, yet they often expose sensitive backend logic directly to the public internet. Our API Penetration Testing aligns directly with the OWASP API Security Top 10 framework. We systematically probe your endpoints for Broken Object Level Authorization (BOLA/IDOR), broken function-level authorization, mass assignment, excessive data exposure, and unauthenticated administrative routes.',
    'why_needed' => 'Traditional web application firewalls (WAFs) are largely blind to API business logic flaws. A single broken object reference can allow an attacker to dump millions of user records through a legitimate, authorized API connection.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'BOLA & BFLA Detection',
        'desc' => 'Testing object reference manipulation across multiple user privilege tokens.',
      ),
      1 => 
      array (
        'title' => 'REST, GraphQL & gRPC',
        'desc' => 'Comprehensive testing tailored to schema introspection, query depth, and batching attacks.',
      ),
      2 => 
      array (
        'title' => 'Rate Limiting & DoS',
        'desc' => 'Probing endpoint resilience against brute force, resource exhaustion, and scraping.',
      ),
      3 => 
      array (
        'title' => 'Mass Assignment Checks',
        'desc' => 'Detecting hidden model parameters that allow privilege elevation or data modification.',
      ),
      4 => 
      array (
        'title' => 'Excessive Data Exposure',
        'desc' => 'Identifying endpoints returning full backend data models relying on front-end filtering.',
      ),
      5 => 
      array (
        'title' => 'Token & JWT Security',
        'desc' => 'Auditing signature validation, algorithm confusion (none/HS256), and expiry enforcement.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Endpoint Discovery & Schema Analysis',
        'desc' => 'Ingesting OpenAPI/Swagger schemas, Postman collections, and discovering hidden routes.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Authentication & Access Testing',
        'desc' => 'Validating bearer tokens, API keys, OAuth flows, and cross-tenant data isolation.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Payload Fuzzing & Injection',
        'desc' => 'Injecting malicious JSON/XML payloads, SQL injection, NoSQL, and command syntax.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Business Logic & Rate Abuse',
        'desc' => 'Testing batching attacks, circular GraphQL queries, and parameter tampering.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Remediation & API Gateway Hardening',
        'desc' => 'Providing API gateway policies and code patches for rapid developer mitigation.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'OWASP API Top 10 Detailed Assessment Report',
      1 => 'Full HTTP Request/Response Payload Exploit Artifacts',
      2 => 'API Gateway & Policy Configuration Recommendations',
      3 => 'Formal Security Attestation Certificate',
    ),
    'compliance' => 
    array (
      0 => 'OWASP API Top 10',
      1 => 'PCI DSS 4.0',
      2 => 'PSD2 Open Banking Security',
      3 => 'FHIR Healthcare API Standards',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'What documentation do you need to begin API testing?',
        'a' => 'An OpenAPI/Swagger file, Postman collection, or API documentation along with test credentials for each user role allows us to achieve optimal testing coverage.',
      ),
      1 => 
      array (
        'q' => 'Can you test GraphQL endpoints?',
        'a' => 'Yes, we test GraphQL for introspection leaks, nested query denial-of-service, batching attacks, and field-level authorization flaws.',
      ),
      2 => 
      array (
        'q' => 'Do you test third-party webhook integrations?',
        'a' => 'Yes, we verify webhook signature validation, replay attack vulnerability, and mutual TLS (mTLS) enforcement.',
      ),
    ),
  ),
  'secure-source-code-review' => 
  array (
    'title' => 'Secure Code Audit & SAST Review',
    'nav_label' => 'Secure Source Code Review',
    'category' => 'application-security',
    'badge' => 'White-Box SAST & Manual Analysis',
    'tagline' => 'Unearth architectural defects, cryptographic weaknesses, and logic bugs hidden in your code.',
    'short_desc' => 'In-depth static code analysis combining automated enterprise SAST scanners with line-by-line manual audit by senior security researchers.',
    'overview' => 'Vulnerabilities discovered during production runtime are significantly more expensive to fix than those identified in source code. Our Secure Source Code Review blends automated static analysis tools with manual, human-driven inspection to detect hidden cryptographic flaws, race conditions, memory leaks, backdoors, and logic bugs across your software codebases.',
    'why_needed' => 'Penetration testing analyzes only what is reachable through exposed interfaces; source code review reveals latent flaws, hardcoded credentials, and architectural oversights before the software is ever compiled or deployed.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Multi-Language Support',
        'desc' => 'Expertise in Java, C/C++, C#, Python, Go, Rust, PHP, JavaScript, TypeScript, Swift, and Kotlin.',
      ),
      1 => 
      array (
        'title' => 'Manual Logic Auditing',
        'desc' => 'Expert human inspection of complex business rules, authentication flows, and state machines.',
      ),
      2 => 
      array (
        'title' => 'Secrets & Credentials Hunt',
        'desc' => 'Detecting hardcoded private keys, passwords, database URIs, and third-party API tokens.',
      ),
      3 => 
      array (
        'title' => 'Software Composition Analysis',
        'desc' => 'Mapping third-party open-source dependencies (SBOM) against known CVE databases.',
      ),
      4 => 
      array (
        'title' => 'Cryptographic Verification',
        'desc' => 'Reviewing salt generation, hashing algorithms, IV randomness, and cipher modes.',
      ),
      5 => 
      array (
        'title' => 'IDE & Pipeline Integration',
        'desc' => 'Advising on incorporating automated linting and security rules directly into Git/CI/CD pipelines.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Architecture & Threat Modeling',
        'desc' => 'Understanding system design, data flows, trust boundaries, and critical asset paths.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Automated Tool Scanning',
        'desc' => 'Running multi-engine SAST tools to establish baseline vulnerability discovery.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Manual Code Inspection',
        'desc' => 'Line-by-line expert review focused on high-risk modules (Auth, Crypto, Input Parsing, Transactions).',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Triage & False Positive Removal',
        'desc' => 'Validating every finding manually to ensure 100% precision and zero noise.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Actionable Remediation Guidance',
        'desc' => 'Supplying developers with exact file line numbers, diff-ready code patches, and best practices.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Line-by-Line Code Vulnerability Audit Report with Severity Ratings',
      1 => 'Software Bill of Materials (SBOM) and Dependency Risk Matrix',
      2 => 'Code Remediation Snippets and Secure Coding Guidelines',
      3 => 'Executive Code Quality and Security Scorecard',
    ),
    'compliance' => 
    array (
      0 => 'NIST SP 800-64',
      1 => 'ISO 27001 A.14.2',
      2 => 'PCI DSS 6.3 / 6.5',
      3 => 'CWE/SANS Top 25',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'How do you guarantee the confidentiality of our proprietary source code?',
        'a' => 'We execute strict Non-Disclosure Agreements (NDAs), utilize dedicated encrypted review workstations with air-gap capabilities, and purge all client code immediately following review completion.',
      ),
      1 => 
      array (
        'q' => 'Can you review code directly within our GitHub, GitLab, or Bitbucket repositories?',
        'a' => 'Yes, our auditors can be granted read-only access to branch repositories or work from encrypted archives provided by your team.',
      ),
      2 => 
      array (
        'q' => 'How long does a source code review take?',
        'a' => 'Timelines depend on lines of code (LoC) and complexity, typically ranging from 5 to 15 business days for standard codebases.',
      ),
    ),
  ),
  'ecommerce-security' => 
  array (
    'title' => 'E-Commerce & Payment Security Audit',
    'nav_label' => 'Ecommerce Security',
    'category' => 'application-security',
    'badge' => 'PCI DSS & Payment Gateway Hardening',
    'tagline' => 'Protect your digital storefront, checkout funnels, and customer payment information.',
    'short_desc' => 'Specialized security testing for Magento, Shopify Plus, WooCommerce, and custom checkout systems to eliminate Magecart skimmers and cart tampering.',
    'overview' => 'Ecommerce platforms face constant assault from cybercriminals seeking customer payment cards, loyalty points, and merchant account credentials. Our Ecommerce Security assessment safeguards your revenue streams by testing checkout processes, payment gateways, gift card logic, coupon redemption algorithms, and client-side JavaScript integrity to prevent Magecart web skimming attacks.',
    'why_needed' => 'E-commerce breaches result in catastrophic cardholder data theft, mandatory PCI forensic audits, hefty fines, and immediate consumer trust destruction.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Payment Gateway Tampering',
        'desc' => 'Testing price manipulation, currency spoofing, and callback notification tampering.',
      ),
      1 => 
      array (
        'title' => 'Magecart & Web Skimming',
        'desc' => 'Auditing client-side scripts, tags, and third-party trackers for unauthorized code execution.',
      ),
      2 => 
      array (
        'title' => 'Checkout Flow Bypasses',
        'desc' => 'Testing coupon stacking, negative value quantities, and race condition item reserves.',
      ),
      3 => 
      array (
        'title' => 'Customer Account Takeover',
        'desc' => 'Assessing credential stuffing resilience, brute force protections, and 2FA bypasses.',
      ),
      4 => 
      array (
        'title' => 'Platform-Specific Auditing',
        'desc' => 'Deep audits for Magento/Adobe Commerce, WooCommerce, PrestaShop, and headless Commerce.',
      ),
      5 => 
      array (
        'title' => 'PCI DSS 4.0 Alignment',
        'desc' => 'Evaluating requirement compliance for client-side script management (6.4.3 & 11.6.1).',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Storefront Discovery & Mapping',
        'desc' => 'Cataloging all payment plugins, analytics trackers, CDNs, and custom checkout scripts.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Cart & Checkout Logic Testing',
        'desc' => 'Tampering with price fields, parameters, tax calculations, and discount coupons.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Payment Gateway & Webhook Review',
        'desc' => 'Verifying signature verification for Stripe, Razorpay, PayPal, Adyen, and bank APIs.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Client-Side Script Auditing',
        'desc' => 'Analyzing Subresource Integrity (SRI) and Content Security Policy (CSP) headers.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Remediation & PCI Readiness',
        'desc' => 'Hardening checkout pipelines and delivering PCI compliance documentation.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Ecommerce Security & Payment Integrity Audit Report',
      1 => 'Client-Side Script Security & Skimmer Defense Assessment',
      2 => 'Business Logic & Checkout Vulnerability Evidence Dossier',
      3 => 'Merchant PCI Readiness and Attestation Certificate',
    ),
    'compliance' => 
    array (
      0 => 'PCI DSS 4.0',
      1 => 'GDPR Article 32',
      2 => 'Consumer Protection Regulations',
      3 => 'ISO 27001',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Can we test our live ecommerce store without disrupting real customer orders?',
        'a' => 'Yes, our tests are conducted using designated test products, test payment credentials, or on an isolated staging clone of your storefront.',
      ),
      1 => 
      array (
        'q' => 'Do you test third-party Shopify apps or WordPress plugins?',
        'a' => 'Yes, third-party plugins represent the most common vector for ecommerce compromise; we inspect all integrated apps and plugins.',
      ),
      2 => 
      array (
        'q' => 'How does this assist with PCI DSS 4.0 requirements?',
        'a' => 'It directly addresses the new PCI DSS 4.0 requirements for monitoring scripts running in the consumer browser at checkout.',
      ),
    ),
  ),
  'saas-security' => 
  array (
    'title' => 'SaaS Platform Security Assessment',
    'nav_label' => 'Saas Security',
    'category' => 'application-security',
    'badge' => 'Multi-Tenant Isolation & Cloud SaaS Assurance',
    'tagline' => 'Fortify multi-tenant architectures, customer tenant boundaries, and subscription tier security.',
    'short_desc' => 'Specialized penetration testing for SaaS platforms focusing on tenant-to-tenant data cross-contamination, privilege escalation, and API quotas.',
    'overview' => 'Software-as-a-Service (SaaS) providers bear the immense responsibility of housing sensitive data for thousands of corporate customers in shared database and cloud environments. Our SaaS Security assessment tests multi-tenancy boundaries, role-based access control (RBAC), subscription tier gating, webhook integrity, and data isolation mechanisms to guarantee that no tenant can ever observe or manipulate another tenant’s data.',
    'why_needed' => 'A cross-tenant data leak is fatal to a B2B SaaS company, resulting in immediate breach of contract, catastrophic customer churn, and massive legal liability.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Cross-Tenant Isolation',
        'desc' => 'Rigorous testing to confirm absolute tenant separation across databases, S3 buckets, and caches.',
      ),
      1 => 
      array (
        'title' => 'Feature & Tier Gating',
        'desc' => 'Verifying that free-tier accounts cannot access enterprise features through parameter manipulation.',
      ),
      2 => 
      array (
        'title' => 'SSO & SAML/OIDC Audits',
        'desc' => 'Testing enterprise identity integration, SAML response tampering, and SCIM provisioning.',
      ),
      3 => 
      array (
        'title' => 'Subscription & Billing APIs',
        'desc' => 'Ensuring quota enforcement, plan limits, and secure stripe/billing webhook callbacks.',
      ),
      4 => 
      array (
        'title' => 'Audit Logging & Forensic Readiness',
        'desc' => 'Verifying that tenant administrative actions are immutably logged and exportable.',
      ),
      5 => 
      array (
        'title' => 'SOC 2 & ISO Preparation',
        'desc' => 'Delivering testing reports required by enterprise procurement and security questionnaires.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Architecture & Multi-Tenancy Scoping',
        'desc' => 'Mapping shared vs. dedicated tenant databases, microservices, and identity providers.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Tenant Separation Testing',
        'desc' => 'Simulating Tenant A attacking Tenant B through IDORs, API manipulation, and cache poisoned attacks.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Enterprise SSO & Federation',
        'desc' => 'Analyzing SAML assertions, XML signature wrapping, OAuth state parameters, and token lifetimes.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Export & Data Privacy Controls',
        'desc' => 'Verifying tenant data deletion requests (GDPR Right to Be Forgotten) and backup isolation.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Vendor Questionnaire Package',
        'desc' => 'Preparing customer-facing security whitepaper and third-party audit letter.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'SaaS Multi-Tenancy Security Assessment Report',
      1 => 'Cross-Tenant Isolation Verification Dossier',
      2 => 'Enterprise Security Due Diligence Summary (for your sales prospects)',
      3 => 'Certificate of SaaS Application Security',
    ),
    'compliance' => 
    array (
      0 => 'SOC 2 Type II Security & Confidentiality',
      1 => 'ISO 27001',
      2 => 'GDPR',
      3 => 'CSA Cloud Controls Matrix (CCM)',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Can we provide your report to prospective enterprise buyers requesting security audits?',
        'a' => 'Yes! We provide an executive attestation letter specifically designed for enterprise procurement and security questionnaires.',
      ),
      1 => 
      array (
        'q' => 'How do you test multi-tenancy?',
        'a' => 'We provision multiple test accounts across different subscription tiers and attempt unauthorized cross-tenant data access, modification, and administrative takeovers.',
      ),
      2 => 
      array (
        'q' => 'Do you evaluate our AWS/Azure/GCP hosting infrastructure as part of SaaS testing?',
        'a' => 'We can bundle Cloud Configuration Review with SaaS penetration testing for complete end-to-end assurance.',
      ),
    ),
  ),
  'devsecops' => 
  array (
    'title' => 'DevSecOps & CI/CD Pipeline Assurance',
    'nav_label' => 'DevSecOps',
    'category' => 'application-security',
    'badge' => 'Shift-Left CI/CD Pipeline Automation',
    'tagline' => 'Embed automated security checks, vulnerability gates, and compliance directly into your build pipelines.',
    'short_desc' => 'Transforming DevOps pipelines into automated DevSecOps engines integrating SAST, DAST, SCA, container scanning, and infrastructure-as-code linting.',
    'overview' => 'Fast release velocity shouldn’t come at the cost of software security. Our DevSecOps Consulting service helps development organizations shift security left by embedding automated scanning gates directly into GitHub Actions, GitLab CI, Jenkins, Azure DevOps, and Bitbucket. We empower your developers to catch and fix vulnerabilities in pull requests before code reaches staging or production.',
    'why_needed' => 'Manual security reviews right before release create severe bottlenecks and developer frustration. Automated DevSecOps prevents security debt from accumulating and slashes vulnerability remediation costs by up to 80%.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'CI/CD Pipeline Security Gates',
        'desc' => 'Configuring automated build breaks based on CVSS thresholds in GitHub, GitLab, Jenkins, etc.',
      ),
      1 => 
      array (
        'title' => 'Automated SAST & SCA',
        'desc' => 'Integrating open-source and commercial static analysis and dependency vulnerability scanners.',
      ),
      2 => 
      array (
        'title' => 'Secret Scanning & Prevention',
        'desc' => 'Enforcing pre-commit hooks that block developers from accidentally committing API keys and tokens.',
      ),
      3 => 
      array (
        'title' => 'Infrastructure-as-Code (IaC) Audits',
        'desc' => 'Scanning Terraform, CloudFormation, and Ansible templates for security misconfigurations.',
      ),
      4 => 
      array (
        'title' => 'Container Image Scanning',
        'desc' => 'Automated Dockerfile and container registry scanning for base image CVEs and malicious packages.',
      ),
      5 => 
      array (
        'title' => 'Developer Security Training',
        'desc' => 'Upskilling software engineers in threat modeling and secure coding best practices.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'DevOps Pipeline Maturity Assessment',
        'desc' => 'Auditing existing build tools, branching strategies, artifact registries, and deployment workflows.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Toolchain Selection & Architecture',
        'desc' => 'Selecting lightweight, high-accuracy tools tailored to your language and cloud ecosystem.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Pipeline Integration & Policy Definition',
        'desc' => 'Implementing pre-commit, build, and deploy-stage security gates with sensible failure thresholds.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Vulnerability Management Dashboard',
        'desc' => 'Centralizing scanner findings into DefectDojo, Jira, or centralized security hubs.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Developer Enablement & Handover',
        'desc' => 'Conducting workshops to ensure development teams own and understand pipeline alerts.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'DevSecOps Maturity Assessment & Gap Analysis Report',
      1 => 'Fully Configured and Automated CI/CD Pipeline Security Workflows',
      2 => 'Infrastructure as Code (IaC) Security Baseline Policy Pack',
      3 => 'Secure Coding Guidelines & Developer Training Documentation',
    ),
    'compliance' => 
    array (
      0 => 'NIST SP 800-218 (SSDF)',
      1 => 'SLSA Framework Level 3',
      2 => 'ISO 27001 A.14.2.8',
      3 => 'CIS Software Supply Chain Security',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Will adding security tools slow down our developers’ daily build times?',
        'a' => 'No. We design optimized multi-stage pipelines where fast scans (secrets, linting) run on PRs, while deeper SAST/DAST scans run asynchronously or on nightly merges.',
      ),
      1 => 
      array (
        'q' => 'Which CI/CD platforms do you support?',
        'a' => 'We support GitHub Actions, GitLab CI, Jenkins, Azure DevOps, Bitbucket Pipelines, CircleCI, and ArgoCD.',
      ),
      2 => 
      array (
        'q' => 'Do you help write custom rules for our proprietary frameworks?',
        'a' => 'Yes, we create custom Semgrep or CodeQL rules tailored to your internal APIs and architecture.',
      ),
    ),
  ),
  'network-penetration-testing' => 
  array (
    'title' => 'External & Internal Network Pen Testing',
    'nav_label' => 'Network Penetration Testing',
    'category' => 'network-security',
    'badge' => 'Internal & External Infrastructure Audit',
    'tagline' => 'Identify network entry points, unpatched servers, and lateral movement paths.',
    'short_desc' => 'Simulating real-world external and internal network attacks to uncover perimeter breaches, Active Directory weaknesses, and network segmentation flaws.',
    'overview' => 'Your corporate network connects every workstation, server, database, and employee laptop. Our Network Penetration Testing evaluates both your external perimeter (public IPs, VPN gateways, DNS, edge routers) and internal environment (Active Directory, Kerberos, internal VLANs, workstation subnets). We demonstrate how an attacker can breach the perimeter or compromise an entire enterprise domain starting from a single rogue workstation.',
    'why_needed' => 'Ransomware syndicates leverage network misconfigurations and outdated services to establish persistence and encrypt enterprise networks within hours. Testing validates your segmentation and defensive detection capabilities.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'External Perimeter Testing',
        'desc' => 'Evaluating exposed ports, legacy services, VPN concentrators, and internet-facing assets.',
      ),
      1 => 
      array (
        'title' => 'Internal Active Directory Audits',
        'desc' => 'Testing Kerberoasting, AS-REP roasting, unconstrained delegation, and Domain Admin escalation.',
      ),
      2 => 
      array (
        'title' => 'Lateral Movement Simulation',
        'desc' => 'Demonstrating how an attacker moves between subnets, VLANs, and compromised servers.',
      ),
      3 => 
      array (
        'title' => 'Network Segmentation Testing',
        'desc' => 'Validating that sensitive zones (PCI CDE, ICS, executive subnets) are strictly isolated.',
      ),
      4 => 
      array (
        'title' => 'Egress & Data Exfiltration Tests',
        'desc' => 'Assessing outbound filtering and data loss prevention (DLP) across internal egress points.',
      ),
      5 => 
      array (
        'title' => 'Defense Evasion & EDR Testing',
        'desc' => 'Measuring how effectively your SIEM/SOC detects automated and manual network recon.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Discovery & Asset Enumeration',
        'desc' => 'Port scanning, service identification, and mapping network topology and firewall boundaries.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Vulnerability Verification',
        'desc' => 'Testing for default credentials, outdated SSL/TLS ciphers, and unpatched CVEs.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Exploitation & Initial Foothold',
        'desc' => 'Exploiting exposed services or credential weaknesses to establish a controlled beachhead.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Privilege Escalation & Domain Dominance',
        'desc' => 'Extracting hashes, exploiting AD misconfigurations, and validating impact on critical systems.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Remediation & Architecture Hardening',
        'desc' => 'Delivering network zoning guidelines, GPO hardening templates, and re-testing.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Comprehensive Network Penetration Testing Report',
      1 => 'Network Topology Risk Map and Attack Path Diagrams',
      2 => 'Active Directory Security Hardening Playbook',
      3 => 'Certificate of Network Security Attestation',
    ),
    'compliance' => 
    array (
      0 => 'PCI DSS Requirement 11.3',
      1 => 'ISO 27001 Annex A.13',
      2 => 'NIST SP 800-53 (CA-8)',
      3 => 'CIS Controls v8 (Control 18)',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'What is the difference between External and Internal Network Penetration Testing?',
        'a' => 'External testing evaluates what an attacker on the public internet can see and breach. Internal testing simulates the scenario where an attacker has already bypassed the perimeter (or is a rogue employee or malware) inside the corporate LAN.',
      ),
      1 => 
      array (
        'q' => 'Do you exploit Active Directory vulnerabilities?',
        'a' => 'Yes, we test modern AD attacks such as BloodHound path analysis, DCSync, pass-the-hash, and Certificate Services (AD CS) misconfigurations.',
      ),
      2 => 
      array (
        'q' => 'Can testing be scheduled during off-hours or weekends?',
        'a' => 'Yes, we regularly perform testing during designated low-traffic maintenance windows to ensure zero impact on day-to-day operations.',
      ),
    ),
  ),
  'wireless-penetration-testing' => 
  array (
    'title' => 'Wireless & Wi-Fi Security Assessment',
    'nav_label' => 'Wireless Penetration Testing',
    'category' => 'network-security',
    'badge' => '802.11 Wi-Fi & WPA2/WPA3 Enterprise',
    'tagline' => 'Prevent rogue access points, credential theft, and wireless air-gap breaches.',
    'short_desc' => 'On-site and remote wireless audits evaluating WPA2/WPA3 Enterprise configs, rogue access points, Evil Twin attacks, and guest Wi-Fi isolation.',
    'overview' => 'Wireless signals extend beyond physical office walls, providing attackers with a covert bridge into internal corporate networks without setting foot inside your facilities. Our Wireless Penetration Testing assesses corporate Wi-Fi, guest networks, IoT wireless controllers, and Bluetooth perimeters. We test for weak pre-shared keys, rogue access points, Evil Twin sniffing attacks, RADIUS configuration flaws, and guest network VLAN leakage.',
    'why_needed' => 'Poorly configured guest Wi-Fi or compromised wireless access points allow drive-by attackers in parking lots to intercept unencrypted traffic and infiltrate internal databases.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'WPA2/WPA3 Enterprise Security',
        'desc' => 'Evaluating RADIUS server certificate validation, PEAP/EAP-TLS configurations, and cipher suites.',
      ),
      1 => 
      array (
        'title' => 'Rogue AP & Evil Twin Attacks',
        'desc' => 'Simulating fake captive portals and Evil Twin hotspots to test employee credential theft.',
      ),
      2 => 
      array (
        'title' => 'Guest Wi-Fi Isolation Audits',
        'desc' => 'Verifying that guest Wi-Fi users are strictly segregated and cannot pivot to corporate servers.',
      ),
      3 => 
      array (
        'title' => 'Signal Bleed & Boundary Mapping',
        'desc' => 'Mapping RF signal propagation outside office perimeter boundaries using directional antennas.',
      ),
      4 => 
      array (
        'title' => 'Deauthentication & DoS Testing',
        'desc' => 'Testing network resilience against management frame spoofing and wireless denial-of-service.',
      ),
      5 => 
      array (
        'title' => 'Bluetooth & IoT Wireless Protocols',
        'desc' => 'Auditing Bluetooth Low Energy (BLE), Zigbee, and proprietary wireless sensor links.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Spectrum Analysis & Reconnaissance',
        'desc' => 'Detecting all SSIDs, BSSIDs, hidden channels, client devices, and wireless equipment.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'WPA Handshake & PSK Capture',
        'desc' => 'Capturing 4-way handshakes and PMKID hashes to evaluate password entropy and cracking resilience.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Rogue AP & De-Auth Simulation',
        'desc' => 'Evaluating captive portal security and simulating credential harvesting campaigns.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'VLAN Hopping & Guest Pivot',
        'desc' => 'Testing if authenticated guest devices can route packets into private corporate subnets.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Wireless Hardening Strategy',
        'desc' => 'Delivering WPA3 migration strategies, RADIUS hardening, and rogue AP detection policies.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Wireless Security Assessment & RF Exposure Report',
      1 => 'VLAN Isolation & Guest Network Penetration Findings',
      2 => 'Wireless Access Controller (WLC) Hardening Recommendations',
      3 => 'Official Compliance Certificate for Wireless Infrastructure',
    ),
    'compliance' => 
    array (
      0 => 'PCI DSS Requirement 11.1 / 11.2',
      1 => 'ISO 27001 A.13.1',
      2 => 'NIST SP 800-153',
      3 => 'CIS Wireless Security Standards',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Do you need to be physically on-site to conduct wireless penetration testing?',
        'a' => 'Testing can be performed on-site by our security engineers or remotely by deploying our pre-configured, encrypted wireless sensor hardware box to your office.',
      ),
      1 => 
      array (
        'q' => 'Does this testing satisfy PCI DSS requirement 11.1?',
        'a' => 'Yes, PCI DSS mandates quarterly detection of unauthorized wireless access points; our comprehensive test satisfies both detection and penetration testing requirements.',
      ),
      2 => 
      array (
        'q' => 'Can you test multiple branch offices?',
        'a' => 'Yes, we test centralized wireless architectures across multiple branches, warehouses, and campus facilities.',
      ),
    ),
  ),
  'firewall-security-audit' => 
  array (
    'title' => 'Firewall & Perimeter Rulebase Audit',
    'nav_label' => 'Firewall Security Audit',
    'category' => 'network-security',
    'badge' => 'Next-Gen Firewall (NGFW) & Rule Review',
    'tagline' => 'Eliminate shadow rules, overly permissive policies, and unmonitored backdoors.',
    'short_desc' => 'Deep configuration review and policy analysis of Next-Gen Firewalls (Palo Alto, Fortinet, Check Point, Cisco) to remove security bloat and enforce least privilege.',
    'overview' => 'Over years of operational churn, enterprise firewalls accumulate thousands of legacy rules, overlapping policies, and dangerous ANY-ANY allowances. Our Firewall Security Audit performs a comprehensive line-by-line inspection of your firewall configuration, rule base, NAT tables, VPN tunnels, and intrusion prevention policies. We identify redundant rules, exposed admin interfaces, weak cryptographic suites, and segmentation failures.',
    'why_needed' => '99% of firewall breaches are caused not by firewall flaws, but by firewall misconfigurations. A regular firewall audit ensures that your edge defenses enforce strict zero-trust boundaries.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Rule Base Optimization',
        'desc' => 'Detecting shadowed, redundant, unused, and conflicting access control list (ACL) rules.',
      ),
      1 => 
      array (
        'title' => 'Dangerous Permissive Rules',
        'desc' => 'Pinpointing broad ANY-ANY rules, overly permissive port allowances, and unconstrained egress.',
      ),
      2 => 
      array (
        'title' => 'Next-Gen Feature Validation',
        'desc' => 'Auditing SSL/TLS decryption, App-ID, IPS signatures, DNS security, and anti-malware profiles.',
      ),
      3 => 
      array (
        'title' => 'VPN Tunnel Hardening',
        'desc' => 'Inspecting IPsec Phase 1/Phase 2 proposals, SSL VPN MFA configurations, and split-tunneling.',
      ),
      4 => 
      array (
        'title' => 'Multi-Vendor Support',
        'desc' => 'Expertise in Palo Alto Networks, Fortinet FortiGate, Check Point, Cisco Firepower, and pfSense.',
      ),
      5 => 
      array (
        'title' => 'Audit & Compliance Alignment',
        'desc' => 'Mapping rules to PCI DSS, ISO 27001, and NIST firewall compliance checklists.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Configuration Extraction & Rule Ingestion',
        'desc' => 'Gathering sanitized rule configs, NAT tables, object groups, and firmware release notes.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Automated Policy Analysis',
        'desc' => 'Parsing rules to map hit counts, expired rules, and security policy anomalies.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Manual Architecture & Risk Review',
        'desc' => 'Senior firewall architect evaluation of DMZ zoning, management interface security, and HA pairs.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Rule Cleanup & Zero-Trust Mapping',
        'desc' => 'Formulating a safe, step-by-step rule pruning and modernization plan.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Remediation Roadmap & Re-Audit',
        'desc' => 'Validating the tightened rule base with validation port checks and sign-off.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Firewall Policy Optimization & Risk Audit Report',
      1 => 'Redundant, Shadowed, and Insecure Rules Pruning List',
      2 => 'Next-Gen Security Feature Enabling & Hardening Guide',
      3 => 'Firewall Compliance Attestation Document',
    ),
    'compliance' => 
    array (
      0 => 'PCI DSS Requirement 1',
      1 => 'NIST SP 800-41 Rev 1',
      2 => 'ISO 27001 A.13.1.1',
      3 => 'CIS Firewall Benchmark',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Do we need to give you administrative access to our production firewalls?',
        'a' => 'No. You can provide an exported, sanitized configuration backup file (XML, conf, or text format) without sharing live administrative credentials.',
      ),
      1 => 
      array (
        'q' => 'Which firewall manufacturers can you audit?',
        'a' => 'We audit Palo Alto Networks, Fortinet, Check Point, Cisco ASA/Firepower, Juniper, Sophos, SonicWall, AWS Security Groups, and Azure Network Security Groups.',
      ),
      2 => 
      array (
        'q' => 'Will the audit result in changes that could break our production services?',
        'a' => 'No changes are made during the audit. We provide prioritized recommendations so your network engineers can review and schedule changes safely during maintenance windows.',
      ),
    ),
  ),
  'cloud-configuration-review' => 
  array (
    'title' => 'Cloud Security Posture Assessment (CSPM)',
    'nav_label' => 'Cloud Configuration Review',
    'category' => 'cloud-security',
    'badge' => 'AWS, Azure, & GCP Cloud Security Posture',
    'tagline' => 'Eliminate publicly exposed storage buckets, IAM over-privileging, and cloud infrastructure flaws.',
    'short_desc' => 'Comprehensive security posture audit across AWS, Microsoft Azure, and Google Cloud Platform against CIS Cloud Benchmarks to eliminate cloud breaches.',
    'overview' => 'The shared responsibility model dictates that securing cloud configurations, access keys, and storage buckets rests squarely on your organization. Our Cloud Configuration Review evaluates your AWS, Microsoft Azure, and Google Cloud Platform (GCP) tenancies. We identify publicly exposed S3/Blob storage, overly permissive IAM roles, unencrypted databases, missing audit logging, and insecure network routing.',
    'why_needed' => 'Over 95% of cloud security breaches stem from customer configuration mistakes rather than cloud provider vulnerabilities. A cloud audit stops catastrophic data leaks before they occur.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Multi-Cloud Expertise',
        'desc' => 'Deep technical reviews across Amazon Web Services (AWS), Microsoft Azure, and Google Cloud (GCP).',
      ),
      1 => 
      array (
        'title' => 'IAM & Privilege Escalation',
        'desc' => 'Auditing IAM roles, service accounts, cross-account trust relationships, and excessive privileges.',
      ),
      2 => 
      array (
        'title' => 'Public Exposure Detection',
        'desc' => 'Pinpointing internet-accessible databases (RDS, Cloud SQL), storage buckets, and open ports.',
      ),
      3 => 
      array (
        'title' => 'Cloud Encryption Audits',
        'desc' => 'Verifying KMS customer-managed keys, disk encryption, and data-in-transit TLS enforcement.',
      ),
      4 => 
      array (
        'title' => 'Audit Logging & Visibility',
        'desc' => 'Confirming CloudTrail, GuardDuty, Azure Monitor, and Cloud Logging are tamper-proof and active.',
      ),
      5 => 
      array (
        'title' => 'Infrastructure-as-Code Integration',
        'desc' => 'Auditing Terraform, CloudFormation, and Bicep scripts to enforce security baselines.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Cloud Tenancy & Scope Definition',
        'desc' => 'Granting read-only audit roles to designated cloud accounts, subscriptions, or projects.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Automated CSPM Policy Scanning',
        'desc' => 'Running multi-engine policy compliance scans against CIS Cloud Benchmarks.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Manual Architecture & Privilege Deep-Dive',
        'desc' => 'Expert manual investigation of VPC peering, transit gateways, IAM roles, and serverless lambdas.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Risk Prioritization & Remediation',
        'desc' => 'Categorizing findings into Critical, High, Medium with CLI and console remediation steps.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Validation Re-Scan & Attestation',
        'desc' => 'Re-evaluating repaired cloud controls and issuing compliance certificates.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Multi-Cloud Security Posture Assessment & Gap Report',
      1 => 'CIS Cloud Benchmark Detailed Scorecards (AWS / Azure / GCP)',
      2 => 'Step-by-Step Remediation CLI Commands & Terraform Fixes',
      3 => 'Official Certificate of Cloud Security Compliance',
    ),
    'compliance' => 
    array (
      0 => 'CIS AWS Foundations Benchmark',
      1 => 'CIS Microsoft Azure Benchmark',
      2 => 'CIS Google Cloud Computing Platform Benchmark',
      3 => 'ISO 27017',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'What level of access do you need to audit our cloud accounts?',
        'a' => 'We require strictly Read-Only programmatic access using standard security audit roles (e.g., SecurityAudit on AWS, Reader on Azure). We never ask for write or administrative credentials.',
      ),
      1 => 
      array (
        'q' => 'Can you review multi-cloud or hybrid environments?',
        'a' => 'Yes, our team specializes in complex enterprise environments spanning AWS, Azure, GCP, and on-premises datacenters.',
      ),
      2 => 
      array (
        'q' => 'Do you provide Infrastructure as Code (IaC) fixes?',
        'a' => 'Yes, we provide ready-to-merge Terraform or CloudFormation code snippets that fix misconfigurations permanently in code.',
      ),
    ),
  ),
  'cloud-application-security-assessment-casa' => 
  array (
    'title' => 'Cloud App Security Assessment (CASA Tier 2/3)',
    'nav_label' => 'Cloud Application Security Assessment(CASA)',
    'category' => 'cloud-security',
    'badge' => 'Google Cloud Tier 2 / Tier 3 Application Security',
    'tagline' => 'Achieve official Google App verification and OAuth partner compliance.',
    'short_desc' => 'Authorized Cloud Application Security Assessment (CASA) aligned with Google and App Defense Alliance standards for apps integrating with Google Workspace & Cloud APIs.',
    'overview' => 'Organizations developing applications that access restricted or sensitive Google APIs (Gmail, Google Drive, Google Calendar, Google Cloud) are mandated by Google to undergo an annual Cloud Application Security Assessment (CASA). Based on the OWASP Application Security Verification Standard (ASVS), CASA verifies that your application and cloud infrastructure handle user tokens and data securely. We guide your engineering team to 100% CASA pass verification.',
    'why_needed' => 'Without verified CASA validation, Google revokes app verification status, triggering alarming "Unverified App" warning screens that block enterprise customers from authenticating.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Google CASA Framework',
        'desc' => 'Full alignment with Tier 2 and Tier 3 requirements established by the App Defense Alliance.',
      ),
      1 => 
      array (
        'title' => 'OAuth Scope & Token Security',
        'desc' => 'Validating secure handling of Google access tokens, refresh tokens, and least privilege scopes.',
      ),
      2 => 
      array (
        'title' => 'Application Vulnerability Testing',
        'desc' => 'Testing against OWASP ASVS Level 2 requirements for web and mobile components.',
      ),
      3 => 
      array (
        'title' => 'Cloud Infrastructure Hardening',
        'desc' => 'Validating that backend servers hosting the app adhere to cloud security baselines.',
      ),
      4 => 
      array (
        'title' => 'Third-Party Library Review',
        'desc' => 'Auditing application dependencies for known high-severity CVEs.',
      ),
      5 => 
      array (
        'title' => 'PwC / Bishop Fox / Direct CASA Submission',
        'desc' => 'Packaging evidence artifacts ready for immediate submission to authorized CASA validation portals.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'CASA Scoping & Tier Determination',
        'desc' => 'Reviewing requested Google OAuth scopes and determining exact CASA tier requirements.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Application & Cloud Penetration Testing',
        'desc' => 'Conducting dynamic and static tests against in-scope CASA controls.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Vulnerability Remediation Guidance',
        'desc' => 'Assisting developers to rapidly patch any CWEs or security flags.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'CASA Evidence Compilation',
        'desc' => 'Compiling scan results, architectural documentation, and questionnaire responses.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Submission Support & Google Validation',
        'desc' => 'Liaising with the CASA validation platform until Google verification is officially granted.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Official Cloud Application Security Assessment (CASA) Report',
      1 => 'OWASP ASVS Verification Matrix & Evidence Files',
      2 => 'CASA Portal Submission Package (JSON/PDF)',
      3 => 'Certificate of CASA Security Compliance',
    ),
    'compliance' => 
    array (
      0 => 'Google CASA Tier 2 & Tier 3',
      1 => 'App Defense Alliance Standards',
      2 => 'OWASP ASVS Level 2',
      3 => 'Google API Services User Data Policy',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Why does Google require a CASA assessment for our application?',
        'a' => 'Google mandates CASA for applications that request "Restricted" or "Sensitive" OAuth scopes (such as accessing a user’s Gmail inbox, Drive files, or Google Cloud storage) to protect end-user data.',
      ),
      1 => 
      array (
        'q' => 'How often must CASA assessments be renewed?',
        'a' => 'Google requires that CASA assessments be completed and re-verified annually.',
      ),
      2 => 
      array (
        'q' => 'What happens if our application fails the initial scan?',
        'a' => 'We perform a preliminary assessment to identify and help your developers fix all issues before the official evidence submission, ensuring a smooth first-pass verification.',
      ),
    ),
  ),
  'cloud-container-security' => 
  array (
    'title' => 'Docker & Kubernetes Container Security',
    'nav_label' => 'Container Security',
    'category' => 'cloud-security',
    'badge' => 'Kubernetes (K8s), Docker, & EKS/GKE/AKS',
    'tagline' => 'Harden cloud-native Kubernetes clusters, service meshes, and microservices.',
    'short_desc' => 'In-depth security assessment for managed Kubernetes clusters (EKS, GKE, AKS) and Docker container pipelines against CIS Kubernetes Benchmarks.',
    'overview' => 'Modern cloud applications run on microservice architectures orchestrated by Kubernetes. However, complex container networks, service accounts, and cluster misconfigurations introduce unprecedented attack vectors. Our Cloud Container Security service assesses your managed Kubernetes clusters (Amazon EKS, Google GKE, Azure AKS, self-hosted K8s), validating RBAC policies, network policies, Pod Security Standards, secrets management, and container runtime isolation.',
    'why_needed' => 'Misconfigured Kubernetes API servers and over-privileged service accounts allow attackers to compromise entire cloud clusters, deploy crypto-miners, and exfiltrate tenant databases.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Managed K8s Cluster Audits',
        'desc' => 'Hardening Amazon EKS, Google GKE, Azure AKS, and OpenShift clusters against CIS benchmarks.',
      ),
      1 => 
      array (
        'title' => 'Kubernetes RBAC Verification',
        'desc' => 'Auditing cluster roles, role bindings, and service account tokens for privilege escalation.',
      ),
      2 => 
      array (
        'title' => 'Pod Security Standards (PSS)',
        'desc' => 'Enforcing Restricted Pod Security Standards, blocking root containers and privileged host mounts.',
      ),
      3 => 
      array (
        'title' => 'Network Policy Micro-Segmentation',
        'desc' => 'Validating Calico or Cilium network policies to prevent unauthorized East-West pod traffic.',
      ),
      4 => 
      array (
        'title' => 'Secrets Management Auditing',
        'desc' => 'Ensuring secrets are not stored in plaintext in etcd and integrating HashiCorp Vault or cloud KMS.',
      ),
      5 => 
      array (
        'title' => 'Admission Controller Enforcement',
        'desc' => 'Deploying OPA Gatekeeper or Kyverno policies to block vulnerable container deployments.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Cluster Scoping & Topology Discovery',
        'desc' => 'Cataloging namespaces, node groups, ingress controllers, service meshes, and cloud IAM integrations.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Control Plane & Worker Node Audit',
        'desc' => 'Auditing API server flags, kubelet configs, and etcd encryption against CIS K8s Benchmarks.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Pod Security & Runtime Testing',
        'desc' => 'Attempting container breakouts, host namespace escapes, and metadata service credential theft.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Network Policy & Service Mesh Inspection',
        'desc' => 'Testing inter-pod network isolation and mutual TLS (mTLS) configuration (Istio/Linkerd).',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Hardening Blueprint & Policy Deployment',
        'desc' => 'Delivering admission policies, network rules, and CIS-hardened cluster templates.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Kubernetes & Cloud Container Security Audit Report',
      1 => 'CIS Kubernetes Benchmark Detailed Assessment Findings',
      2 => 'OPA Gatekeeper / Kyverno Security Policy Library',
      3 => 'Official Cloud Container Security Attestation',
    ),
    'compliance' => 
    array (
      0 => 'CIS Kubernetes Benchmark',
      1 => 'NIST SP 800-190',
      2 => 'PCI DSS for Cloud Containers',
      3 => 'ISO 27017',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Can you audit our clusters without impacting live production traffic?',
        'a' => 'Yes. Our assessment utilizes read-only administrative inspection and non-disruptive validation checks designed specifically for production uptime.',
      ),
      1 => 
      array (
        'q' => 'Do you test self-hosted Kubernetes or only managed cloud services?',
        'a' => 'We test all Kubernetes flavors, including self-hosted K8s, Amazon EKS, Google GKE, Azure AKS, and Red Hat OpenShift.',
      ),
      2 => 
      array (
        'q' => 'How do you check for container vulnerabilities?',
        'a' => 'We inspect both cluster configurations and container image registries, analyzing Dockerfiles, base images, and CI/CD promotion gates.',
      ),
    ),
  ),
  'gcp-server-hardening' => 
  array (
    'title' => 'Google Cloud (GCP) Security Hardening',
    'nav_label' => 'GCP Server Hardening',
    'category' => 'cloud-security',
    'badge' => 'Google Cloud Compute Engine & CIS OS Hardening',
    'tagline' => 'Harden Google Cloud virtual machines against unauthorized access and lateral movement.',
    'short_desc' => 'Comprehensive server hardening for GCP Compute Engine VM instances, OS Login, Shielded VMs, and VPC Service Controls against CIS Benchmarks.',
    'overview' => 'Virtual machines running on Google Cloud Platform (GCP) Compute Engine serve as the workhorses for enterprise workloads. However, default configurations often leave service account tokens accessible, SSH keys scattered, and internal ports exposed. Our GCP Server Hardening service locks down Compute Engine instances, implements Shielded VMs (Secure Boot, vTPM), configures OS Login, enables Cloud KMS customer-managed encryption, and establishes strict VPC firewall policies.',
    'why_needed' => 'Unprotected GCP instances with default compute engine service accounts allow compromised virtual machines to access other cloud resources and Google Cloud APIs.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'CIS Operating System Hardening',
        'desc' => 'Hardening Linux and Windows VMs on GCP against CIS Level 1 and Level 2 baselines.',
      ),
      1 => 
      array (
        'title' => 'GCP Shielded VM Deployment',
        'desc' => 'Enabling Secure Boot, Virtual Trusted Platform Module (vTPM), and integrity monitoring.',
      ),
      2 => 
      array (
        'title' => 'OS Login & IAM-Based SSH',
        'desc' => 'Eliminating static SSH keys across VMs by enforcing centralized IAM-based OS Login and 2FA.',
      ),
      3 => 
      array (
        'title' => 'Service Account Token Protection',
        'desc' => 'Restricting metadata server access to prevent stolen compute engine service account credentials.',
      ),
      4 => 
      array (
        'title' => 'VPC Firewall & Cloud IAP',
        'desc' => 'Removing public IP addresses from backend VMs and routing SSH/RDP exclusively through Identity-Aware Proxy.',
      ),
      5 => 
      array (
        'title' => 'Automated Golden Images',
        'desc' => 'Building immutable, pre-hardened custom machine images using Packer and Google Cloud Build.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Compute Engine Inventory & Scope',
        'desc' => 'Discovering all active VM instances, service accounts, public IPs, and firewall rules across GCP projects.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'OS Baseline Security Auditing',
        'desc' => 'Scanning VM configurations against CIS OS benchmarks and GCP security best practices.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Network & Metadata Hardening',
        'desc' => 'Disabling default service accounts, enforcing metadata protection, and configuring Cloud IAP.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Operating System Hardening Rollout',
        'desc' => 'Applying kernel hardening, service disabling, firewall rules, and OS Login policies.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Golden Image Baking & Validation',
        'desc' => 'Generating hardened custom machine images for automated autoscaling deployment.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'GCP Compute Engine Security Hardening Audit Report',
      1 => 'Automated Cloud IAP & OS Login Architecture Guide',
      2 => 'Pre-Hardened GCP Golden Machine Image (Packer / Terraform Template)',
      3 => 'Certificate of Google Cloud Server Security Compliance',
    ),
    'compliance' => 
    array (
      0 => 'CIS Google Cloud Computing Platform Benchmark',
      1 => 'CIS OS Benchmarks',
      2 => 'NIST SP 800-123',
      3 => 'ISO 27017',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'What is GCP Identity-Aware Proxy (IAP) for TCP forwarding?',
        'a' => 'Cloud IAP allows your administrators to securely connect to VM instances via SSH or RDP over the internet without the virtual machines having public IP addresses or exposing open ports.',
      ),
      1 => 
      array (
        'q' => 'Can you harden both Linux and Windows virtual machines on GCP?',
        'a' => 'Yes, we harden all major enterprise operating systems on GCP, including Ubuntu, RHEL, Debian, Rocky Linux, and Windows Server 2019/2022.',
      ),
      2 => 
      array (
        'q' => 'Does hardening break GCP Guest Environment tools?',
        'a' => 'No. Our hardening templates are specifically engineered for Google Cloud, preserving essential guest environment agent daemons while removing security risks.',
      ),
    ),
  ),
  'aws-server-hardening' => 
  array (
    'title' => 'Amazon Web Services (AWS) Hardening',
    'nav_label' => 'AWS Server Hardening',
    'category' => 'cloud-security',
    'badge' => 'Amazon EC2, IMDSv2, & Systems Manager',
    'tagline' => 'Fortify Amazon Web Services EC2 instances, AMI golden images, and AWS Systems Manager.',
    'short_desc' => 'Enterprise hardening for Amazon EC2 virtual machines, enforcing IMDSv2, AWS Systems Manager Session Manager, and CIS Operating System Benchmarks.',
    'overview' => 'Amazon Elastic Compute Cloud (EC2) instances are primary targets for ransomware, data theft, and cryptojacking. Insecure Instance Metadata Service (IMDSv1) configurations have famously enabled catastrophic cloud breaches (such as the Capital One SSRF compromise). Our AWS Server Hardening service enforces mandatory IMDSv2, eliminates bastion hosts in favor of AWS Systems Manager (SSM) Session Manager, hardens operating systems against CIS benchmarks, and locks down Security Groups.',
    'why_needed' => 'Default EC2 configurations frequently expose instances to SSRF metadata attacks and open port 22/3389 scans, giving attackers a direct path into your private VPC.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Enforce IMDSv2 Universally',
        'desc' => 'Disabling vulnerable IMDSv1 to completely eliminate Server-Side Request Forgery (SSRF) metadata theft.',
      ),
      1 => 
      array (
        'title' => 'AWS Systems Manager (SSM)',
        'desc' => 'Eliminating open inbound SSH/RDP ports and bastion hosts using encrypted SSM Session Manager.',
      ),
      2 => 
      array (
        'title' => 'CIS OS Hardening Benchmarks',
        'desc' => 'Locking down Amazon Linux 2/2023, Ubuntu, Red Hat, and Windows Server instances.',
      ),
      3 => 
      array (
        'title' => 'EBS Encryption with Customer KMS',
        'desc' => 'Enforcing default EBS volume encryption at rest using AWS KMS Customer Managed Keys (CMKs).',
      ),
      4 => 
      array (
        'title' => 'EC2 Image Builder Pipelines',
        'desc' => 'Automating hardened Golden AMI creation with continuous security patching and verification.',
      ),
      5 => 
      array (
        'title' => 'Least-Privilege IAM Instance Profiles',
        'desc' => 'Pruning excessive permissions from IAM roles attached to running EC2 instances.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'EC2 Fleet Discovery & Security Audit',
        'desc' => 'Auditing all running instances, AMIs, attached IAM instance profiles, and Security Groups.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'IMDSv2 & Metadata Remediation',
        'desc' => 'Enforcing HttpTokens=required across all launch templates and active EC2 instances.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Operating System Hardening',
        'desc' => 'Applying CIS Level 1/Level 2 OS hardening scripts to disable insecure daemons and apply kernel tuning.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'SSM Migration & Security Group Lock',
        'desc' => 'Closing inbound port 22/3389 rules and onboarding instances to Systems Manager.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Golden AMI Pipeline Deployment',
        'desc' => 'Building automated EC2 Image Builder pipelines that produce compliant, pre-hardened AMIs.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Amazon EC2 Security Posture & Hardening Audit Report',
      1 => 'Automated EC2 Image Builder Golden AMI Pipeline (Terraform/CloudFormation)',
      2 => 'AWS Systems Manager (SSM) Secure Bastionless Architecture Guide',
      3 => 'Official Certificate of AWS Server Hardening Compliance',
    ),
    'compliance' => 
    array (
      0 => 'CIS AWS Foundations Benchmark',
      1 => 'CIS Amazon Linux / Ubuntu / Windows Benchmarks',
      2 => 'PCI DSS Requirement 2.2',
      3 => 'SOC 2 Type II',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Why is enforcing IMDSv2 critical on AWS?',
        'a' => 'IMDSv2 requires session-oriented token requests that stop Server-Side Request Forgery (SSRF) vulnerabilities from being used by attackers to steal temporary IAM credentials from the EC2 metadata service.',
      ),
      1 => 
      array (
        'q' => 'Can we eliminate our bastion hosts / jump servers completely?',
        'a' => 'Yes! By implementing AWS Systems Manager (SSM) Session Manager, your administrators can securely access instances via browser console or local CLI without opening any inbound firewall ports or managing SSH keys.',
      ),
      2 => 
      array (
        'q' => 'Do you provide automated Terraform modules for these hardening steps?',
        'a' => 'Yes, we deliver turnkey, production-tested Terraform and CloudFormation modules tailored to your AWS VPC architecture.',
      ),
    ),
  ),
  'azure-server-hardening' => 
  array (
    'title' => 'Microsoft Azure Cloud Hardening',
    'nav_label' => 'Azure Server Hardening',
    'category' => 'cloud-security',
    'badge' => 'Microsoft Azure Virtual Machines & Defender for Cloud',
    'tagline' => 'Protect Azure VMs, Bastion hosts, and hybrid Windows/Linux server fleets.',
    'short_desc' => 'Enterprise server hardening for Microsoft Azure Virtual Machines, Azure Bastion, Managed Identities, and Microsoft Defender for Cloud integration.',
    'overview' => 'Enterprise infrastructure hosted on Microsoft Azure requires meticulous hardening to prevent credential theft and ransomware propagation. Our Azure Server Hardening service audits and secures Azure Virtual Machines against CIS Benchmarks, deploys Azure Bastion and Just-In-Time (JIT) VM access, configures Azure Managed Identities to eliminate hardcoded credentials, and activates Microsoft Defender for Cloud continuous posture monitoring.',
    'why_needed' => 'Unprotected Azure VMs with public IP addresses and open RDP (port 3389) are actively attacked with automated brute-force attacks within minutes of provisioning.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'CIS Benchmark Hardening',
        'desc' => 'In-depth hardening for Windows Server and enterprise Linux VMs hosted in Azure.',
      ),
      1 => 
      array (
        'title' => 'Azure Bastion & JIT VM Access',
        'desc' => 'Enforcing Just-In-Time port opening and browser-based Azure Bastion access without public IPs.',
      ),
      2 => 
      array (
        'title' => 'Azure Managed Identities',
        'desc' => 'Replacing service principal passwords with Managed Identities for secure access to Azure Key Vault.',
      ),
      3 => 
      array (
        'title' => 'Microsoft Defender for Cloud',
        'desc' => 'Activating server protection plans (Defender for Servers Plan 2) and automated vulnerability scans.',
      ),
      4 => 
      array (
        'title' => 'Azure Disk Encryption (ADE)',
        'desc' => 'Enforcing BitLocker and DM-Crypt disk encryption using customer-managed keys in Azure Key Vault.',
      ),
      5 => 
      array (
        'title' => 'Azure Compute Gallery Golden Images',
        'desc' => 'Building pre-hardened custom VM images stored in Azure Compute Gallery for rapid scale-out.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Azure Subscription & VM Discovery',
        'desc' => 'Auditing all virtual machines, network security groups (NSGs), and Managed Identities across subscriptions.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'NSG & Public IP Remediation',
        'desc' => 'Removing public IP attachments and implementing Azure Bastion / JIT access policies.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Operating System Hardening',
        'desc' => 'Applying CIS benchmarks, removing legacy protocols, and configuring audit telemetry.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Disk Encryption & Key Vault Integration',
        'desc' => 'Configuring Azure Disk Encryption and securing secrets within Azure Key Vault.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Azure Policy Enforcement & Sign-Off',
        'desc' => 'Deploying Azure Policy rules that prevent any future unhardened VMs from being provisioned.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Microsoft Azure Virtual Machine Security Hardening Report',
      1 => 'Azure Bastion & Just-In-Time (JIT) Implementation Blueprint',
      2 => 'Azure Policy Hardening Guardrail Definitions (Bicep / ARM)',
      3 => 'Official Certificate of Azure Server Security Compliance',
    ),
    'compliance' => 
    array (
      0 => 'CIS Microsoft Azure Benchmark',
      1 => 'Microsoft Cloud Security Benchmark (MCSB)',
      2 => 'PCI DSS 4.0',
      3 => 'HIPAA Security Rule',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'What is Just-In-Time (JIT) VM Access in Azure?',
        'a' => 'JIT access locks down inbound management ports (SSH/RDP) at the NSG level by default, opening them only upon approved administrative request for a temporary, monitored window (e.g., 3 hours).',
      ),
      1 => 
      array (
        'q' => 'Can you automate the enforcement of hardening via Azure Policy?',
        'a' => 'Yes, we create custom Azure Policy definitions that automatically audit or deny non-compliant VM deployments across your management groups.',
      ),
      2 => 
      array (
        'q' => 'Do you support hybrid servers connected via Azure Arc?',
        'a' => 'Yes! We extend our Azure hardening, Defender for Servers, and policy controls to on-premises servers managed via Azure Arc.',
      ),
    ),
  ),
  'virtual-ciso-services' => 
  array (
    'title' => 'Virtual CISO (vCISO) Advisory',
    'nav_label' => 'Virtual CISO Services',
    'category' => 'enterprise-security',
    'badge' => 'Executive Cybersecurity Leadership on Demand',
    'tagline' => 'Access board-level cybersecurity leadership and strategic direction at a fraction of executive overhead.',
    'short_desc' => 'On-demand executive security leadership providing policy governance, regulatory compliance strategy, vendor due diligence, and board reporting.',
    'overview' => 'In today’s high-risk threat environment, enterprise customers, insurers, and regulators require businesses to have an experienced Chief Information Security Officer (CISO) guiding security strategy. However, hiring a full-time CISO is expensive and challenging. Our Virtual CISO (vCISO) service provides your organization with an accomplished executive security leader backed by a full team of technical specialists. Your vCISO establishes security governance, leads compliance certifications, oversees vendor risk, and represents your company in boardrooms.',
    'why_needed' => 'Without experienced executive leadership, companies make haphazard security purchases, fail enterprise sales security reviews, and remain vulnerable to regulatory fines.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Dedicated Executive Advisor',
        'desc' => 'Senior security leader with decades of industry experience guiding your executive team.',
      ),
      1 => 
      array (
        'title' => 'Enterprise Governance & Policy',
        'desc' => 'Building and maintaining enterprise security policies, standards, and operational guidelines.',
      ),
      2 => 
      array (
        'title' => 'Customer Due Diligence Acceleration',
        'desc' => 'Directly completing enterprise security questionnaires to accelerate B2B sales cycles.',
      ),
      3 => 
      array (
        'title' => 'Board & Stakeholder Presentations',
        'desc' => 'Delivering regular board briefings, risk scorecards, and strategic progress reports.',
      ),
      4 => 
      array (
        'title' => 'Regulatory & Audit Oversight',
        'desc' => 'Leading readiness programs for ISO 27001, SOC 2, HIPAA, PCI DSS, and GDPR.',
      ),
      5 => 
      array (
        'title' => 'Incident Response Leadership',
        'desc' => 'Serving as the central crisis commander during critical cybersecurity emergencies.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Baseline Assessment & Discovery',
        'desc' => 'Reviewing existing infrastructure, policies, risk profile, and strategic business goals.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Strategic Security Charter Design',
        'desc' => 'Formulating the multi-year security roadmap, resource allocation, and KPI benchmarks.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Governance & Policy Rollout',
        'desc' => 'Establishing the security steering committee and implementing operational policies.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Continuous Oversight & Vendor Review',
        'desc' => 'Participating in leadership meetings, reviewing vendor contracts, and handling audits.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Board Reporting & Annual Review',
        'desc' => 'Presenting cyber resilience metrics to executive leadership and refining strategy.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Dedicated Virtual Chief Information Security Officer Engagement Charter',
      1 => 'Enterprise Information Security Policy & Governance Manual',
      2 => 'Executive Board Briefing Packages & Strategic Cyber Roadmap',
      3 => 'Customer Vendor Security Questionnaire Acceleration Pack',
    ),
    'compliance' => 
    array (
      0 => 'ISO/IEC 27001 Governance',
      1 => 'NIST Cybersecurity Framework',
      2 => 'SOC 2 Type II Management Oversight',
      3 => 'SEC Cyber Regulations',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'How many hours per week does a vCISO provide?',
        'a' => 'Our vCISO engagements are flexible, ranging from 10 to 40 hours per month depending on company size, compliance mandates, and ongoing enterprise sales demands.',
      ),
      1 => 
      array (
        'q' => 'Can our vCISO speak directly with our enterprise clients and auditors?',
        'a' => 'Yes! Your vCISO represents your organization in client security calls, vendor procurement reviews, and external regulatory audits.',
      ),
      2 => 
      array (
        'q' => 'How does a vCISO compare in cost to a full-time CISO hire?',
        'a' => 'A full-time CISO command salary and benefits typically exceeding $250,000 to $400,000 annually. Our vCISO service delivers immediate executive leadership at a fraction of that investment.',
      ),
    ),
  ),
  'black-box-testing' => 
  array (
    'title' => 'Zero-Knowledge Black Box Pen Testing',
    'nav_label' => 'Black Box Testing',
    'category' => 'enterprise-security',
    'badge' => 'Zero-Knowledge External Adversary Simulation',
    'tagline' => 'Test your defensive perimeter from the perspective of an unprivileged external attacker.',
    'short_desc' => 'Realistic adversary simulation conducted with zero prior knowledge or inside credentials to test true external perimeter security.',
    'overview' => 'In real-world cyberattacks, external hackers begin with zero inside knowledge of your internal architecture, source code, or credentials. Our Black Box Penetration Testing mirrors this exact threat model. Our ethical hackers conduct extensive open-source intelligence gathering (OSINT), discover exposed perimeter entry points, probe internet-facing systems, and attempt unauthorized breach into your internal environment without any prior documentation or assistance.',
    'why_needed' => 'Black box testing provides the truest measure of your external attack surface, testing whether an outsider can breach your corporate systems from the public internet.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Zero-Knowledge Engagement',
        'desc' => 'No architectural documentation, source code, or internal credentials provided in advance.',
      ),
      1 => 
      array (
        'title' => 'OSINT & Intelligence Reconnaissance',
        'desc' => 'Discovering leaked employee credentials, forgot subdomains, and public exposure on dark web.',
      ),
      2 => 
      array (
        'title' => 'External Perimeter Probing',
        'desc' => 'Scanning all internet-facing IPs, web apps, VPN endpoints, and DNS records.',
      ),
      3 => 
      array (
        'title' => 'Real-World Exploit Execution',
        'desc' => 'Exploiting discovered vulnerabilities to demonstrate tangible impact and potential breach depth.',
      ),
      4 => 
      array (
        'title' => 'Defensive Evasion Testing',
        'desc' => 'Testing how effectively your WAF, perimeter firewalls, and SOC detect unauthorized reconnaissance.',
      ),
      5 => 
      array (
        'title' => 'Prioritized Threat Remediation',
        'desc' => 'Delivering clear technical remediation guides to close perimeter security gaps immediately.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Passive OSINT & Footprinting',
        'desc' => 'Gathering target intelligence from public registries, DNS, GitHub leaks, and dark web dumps.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Active Network & Service Enumeration',
        'desc' => 'Scanning external IP ranges, discovering live services, firewalls, and open web applications.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Vulnerability Analysis & Fuzzing',
        'desc' => 'Probing exposed web servers, VPN gateways, and mail servers for known and zero-day flaws.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Breach Attempt & Exploitation',
        'desc' => 'Executing controlled exploits to gain an initial foothold without causing system downtime.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Impact Assessment & Reporting',
        'desc' => 'Documenting attack paths, proof-of-concept exploits, and step-by-step remediation fixes.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Black Box External Penetration Testing Comprehensive Report',
      1 => 'Open-Source Intelligence (OSINT) Footprint Exposure Dossier',
      2 => 'Technical Exploitation Proof-of-Concept Evidence Records',
      3 => 'Official Certificate of Perimeter Security Assessment',
    ),
    'compliance' => 
    array (
      0 => 'PCI DSS Requirement 11.3.1',
      1 => 'ISO 27001 A.12.6',
      2 => 'NIST SP 800-115',
      3 => 'CREST Penetration Testing Standards',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'What information do you need from us to conduct a Black Box test?',
        'a' => 'Only your primary corporate domain name and authorized scope confirmation. Our team discovers everything else independently, replicating the real attacker experience.',
      ),
      1 => 
      array (
        'q' => 'How does Black Box testing differ from White Box testing?',
        'a' => 'Black Box testing provides zero inside knowledge to test external perimeter resilience. White Box testing provides full source code, architecture diagrams, and admin credentials for deep vulnerability analysis.',
      ),
      2 => 
      array (
        'q' => 'Is Black Box testing safe for production services?',
        'a' => 'Yes. Our experienced ethical hackers follow strict rules of engagement to avoid denial-of-service conditions or data corruption during testing.',
      ),
    ),
  ),
  'email-security-audit' => 
  array (
    'title' => 'Email Security & Anti-Phishing Audit',
    'nav_label' => 'Email Security Audit',
    'category' => 'enterprise-security',
    'badge' => 'SPF, DKIM, DMARC, & Inbound Gateway Hardening',
    'tagline' => 'Stop CEO fraud, business email compromise (BEC), and unauthorized domain spoofing.',
    'short_desc' => 'Comprehensive security evaluation of email infrastructure, enforcing strict DMARC p=reject, SPF, DKIM, and inbound email gateway defenses.',
    'overview' => 'Business Email Compromise (BEC) and email spoofing cost global organizations billions of dollars annually in fraudulent wire transfers and stolen credentials. Our Email Security Audit inspects your complete email pipeline: DNS anti-spoofing authentication (SPF, DKIM, DMARC), email gateway filtering (Microsoft 365 Defender, Google Workspace, Proofpoint, Mimecast), outbound TLS encryption, and employee inbox rules to eliminate backdoors and stop domain impersonation.',
    'why_needed' => 'Without strict DMARC enforcement (p=reject), malicious actors can send fraudulent emails using your exact `@yourcompany.com` domain to trick your clients and employees.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'DMARC Enforcement to p=reject',
        'desc' => 'Safely transitioning your domains to full DMARC rejection policy without dropping legitimate email.',
      ),
      1 => 
      array (
        'title' => 'SPF Record Optimization',
        'desc' => 'Resolving the strict 10-DNS-lookup limit, pruning rogue third-party senders, and locking SPF.',
      ),
      2 => 
      array (
        'title' => 'DKIM Cryptographic Key Audit',
        'desc' => 'Rotating weak 1024-bit keys to 2048-bit DKIM keys across all third-party marketing and CRM tools.',
      ),
      3 => 
      array (
        'title' => 'BIMI Brand Indicator Setup',
        'desc' => 'Implementing Brand Indicators for Message Identification (BIMI) to display your verified logo in inboxes.',
      ),
      4 => 
      array (
        'title' => 'Inbound Threat Gateway Tuning',
        'desc' => 'Hardening attachment sandboxing, anti-phishing protection, and zero-hour auto purge (ZAP).',
      ),
      5 => 
      array (
        'title' => 'Inbox Forwarding Rule Hunt',
        'desc' => 'Scanning mailbox accounts for malicious auto-forwarding rules deployed by stealth attackers.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Email Ecosystem & DNS Discovery',
        'desc' => 'Cataloging all corporate domains, subdomains, mail relays, and marketing platforms (Salesforce, SendGrid).',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'SPF, DKIM & DMARC Audit',
        'desc' => 'Analyzing DNS records, looking up lookup limits, and reviewing aggregate DMARC reports.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Inbound & Outbound Gateway Inspection',
        'desc' => 'Auditing spam filtering, attachment detonation rules, and MTA-STS encryption policies.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Safe Policy Transition & Alignment',
        'desc' => 'Aligning third-party senders and safely shifting DMARC policy from p=none to p=quarantine to p=reject.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Final Validation & Verification',
        'desc' => 'Testing email spoofing resilience and issuing domain email security certification.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Enterprise Email Security & Anti-Spoofing Audit Report',
      1 => 'Optimized SPF, DKIM, and DMARC DNS Record Configuration Blueprint',
      2 => 'Inbound Email Gateway (M365 / Google / Proofpoint) Hardening Guide',
      3 => 'Certificate of Enterprise Email Domain Protection',
    ),
    'compliance' => 
    array (
      0 => 'RFC 7489 (DMARC)',
      1 => 'RFC 7208 (SPF)',
      2 => 'RFC 6376 (DKIM)',
      3 => 'MTA-STS & DANE Standards',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Will enabling DMARC p=reject cause our legitimate marketing or newsletter emails to get blocked?',
        'a' => 'Not with our managed process. We analyze your DMARC XML aggregate reports first, identifying and authorizing every legitimate sending service (HubSpot, SendGrid, Zendesk) before locking down enforcement.',
      ),
      1 => 
      array (
        'q' => 'What is BIMI and why is it important?',
        'a' => 'BIMI (Brand Indicators for Message Identification) allows email clients (Gmail, Apple Mail) to display your verified corporate logo next to authenticated emails, boosting email open rates and trust.',
      ),
      2 => 
      array (
        'q' => 'Can you audit our Microsoft 365 or Google Workspace email security settings?',
        'a' => 'Yes! We perform deep configuration reviews of Exchange Online Protection, Defender for Office 365, and Google Workspace Gmail security controls.',
      ),
    ),
  ),
  'server-hardening' => 
  array (
    'title' => 'Server & Operating System Hardening',
    'nav_label' => 'Server Hardening',
    'category' => 'enterprise-security',
    'badge' => 'Windows Server, Linux & Core Infrastructure Defense',
    'tagline' => 'Transform default server installations into impenetrable, hardened defensive bastions.',
    'short_desc' => 'Comprehensive server hardening across on-premise, virtual, and cloud servers to eliminate vulnerabilities, restrict services, and enforce least privilege.',
    'overview' => 'Out-of-the-box operating system installations prioritize broad backward compatibility and ease-of-use over security, leaving dozens of unnecessary ports open, default accounts enabled, and weak ciphers active. Our Enterprise Server Hardening service locks down Windows Server and Linux operating systems according to authoritative Center for Internet Security (CIS) Benchmarks and DISA STIGs.',
    'why_needed' => 'Hardened servers drastically reduce the available attack surface, stopping attackers from escalating privileges or establishing persistence even if they manage to compromise an individual application.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'CIS Benchmark Level 1 & 2',
        'desc' => 'Implementing industry-standard hardening profiles tailored to your operational tolerance.',
      ),
      1 => 
      array (
        'title' => 'Windows Server Hardening',
        'desc' => 'Auditing SMBv1, NTLMv1, Kerberos settings, Credential Guard, and local security policies.',
      ),
      2 => 
      array (
        'title' => 'Linux OS Hardening',
        'desc' => 'Securing SSH daemons, PAM authentication, sysctl kernel parameters, and file permissions.',
      ),
      3 => 
      array (
        'title' => 'Service & Port Pruning',
        'desc' => 'Disabling unneeded background daemons, legacy print services, and exposed listening ports.',
      ),
      4 => 
      array (
        'title' => 'Audit Logging Configuration',
        'desc' => 'Configuring comprehensive security event logging to capture process creation and command lines.',
      ),
      5 => 
      array (
        'title' => 'Automated Deployment Scripts',
        'desc' => 'Supplying ready-to-execute Group Policy Objects (GPO), PowerShell scripts, and Ansible playbooks.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Operating System Inventory & Baseline',
        'desc' => 'Cataloging server roles (Domain Controllers, Database Servers, Web Hosts) and OS versions.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Benchmark Gap Assessment',
        'desc' => 'Scanning current system registry, services, and configs against established CIS benchmarks.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Pilot Hardening & Compatibility Test',
        'desc' => 'Deploying hardening configurations on non-production test machines to verify business software compatibility.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Production Rollout & GPO Deployment',
        'desc' => 'Rolling out hardened baselines via Group Policy or configuration management.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Post-Hardening Validation Scan',
        'desc' => 'Executing compliance scans to verify benchmark pass rates and issuing sign-off certificates.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Enterprise Server Hardening & Security Audit Report',
      1 => 'CIS Benchmark Compliance Scorecards for Windows and Linux',
      2 => 'Ready-to-Deploy Group Policy (GPO) and Ansible Hardening Templates',
      3 => 'Certificate of Enterprise Server Security Compliance',
    ),
    'compliance' => 
    array (
      0 => 'CIS Benchmarks Level 1 & 2',
      1 => 'NIST SP 800-123',
      2 => 'PCI DSS Requirement 2.2',
      3 => 'DISA STIG Standards',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Can server hardening break legacy accounting or ERP software?',
        'a' => 'We prevent disruption by conducting compatibility testing on pilot staging servers first and tailoring benchmark exceptions for specific legacy business tools.',
      ),
      1 => 
      array (
        'q' => 'Do you provide Group Policy Objects (GPOs) for Active Directory?',
        'a' => 'Yes! We deliver pre-configured GPO backup files that your domain administrator can import and apply across organizational units (OUs).',
      ),
      2 => 
      array (
        'q' => 'Which operating systems do you support?',
        'a' => 'We support Windows Server 2016/2019/2022/2025, Red Hat Enterprise Linux (RHEL), CentOS, Rocky Linux, AlmaLinux, Ubuntu Server, Debian, and SUSE.',
      ),
    ),
  ),
  'microsoft-365-security' => 
  array (
    'title' => 'Microsoft 365 & Entra ID Security Review',
    'nav_label' => 'Microsoft 365 Security',
    'category' => 'enterprise-security',
    'badge' => 'Entra ID, Purview, Intune & Defender for Office 365',
    'tagline' => 'Lock down your Microsoft cloud tenant against account takeover, data leaks, and BEC attacks.',
    'short_desc' => 'Deep security configuration review and hardening for Microsoft 365, Entra ID (Azure AD), Exchange Online, SharePoint, and Teams against CIS Benchmarks.',
    'overview' => 'Microsoft 365 houses your organization’s most critical emails, documents, chats, and identities. Yet, default M365 tenant settings often leave legacy authentication enabled, external file sharing wide open, and user consent for malicious third-party OAuth apps unrestricted. Our Microsoft 365 Security Audit benchmarks your tenant against the CIS Microsoft 365 Benchmark, implementing robust Conditional Access policies, multi-factor authentication (MFA), Purview data loss prevention (DLP), and Defender protections.',
    'why_needed' => 'Over 80% of Business Email Compromise (BEC) attacks target Microsoft 365 tenants. Hardening closes default loopholes and protects executive email accounts from unauthorized takeover.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'CIS Microsoft 365 Benchmark',
        'desc' => 'Comprehensive audit across Entra ID, Exchange Online, SharePoint, OneDrive, and Teams.',
      ),
      1 => 
      array (
        'title' => 'Conditional Access & Zero-Trust MFA',
        'desc' => 'Enforcing phishing-resistant MFA, blocking legacy protocols, and enforcing compliant devices.',
      ),
      2 => 
      array (
        'title' => 'Malicious OAuth App Consent',
        'desc' => 'Restricting user consent for third-party enterprise apps to stop Illicit Consent Grant attacks.',
      ),
      3 => 
      array (
        'title' => 'Purview Data Loss Prevention (DLP)',
        'desc' => 'Deploying DLP rules to prevent accidental sharing of credit card numbers, passwords, and PII.',
      ),
      4 => 
      array (
        'title' => 'Defender for Office 365 Tuning',
        'desc' => 'Configuring Safe Links, Safe Attachments, anti-phishing thresholds, and impersonation protection.',
      ),
      5 => 
      array (
        'title' => 'External Sharing & Guest Governance',
        'desc' => 'Locking down anonymous sharing links across SharePoint and setting automatic guest expiration.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Tenant Scoping & Read-Only Audit Access',
        'desc' => 'Connecting with Global Reader permissions to audit all tenant configurations.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Automated CIS Benchmark Baseline Scan',
        'desc' => 'Scanning tenant policies against CIS Microsoft 365 Foundation Benchmark v3.0.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Deep-Dive Identity & Exchange Audit',
        'desc' => 'Auditing admin role assignments, mail forwarding rules, and Conditional Access policies.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Hardening Implementation Roadmap',
        'desc' => 'Guiding your M365 administrators through prioritized policy changes to minimize user disruption.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Secure Score Verification & Certification',
        'desc' => 'Re-evaluating your Microsoft Secure Score and issuing the final tenant security attestation.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Microsoft 365 Tenant Security & Governance Audit Report',
      1 => 'CIS Microsoft 365 Benchmark Compliance Detailed Scorecard',
      2 => 'Turnkey Conditional Access & DLP Policy Configuration Guide',
      3 => 'Certificate of Microsoft 365 Tenant Security Compliance',
    ),
    'compliance' => 
    array (
      0 => 'CIS Microsoft 365 Foundations Benchmark',
      1 => 'NIST SP 800-53',
      2 => 'ISO 27001',
      3 => 'SOC 2 Type II',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Will these security changes disrupt our employees’ daily workflow?',
        'a' => 'We structure changes in phases (Audit -> Pilot -> Enforce), ensuring end-user communications are delivered in advance so normal business operations remain smooth.',
      ),
      1 => 
      array (
        'q' => 'What is our Microsoft Secure Score and how high should it be?',
        'a' => 'Microsoft Secure Score measures your tenant security posture. Most unhardened tenants score around 25-35%. Our program typically elevates clients to 75-85%+, placing them in the top 5% of secure organizations.',
      ),
      2 => 
      array (
        'q' => 'Can you help us implement Microsoft Intune mobile device management (MDM)?',
        'a' => 'Yes, we regularly integrate Intune compliance policies with Conditional Access to ensure only managed, healthy devices can access corporate data.',
      ),
    ),
  ),
  'erp-security-audit-assessment' => 
  array (
    'title' => 'Enterprise ERP & SAP Security Audit',
    'nav_label' => 'ERP Security Audit Assessment',
    'category' => 'enterprise-security',
    'badge' => 'SAP, Oracle ERP, & Microsoft Dynamics Security',
    'tagline' => 'Protect your core financial ledgers, supply chain pipelines, and ERP systems.',
    'short_desc' => 'Specialized security assessment for enterprise ERP platforms (SAP NetWeaver/S/4HANA, Oracle ERP Cloud, Microsoft Dynamics 365) to prevent financial fraud and data tampering.',
    'overview' => 'Enterprise Resource Planning (ERP) systems store the crown jewels of any large corporation: general ledgers, vendor payment details, payroll records, and intellectual property. Yet ERP systems are notoriously complex, often overlooked by standard security teams, and prone to Segregation of Duties (SoD) conflicts and unpatched protocol vulnerabilities. Our ERP Security Audit evaluates SAP, Oracle, and Microsoft Dynamics environments against unauthorized financial transactions, privilege escalation, and database tampering.',
    'why_needed' => 'A single rogue user or compromised account in an ERP system can authorize fraudulent millions in vendor wire payments, alter payroll records, or manipulate financial reporting.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'SAP & Oracle ERP Deep Audits',
        'desc' => 'Specialized coverage for SAP NetWeaver, S/4HANA, Oracle E-Business Suite, and Microsoft Dynamics.',
      ),
      1 => 
      array (
        'title' => 'Segregation of Duties (SoD) Review',
        'desc' => 'Detecting dangerous role conflicts (e.g., users who can both create and approve purchase orders).',
      ),
      2 => 
      array (
        'title' => 'RFC & Gateway Security',
        'desc' => 'Auditing SAP Gateway, RFC connections, and SAProuter configurations for unauthenticated access.',
      ),
      3 => 
      array (
        'title' => 'Financial Transaction Log Integrity',
        'desc' => 'Ensuring financial change logs and audit trails (SM20/CDHDR) cannot be wiped by administrators.',
      ),
      4 => 
      array (
        'title' => 'Database & OS Backend Hardening',
        'desc' => 'Securing underlying SAP HANA, Oracle Database, and Microsoft SQL Server repositories.',
      ),
      5 => 
      array (
        'title' => 'Custom ABAP / Code Vulnerabilities',
        'desc' => 'Scanning custom enterprise code and Z-transactions for injection and authorization bypasses.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'ERP Architecture & Role Scoping',
        'desc' => 'Mapping ERP instances, modules (FI/CO, MM, SD, HR), interfaces, and administrative tiers.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Automated Role & SoD Conflict Analysis',
        'desc' => 'Parsing user role assignments against matrix of dangerous Segregation of Duties conflicts.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Technical Parameter & Network Audit',
        'desc' => 'Reviewing profile parameters, diagnostic agents, and exposed industrial ports.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Custom Code & Interface Review',
        'desc' => 'Auditing custom modules, web interfaces, and third-party bank integration APIs.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Remediation Roadmap & Executive Debrief',
        'desc' => 'Delivering practical role redesign guides and parameter hardening recommendations.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Enterprise ERP System Security & SoD Audit Report',
      1 => 'Segregation of Duties (SoD) Toxic Role Combination Matrix',
      2 => 'ERP Technical Profile Parameter Hardening Guide',
      3 => 'Certificate of ERP Security Assessment & Compliance',
    ),
    'compliance' => 
    array (
      0 => 'SOX Section 404 (Financial Controls)',
      1 => 'ISO 27001',
      2 => 'SAP Security Baseline',
      3 => 'PCI DSS for ERP',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Can your audit detect Segregation of Duties (SoD) conflicts?',
        'a' => 'Yes. We run in-depth conflict matrices that identify users who possess conflicting capabilities (such as creating a vendor and authorizing payment to that same vendor).',
      ),
      1 => 
      array (
        'q' => 'Which ERP platforms can you audit?',
        'a' => 'We audit SAP (ECC 6.0, S/4HANA, NetWeaver), Oracle (E-Business Suite, Oracle ERP Cloud, PeopleSoft), Microsoft Dynamics 365, and Infor.',
      ),
      2 => 
      array (
        'q' => 'Does testing disrupt running financial or manufacturing processes?',
        'a' => 'No. Our audit utilizes read-only administrative queries, configuration exports, and off-line analysis to guarantee zero business disruption.',
      ),
    ),
  ),
  'security-architecture-review' => 
  array (
    'title' => 'Zero-Trust Security Architecture Review',
    'nav_label' => 'Security Architecture Review',
    'category' => 'enterprise-security',
    'badge' => 'Zero-Trust Architecture & Threat Modeling',
    'tagline' => 'Validate and modernize enterprise architecture against sophisticated cyber threat models.',
    'short_desc' => 'Holistic security architecture review assessing network zones, trust boundaries, identity federation, and hybrid cloud topologies against Zero-Trust principles.',
    'overview' => 'Patching individual vulnerabilities without addressing underlying architectural flaws is like replacing windows while the foundation is cracked. Our Security Architecture Review evaluates your enterprise design from the ground up: network segmentation, trust boundaries, identity and access management (IAM), hybrid cloud connections, and encryption standards. We benchmark your posture against modern Zero-Trust Architecture principles (NIST SP 800-207) to ensure structural resilience.',
    'why_needed' => 'Sound security architecture prevents localized compromises from cascading into enterprise-wide disasters. Reviewing architecture ensures your defenses are built to contain and isolate breaches.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Zero-Trust Architecture Mapping',
        'desc' => 'Transitioning from implicit trust perimeter models to explicit identity-verified Zero-Trust.',
      ),
      1 => 
      array (
        'title' => 'Threat Modeling (STRIDE / PASTA)',
        'desc' => 'Systematic threat modeling mapping data flows, attack surfaces, and adversary entry paths.',
      ),
      2 => 
      array (
        'title' => 'Network & DMZ Zone Segmentation',
        'desc' => 'Auditing multi-tier network segmentation, micro-segmentation, and egress filtering.',
      ),
      3 => 
      array (
        'title' => 'Identity & Access Federation',
        'desc' => 'Evaluating SAML, OIDC, Active Directory forest trusts, and Privileged Access Management (PAM).',
      ),
      4 => 
      array (
        'title' => 'Cryptographic Infrastructure Review',
        'desc' => 'Auditing PKI, certificate authorities, key management systems (KMS), and cipher suites.',
      ),
      5 => 
      array (
        'title' => 'Resilience & Disaster Recovery',
        'desc' => 'Evaluating architectural failover, air-gapped backup immutability, and business continuity.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Architecture Discovery & Document Review',
        'desc' => 'Analyzing network topology diagrams, data flow maps, cloud architecture, and security policies.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Stakeholder & Architect Interviews',
        'desc' => 'Interviewing enterprise architects, dev leads, and network engineers to uncover unwritten realities.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Threat Modeling & Gap Identification',
        'desc' => 'Applying STRIDE threat modeling across critical business workflows and infrastructure.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Zero-Trust Benchmark Comparison',
        'desc' => 'Evaluating existing controls against the NIST SP 800-207 Zero-Trust Architecture framework.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Target Architecture Blueprint & Roadmap',
        'desc' => 'Delivering future-state target architecture designs and a phased implementation roadmap.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Comprehensive Enterprise Security Architecture Review Report',
      1 => 'System Threat Model & Attack Surface Map (STRIDE Analysis)',
      2 => 'Future-State Zero-Trust Architecture Reference Blueprint',
      3 => 'Certificate of Enterprise Security Architecture Review',
    ),
    'compliance' => 
    array (
      0 => 'NIST SP 800-207 (Zero Trust Architecture)',
      1 => 'TOGAF / SABSA Security Frameworks',
      2 => 'ISO 27001 A.13 & A.14',
      3 => 'CIS Controls v8',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'When should an enterprise commission an Architecture Review?',
        'a' => 'An architecture review is ideal before major digital transformations, during cloud migrations, following mergers and acquisitions, or when transitioning to a Zero-Trust model.',
      ),
      1 => 
      array (
        'q' => 'How does an architecture review differ from a penetration test?',
        'a' => 'A penetration test probes running software for exploitable bugs. An architecture review evaluates the structural design, data flow diagrams, security controls, and trust boundaries before and during system construction.',
      ),
      2 => 
      array (
        'q' => 'Do you provide actionable architectural diagrams we can use in our planning?',
        'a' => 'Yes! We deliver detailed future-state architecture diagrams and reference blueprints formatted in Visio, Lucidchart, and draw.io.',
      ),
    ),
  ),
  'wordpress-security' => 
  array (
    'title' => 'CMS & Web Platform Security Hardening',
    'nav_label' => 'Wordpress Security',
    'category' => 'enterprise-security',
    'badge' => 'CMS Hardening & Malware Eradication',
    'tagline' => 'Harden enterprise WordPress installations against plugin vulnerabilities, brute force, and malware.',
    'short_desc' => 'Comprehensive WordPress security assessment, malware scanning, plugin vulnerability auditing, and hardening for enterprise and high-traffic WordPress sites.',
    'overview' => 'Powering over 40% of the world’s websites, WordPress is the most targeted Content Management System on the internet. Insecure third-party plugins, outdated themes, exposed `wp-login.php` pages, and shared hosting misconfigurations frequently lead to defacements, SEO spam injections, and ransomware. Our WordPress Security service performs deep source code and plugin auditing, cleans hidden backdoors, locks down the REST API, and deploys enterprise hardening controls.',
    'why_needed' => 'A hacked WordPress website destroys search engine rankings, triggers Google Blacklist browser warnings, and exposes customer and visitor data to malicious redirects.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Plugin & Theme Vulnerability Audits',
        'desc' => 'Auditing installed plugins and custom themes for SQLi, XSS, and arbitrary file uploads.',
      ),
      1 => 
      array (
        'title' => 'Malware & Backdoor Eradication',
        'desc' => 'Deep forensic scans detecting obfuscated PHP shells, webshells, and SEO spam injections.',
      ),
      2 => 
      array (
        'title' => 'Admin & Login Hardening',
        'desc' => 'Implementing 2FA, IP whitelisting for wp-admin, custom login endpoints, and rate limiting.',
      ),
      3 => 
      array (
        'title' => 'REST API & XML-RPC Lockout',
        'desc' => 'Disabling XML-RPC pingback DDoS vectors and restricting unauthorized REST API enumeration.',
      ),
      4 => 
      array (
        'title' => 'Database & File Permission Audits',
        'desc' => 'Enforcing strict 644/755 permissions, changing table prefixes, and disabling file editing in wp-config.',
      ),
      5 => 
      array (
        'title' => 'Enterprise WAF & CDN Defense',
        'desc' => 'Configuring Cloudflare WAF, security headers (CSP, HSTS), and automated off-site backups.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Reconnaissance & Vulnerability Scanning',
        'desc' => 'Auditing WordPress core version, active plugins, themes, and server configuration.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Malware & Core Integrity Check',
        'desc' => 'Verifying WordPress core files against official checksums to uncover injected backdoors.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'wp-config & Server Hardening',
        'desc' => 'Moving sensitive config files, disabling script execution in upload directories, and applying CSP.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Brute Force & Login Protection',
        'desc' => 'Deploying multi-factor authentication, Cloudflare bot protection, and custom login routes.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Backup & Continuous Monitoring Setup',
        'desc' => 'Establishing automated encrypted backups and continuous uptime and integrity monitoring.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'WordPress Security Audit & Hardening Comprehensive Report',
      1 => 'Malware & Webshell Eradication Verification File',
      2 => 'Enterprise WordPress Security Best Practices & Configuration Guide',
      3 => 'Certificate of WordPress Security Compliance',
    ),
    'compliance' => 
    array (
      0 => 'OWASP Top 10 for CMS',
      1 => 'PCI DSS for WooCommerce',
      2 => 'ISO 27001',
      3 => 'Google Safe Browsing Standards',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Can you clean an actively hacked WordPress website that is displaying spam or redirected links?',
        'a' => 'Yes! We provide emergency malware removal services to clean infected files, remove rogue admin accounts, clear Google Safe Browsing blacklists, and secure the site against reinfection.',
      ),
      1 => 
      array (
        'q' => 'Will hardening our WordPress site impact our page load speed or SEO?',
        'a' => 'No. Our hardening optimizes database queries, removes bloated vulnerable plugins, and implements Cloudflare caching, which often significantly improves site speed and SEO rankings.',
      ),
      2 => 
      array (
        'q' => 'Can you audit WooCommerce stores for PCI DSS compliance?',
        'a' => 'Yes, we specialize in WooCommerce payment gateway security, cardholder data isolation, and anti-skimming script monitoring.',
      ),
    ),
  ),
  'cybercrime-victim-assistance-account-recovery' => 
  array (
    'title' => 'Cybercrime Victim Assistance & Account Recovery',
    'nav_label' => 'Cybercrime Victim Assistance & Account Recovery',
    'category' => 'digital-investigations',
    'badge' => 'INCIDENT TRIAGE & RECOVERY',
    'tagline' => 'Emergency response, evidence preservation, and verified recovery for hacked accounts and cyber extortion.',
    'short_desc' => 'Forensic assistance for individuals, executives, and organizations affected by account takeovers, SIM swapping, extortion, phishing, and online identity theft.',
    'overview' => 'Cybercrime victimization can be traumatic, legally complex, and financially devastating. Our Cybercrime Victim Assistance & Account Recovery service provides immediate, discreet emergency response for individuals, public figures, and business leaders whose social media, email, banking, or cloud accounts have been compromised. We conduct forensic digital artifact preservation to capture attacker IP addresses, session token hijack traces, and unauthorized recovery phone/email alterations. Working in accordance with platform security escalation protocols and Indian cyber law (IT Act 2000 Section 43/66), we guide victims through evidence preservation, platform escalation, law enforcement complaint filing (National Cyber Crime Reporting Portal cybercrime.gov.in), and permanent account security re-fortification.',
    'why_needed' => 'Standard platform recovery forms are often automated, delayed, or manipulated by sophisticated hackers who lock out the rightful owner with 2FA bypass and recovery code replacements. Professional intervention ensures critical digital evidence is legally preserved before log rotation, preventing reputational extortion and secondary fraudulent transactions.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Emergency Incident Triage',
        'desc' => 'Immediate session termination, device isolation, and forensic snapshotting across compromised platforms.',
      ),
      1 => 
      array (
        'title' => 'Forensic Session Hijack Tracing',
        'desc' => 'Analyzing cookie theft, OAuth token abuse, and credential stuffing vectors to establish the breach origin.',
      ),
      2 => 
      array (
        'title' => 'Official Platform Escalation',
        'desc' => 'Structured legal escalations with Meta, Google, Microsoft, Apple, and X Trust & Safety enterprise teams.',
      ),
      3 => 
      array (
        'title' => 'Cyber Extortion & Blackmail Defense',
        'desc' => 'Advisory and evidence packaging for sextortion, ransomware, and coercive threat actors.',
      ),
      4 => 
      array (
        'title' => 'Law Enforcement Ready Dossier',
        'desc' => 'Preparing FIR-compliant evidence compliant with Section 65B of the Indian Evidence Act.',
      ),
      5 => 
      array (
        'title' => 'Post-Recovery Hardening',
        'desc' => 'Hardware security keys (FIDO2/WebAuthn) setup, credential rotation, and device sanitization.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Emergency Containment & Scoping',
        'desc' => 'Halting attacker access, isolating connected systems, and cataloging all compromised recovery vectors.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Digital Evidence Preservation',
        'desc' => 'Extracting immutable email headers, login IPs, and session tokens under ISO 27037 chain-of-custody standards.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Identity Verification & Escalation',
        'desc' => 'Submitting verified legal identity documentation directly to platform security and compliance desks.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Account Reclamation & Lockout',
        'desc' => 'Re-establishing administrative ownership, revoking rogue sessions, and purging attacker recovery backdoors.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Hardening & Legal Filing Support',
        'desc' => 'Implementing zero-trust 2FA, delivering Section 65B legal certificates, and filing National Cyber Crime reports.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Incident Response & Evidence Preservation Dossier',
      1 => 'Court-Admissible Section 65B Electronic Evidence Certificate',
      2 => 'Compromised Account Forensic Timeline & Attacker IP Trace',
      3 => 'Platform Security Escalation Log & Case Reference Manifest',
      4 => 'Post-Breach Security Hardening & Zero-Trust Re-fortification Plan',
    ),
    'compliance' => 
    array (
      0 => 'IT Act 2000 (Section 43 & 66)',
      1 => 'Indian Evidence Act Section 65B',
      2 => 'ISO/IEC 27037 Digital Evidence Standards',
      3 => 'INTERPOL Cybercrime Victim Assistance Guidelines',
      4 => 'CERT-In Incident Reporting Directives',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Can you guarantee recovery of a hacked Instagram, WhatsApp, or Google account?',
        'a' => 'While no ethical firm can guarantee 100% third-party platform actions, our certified investigators utilize authorized platform enterprise channels, verifiable identity documentation, and digital forensic affidavits that maximize recovery rates compared to automated web forms.',
      ),
      1 => 
      array (
        'q' => 'What immediate steps should I take if I am being blackmailed or extorted online?',
        'a' => 'Do not pay the extorter and do not delete any chats or emails. Take full uncropped screenshots showing phone numbers, handles, and transaction IDs. Contact our emergency team immediately so we can preserve cryptographic headers before the attacker deletes messages.',
      ),
      2 => 
      array (
        'q' => 'Will this evidence be valid in police complaints or court proceedings?',
        'a' => 'Yes. All digital artifacts, server logs, and communications are preserved following ISO/IEC 27037 chain-of-custody standards and accompanied by Section 65B Indian Evidence Act certificates valid in Indian courts.',
      ),
      3 => 
      array (
        'q' => 'Can you help prevent the attacker from hacking my other accounts?',
        'a' => 'Yes. We perform a full cross-account security audit, revoking rogue OAuth app permissions, auditing connected recovery methods, and configuring FIDO2 hardware security keys.',
      ),
    ),
  ),
  'digital-investigations-osint' => 
  array (
    'title' => 'Digital Investigations & OSINT',
    'nav_label' => 'Digital Investigations & OSINT',
    'category' => 'digital-investigations',
    'badge' => 'OPEN-SOURCE INTELLIGENCE & RECONNAISSANCE',
    'tagline' => 'Actionable cyber reconnaissance, deep web intelligence, and online footprint verification.',
    'short_desc' => 'Comprehensive open-source intelligence (OSINT) and cyber reconnaissance to uncover hidden assets, verify identities, unmask threat actors, and support legal litigation.',
    'overview' => 'Modern adversaries and fraudsters leave extensive digital footprints across the surface, deep, and dark web. Our Digital Investigations & OSINT practice leverages advanced intelligence-gathering methodologies, graph link analysis, public records scraping, and dark web breach intelligence to uncover facts, locate missing digital identities, verify corporate counter-parties, and profile malicious actors. Whether for high-stakes corporate due diligence, litigation support, pre-employment executive screening, or tracing anonymous smear campaigns, we transform fragmented digital data into coherent, verified intelligence dossiers.',
    'why_needed' => 'Standard search engines index less than 5% of the internet. Without specialized OSINT tooling, link analysis engines, and dark web scraping crawlers, crucial risk indicators, undeclared liabilities, pseudonymous forum activities, and breach exposures remain completely hidden from corporate and personal decision-makers.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Entity & Identity De-anonymization',
        'desc' => 'Unmasking aliases, handles, disposable phone numbers, and proxy emails back to verifiable individuals.',
      ),
      1 => 
      array (
        'title' => 'Dark Web & Forum Infiltration',
        'desc' => 'Scanning illicit marketplaces, Pastebin dumps, and breach forums for compromised credentials and data dumps.',
      ),
      2 => 
      array (
        'title' => 'Social Graph & Affiliation Analysis',
        'desc' => 'Visualizing organizational connections, co-conspirators, and online networks using link analysis algorithms.',
      ),
      3 => 
      array (
        'title' => 'Asset Tracing & Due Diligence',
        'desc' => 'Discovering hidden corporate holdings, foreign registries, offshore assets, and registered domain portfolios.',
      ),
      4 => 
      array (
        'title' => 'Geolocation & EXIF Metadata Forensics',
        'desc' => 'Verifying real-world locations from image telemetry, IP routing, wireless BSSID data, and satellite archives.',
      ),
      5 => 
      array (
        'title' => 'Corporate Counter-Party Vetting',
        'desc' => 'Uncovering undisclosed conflicts of interest, regulatory sanctions, litigation history, and reputational liabilities.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Scoping & Threat Modeling',
        'desc' => 'Defining target identifiers, establishing objective parameters, and setting up strict operational security.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Multi-Vector Data Harvesting',
        'desc' => 'Querying global search indices, public registries, corporate filings, social graph nodes, and dark web archives.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Normalization & Graph Link Analysis',
        'desc' => 'Synthesizing disparate data points into structured entity profiles and relationship matrices.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Hypothesis Validation & Fact Checking',
        'desc' => 'Corroborating digital leads against primary records, DNS telemetry, and real-world documentation.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Intelligence Dossier Delivery',
        'desc' => 'Producing comprehensive executive summaries, evidentiary link charts, and actionable strategic findings.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Comprehensive OSINT Intelligence Dossier with Visual Link Graphs',
      1 => 'Digital Footprint & Threat Exposure Map',
      2 => 'De-anonymization Matrix with Corroborating Source References',
      3 => 'Dark Web Compromise & Credential Exposure Report',
      4 => 'Executive Strategic Decision-Making Summary',
    ),
    'compliance' => 
    array (
      0 => 'OSINT Framework & Bellingcat Standards',
      1 => 'ISO/IEC 27037 Evidence Handling',
      2 => 'GDPR & Digital Personal Data Protection Act (DPDP)',
      3 => 'ACPO Good Practice Guide for Digital Evidence',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Is OSINT investigation legal and ethical?',
        'a' => 'Yes. Open-Source Intelligence relies strictly on publicly accessible data, deep-web databases, digital archives, and legal intelligence feeds. We never perform illegal wiretapping, hacking, or unauthorized system intrusions.',
      ),
      1 => 
      array (
        'q' => 'How long does a thorough OSINT investigation take?',
        'a' => 'Standard background or entity OSINT audits typically take 3 to 5 business days, while complex cross-border corporate investigations or deep dark-web actor tracking can take 7 to 14 days.',
      ),
      2 => 
      array (
        'q' => 'Can OSINT unmask anonymous cyberbullies or smear campaign coordinators?',
        'a' => 'Yes. By analyzing linguistic patterns, registration timing, reused email fragments, cryptographic hashes, and linked infrastructure, we frequently establish probable identity linkages that support legal subpoenas and police action.',
      ),
    ),
  ),
  'social-media-investigations-impersonation-removal' => 
  array (
    'title' => 'Social Media Investigations & Impersonation Removal',
    'nav_label' => 'Social Media Investigations & Impersonation Removal',
    'category' => 'digital-investigations',
    'badge' => 'BRAND DEFENSE & EXPEDITED TAKEDOWNS',
    'tagline' => 'Unmasking fake profiles, combating brand impersonation, and executing expedited platform takedowns.',
    'short_desc' => 'Forensic investigation of fake profiles, malicious brand impersonation, defamatory smear campaigns, and unauthorized intellectual property misuse across global social platforms.',
    'overview' => 'Impersonation and malicious social media campaigns can destroy hard-earned personal reputations, siphon corporate customer revenue, and facilitate financial phishing. Our Social Media Investigations & Impersonation Removal team specializes in identifying, documenting, and eliminating unauthorized copycat accounts, fake customer support channels, executive impersonations, and defamatory content across Instagram, Facebook, LinkedIn, X (Twitter), YouTube, Telegram, and TikTok. Combining forensic screenshotting with legal DMCA, trademark infringement, and platform security escalations, we deliver permanent content removal and identify the operators behind malicious accounts.',
    'why_needed' => 'Automated platform reporting forms frequently reject valid user reports with generic responses like "this account does not violate our community standards." Our investigators utilize formal trademark filings, notarized identity affidavits, and direct legal escalations that bypass automated bots and force rapid manual review by trust and safety teams.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Automated Impersonation Radar',
        'desc' => 'Continuous 24/7 scanning for newly registered brand clones, lookalike handles, and executive names.',
      ),
      1 => 
      array (
        'title' => 'Cryptographic Forensic Archival',
        'desc' => 'Capturing immutable, time-stamped proof of defamatory posts and profile changes with Section 65B validity.',
      ),
      2 => 
      array (
        'title' => 'Legal Takedown Escalations',
        'desc' => 'Executing expedited DMCA, copyright, trademark, and right-of-publicity takedown requests.',
      ),
      3 => 
      array (
        'title' => 'Coordinated Inauthentic Behavior Tracking',
        'desc' => 'Identifying botnets, engagement pods, and automated troll networks orchestrating smear campaigns.',
      ),
      4 => 
      array (
        'title' => 'Telegram & Messaging Group Takedowns',
        'desc' => 'Investigating and dismantling unauthorized private groups, channels, and financial scam bots.',
      ),
      5 => 
      array (
        'title' => 'Executive Reputation Defense',
        'desc' => 'Rapid-response shielding for corporate leadership and celebrities during viral digital attacks.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Threat Identification & Mapping',
        'desc' => 'Cataloging all unauthorized profiles, clone pages, and defamatory posts across social ecosystems.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Forensic Preservation & Time-Stamping',
        'desc' => 'Archiving server headers, post metadata, and full page captures under strict chain-of-custody protocols.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Operator Attribution Analysis',
        'desc' => 'Cross-referencing connected phone numbers, linked emails, and posting habits to trace the perpetrator.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Platform Legal Escalation',
        'desc' => 'Filing expedited statutory notices with platform Trust & Safety and Legal Enforcement divisions.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Deletion Verification & Monitoring',
        'desc' => 'Verifying permanent account removal and maintaining active radar to prevent clone resurgence.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Impersonation Forensic Incident Dossier',
      1 => 'Formal Platform Takedown Notices & Escalation Receipts',
      2 => 'Operator Profiling Report (IP, email, and connected entity leads)',
      3 => 'Certificate of Content Removal & Link De-indexing',
      4 => '30-Day Anti-Resurgence Monitoring Report',
    ),
    'compliance' => 
    array (
      0 => 'Digital Millennium Copyright Act (DMCA) 17 U.S.C. § 512',
      1 => 'IT Act 2000 (Section 66D - Cheating by Personation, Section 67)',
      2 => 'Meta, Google, LinkedIn & X Verified Rights Enforcement Standards',
      3 => 'Indian Trademarks Act 1999',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'How quickly can an impersonation account be taken down?',
        'a' => 'Standard takedowns with complete trademark or identity proof typically succeed within 24 to 72 hours. High-priority executive fraud accounts with acute financial risk can be expedited within hours.',
      ),
      1 => 
      array (
        'q' => 'Can you remove scam Telegram channels using our brand name?',
        'a' => 'Yes. We track and escalate scam Telegram channels, bots, and group administrators to Telegram\'s legal and anti-scam divisions, securing channel bans and warning labels.',
      ),
      2 => 
      array (
        'q' => 'What documentation is required to remove an impersonator?',
        'a' => 'For individuals: a government-issued photo ID. For businesses: trademark registration certificate, incorporation documents, or an official letter of authorization from an executive officer.',
      ),
    ),
  ),
  'cyber-fraud-investigation-support' => 
  array (
    'title' => 'Cyber Fraud Investigation Support',
    'nav_label' => 'Cyber Fraud Investigation Support',
    'category' => 'digital-investigations',
    'badge' => 'FINANCIAL CRIMES & CRYPTO TRACING',
    'tagline' => 'Investigating financial scams, cryptocurrency fraud, business email compromise, and investment syndicates.',
    'short_desc' => 'End-to-end investigative support for victims of investment scams, crypto theft, romance fraud, fake trading platforms, and corporate wire transfer diversion.',
    'overview' => 'Cyber fraud has evolved into organized, cross-border financial operations executing complex multi-layered scams including pig butchering investment fraud, bogus crypto trading platforms, advance-fee scams, and Business Email Compromise (BEC). Our Cyber Fraud Investigation Support unit brings together seasoned forensic accountants, certified cryptocurrency investigators, and digital evidence specialists. We trace transaction flows through fiat banking networks, identify money mule accounts, reconstruct the communication trail, analyze fraudulent mobile APKs/web applications, and map stolen cryptocurrency across Bitcoin, Ethereum, Tron (USDT), and other blockchains to identify exchange cash-out points.',
    'why_needed' => 'Local law enforcement agencies often face resource constraints and jurisdictional hurdles when dealing with offshore syndicates and cryptocurrency mixers. A professionally prepared, court-admissible forensic fraud dossier accelerates police investigation, facilitates bank account freezing under CrPC 102/105, and provides the necessary documentation for civil recovery and insurance claims.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Cryptocurrency Blockchain Tracing',
        'desc' => 'On-chain forensic tracing across TRC-20 USDT, BTC, ETH, and layer-2 networks to identify exchange deposits.',
      ),
      1 => 
      array (
        'title' => 'Money Mule & Bank Account Mapping',
        'desc' => 'Tracking fiat remittance paths, beneficiary bank accounts, IFSC/SWIFT routings, and UPI money trails.',
      ),
      2 => 
      array (
        'title' => 'BEC & Email Spoofing Deconstruction',
        'desc' => 'Analyzing SPF/DKIM/DMARC headers, rogue mailbox forwarding rules, and invoice spoofing alterations.',
      ),
      3 => 
      array (
        'title' => 'Scam Application Reverse-Engineering',
        'desc' => 'Decompiling malicious APKs and fake trading web apps to locate command-and-control servers and database endpoints.',
      ),
      4 => 
      array (
        'title' => 'Law Enforcement Ready Dossier',
        'desc' => 'Drafting formal complaints with categorized annexures for Cyber Police, CBI, ED, and overseas authorities.',
      ),
      5 => 
      array (
        'title' => 'Exchange Subpoena Preparation',
        'desc' => 'Identifying centralized exchange deposit addresses (CEX) to request emergency account freezing.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Fraud Intake & Timeline Mapping',
        'desc' => 'Cataloging transaction hashes (TxIDs), bank UTR receipts, chat logs, and financial loss amounts.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Blockchain & Fiat Tracking',
        'desc' => 'Tracing asset hops through intermediate mixers and identifying beneficiary exchange deposit accounts.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Infrastructure & Communication Analysis',
        'desc' => 'Unmasking scam hosting providers, domain registars, and IP telemetry used by the syndicate.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Attribution & CEX Node Identification',
        'desc' => 'Linking on-chain wallet clusters with known KYC-verified centralized exchange deposit addresses.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Dossier Delivery & Law Enforcement Briefing',
        'desc' => 'Submitting comprehensive forensic dossiers ready for police freezing orders and judicial subpoenas.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Comprehensive Cyber Fraud Investigation Report',
      1 => 'On-Chain Cryptocurrency Flow Diagram & Clustered Wallet Map',
      2 => 'Fiat Beneficiary Account & Transaction Reconciliation Ledger',
      3 => 'Malicious Domain & Hosting Server Infrastructure Attribution',
      4 => 'Formal Law Enforcement Complaint Dossier with Evidence Annexures',
    ),
    'compliance' => 
    array (
      0 => 'FATF Guidance for Virtual Assets & VASPs',
      1 => 'Prevention of Money Laundering Act (PMLA) 2002',
      2 => 'IT Act 2000 Section 66D & IPC 420',
      3 => 'Chainalysis / TRM Labs On-Chain Forensic Methodologies',
      4 => 'ISO/IEC 27037 Evidence Integrity',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Can lost cryptocurrency (like USDT or Bitcoin) actually be traced?',
        'a' => 'Yes. All public blockchains maintain an unalterable permanent public ledger. Using forensic link analysis, we follow funds through intermediate hops and unmask the centralized exchanges where the fraudsters attempt to convert crypto into fiat.',
      ),
      1 => 
      array (
        'q' => 'Can Cyber Kovai freeze the fraudster\'s bank account directly?',
        'a' => 'Only law enforcement agencies and judicial authorities have legal authority to issue formal freezing orders (e.g. under CrPC Section 102). We provide the verified evidence dossier that enables police officers to issue immediate freezing notices to banks and crypto exchanges.',
      ),
      2 => 
      array (
        'q' => 'What should I do immediately after realizing I have been scammed?',
        'a' => 'Immediately record all transaction hash IDs (TxIDs), bank account numbers, UTR numbers, screenshot all chats before the scammer deletes them, and file an initial complaint on the National Cyber Crime portal (cybercrime.gov.in or helpline 1930).',
      ),
    ),
  ),
  'digital-evidence-preservation-forensics' => 
  array (
    'title' => 'Digital Evidence Preservation & Forensics',
    'nav_label' => 'Digital Evidence Preservation & Forensics',
    'category' => 'digital-investigations',
    'badge' => 'ISO/IEC 27037 & COURT-ADMISSIBLE STANDARDS',
    'tagline' => 'Bit-stream forensic imaging, volatile memory extraction, and Section 65B certified legal documentation.',
    'short_desc' => 'Forensically sound acquisition, preservation, and analysis of digital evidence from hard drives, mobile phones, servers, cloud storage, and messaging platforms.',
    'overview' => 'Digital evidence is fragile, volatile, and easily compromised by improper handling. Our Digital Evidence Preservation & Forensics service adheres strictly to international ISO/IEC 27037 standards and Indian legal mandates under Section 65B of the Indian Evidence Act. We deploy hardware write-blockers and certified forensic acquisition tools to create bit-by-bit forensic images (E01 / raw dd) of computers, smartphones (iOS & Android), external storage media, enterprise servers, and cloud repositories. We reconstruct deleted artifacts, extract unallocated space data, parse SQLite chat databases, analyze registry hives, and verify chain-of-custody with cryptographic SHA-256 and MD5 hashing.',
    'why_needed' => 'In corporate fraud, employee intellectual property theft, divorce litigation, and criminal defense, opposing counsel routinely challenges digital evidence based on improper collection methods. Evidence collected without hardware write-blockers or strict hash verification is frequently thrown out of court as tainted or inadmissible.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Hardware Write-Blocked Acquisition',
        'desc' => 'Guaranteeing zero alteration to original source media during imaging using forensic hardware bridges.',
      ),
      1 => 
      array (
        'title' => 'Mobile Device Forensic Extraction',
        'desc' => 'Physical, file-system, and logical dumps of locked or encrypted smartphones (iOS and Android).',
      ),
      2 => 
      array (
        'title' => 'Cryptographic Hash Verification',
        'desc' => 'Generating dual SHA-256 and MD5 hashes at acquisition and verification to establish mathematical proof of integrity.',
      ),
      3 => 
      array (
        'title' => 'Deleted Data & Artifact Carving',
        'desc' => 'Recovering deleted WhatsApp/Telegram chats, emails, browser histories, and photos from unallocated space.',
      ),
      4 => 
      array (
        'title' => 'Volatile RAM Memory Dump & Analysis',
        'desc' => 'Capturing unencrypted memory artifacts, running processes, active network connections, and crypto keys.',
      ),
      5 => 
      array (
        'title' => 'Section 65B Legal Evidence Certification',
        'desc' => 'Issuing expert electronic evidence certificates signed by certified forensic examiners for Indian courts.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Intake & Chain-of-Custody Logging',
        'desc' => 'Cataloging device model, serial numbers, physical condition, and sealing in anti-static tamper-evident packaging.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Forensic Bit-Stream Acquisition',
        'desc' => 'Extracting bit-by-bit E01 forensic disk images through hardware write-blockers with dual hash manifests.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Artifact Parsing & Timeline Analysis',
        'desc' => 'Reconstructing chronological system events, file access records, chat logs, and deleted database entries.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Verification & Integrity Audit',
        'desc' => 'Re-hashing forensic copies to verify exact byte-for-byte match against original evidence acquisition records.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Expert Report & 65B Certification',
        'desc' => 'Publishing certified technical forensic reports ready for judicial scrutiny, litigation, and internal tribunals.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Forensic Acquisition Log & Chain-of-Custody Manifest',
      1 => 'Dual-Hashed Bit-Stream Master Forensic Image Archives',
      2 => 'Detailed Forensic Analysis Report with Chronological Artifact Timelines',
      3 => 'Formal Certificate under Section 65B Indian Evidence Act',
      4 => 'Court-Ready Technical Witness Summary',
    ),
    'compliance' => 
    array (
      0 => 'ISO/IEC 27037 (Digital Evidence Handling Guidelines)',
      1 => 'Indian Evidence Act Section 65B / Bharatiya Sakshya Adhiniyam',
      2 => 'NIST SP 800-86 Forensic Integration Guide',
      3 => 'Scientific Working Group on Digital Evidence (SWGDE) Standards',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'What makes digital evidence court-admissible in India?',
        'a' => 'Under Section 65B of the Indian Evidence Act, digital evidence must be accompanied by an official certificate describing how the device was operated, confirming its lawful custody, and proving that the evidence has not been tampered with or altered.',
      ),
      1 => 
      array (
        'q' => 'Can you recover WhatsApp messages that were deleted months ago?',
        'a' => 'In many cases, yes. While end-to-end encryption protects messages in transit, local SQLite database caches, unallocated flash memory blocks, and automated device backups often retain fragments of deleted conversations that forensic tools can carve and reconstruct.',
      ),
      2 => 
      array (
        'q' => 'What is a hardware write-blocker and why is it mandatory?',
        'a' => 'A write-blocker allows forensic workstations to read data from a suspect hard drive or flash drive without allowing the computer\'s operating system to write even a single byte (such as changing access timestamps), ensuring complete integrity of original evidence.',
      ),
    ),
  ),
  'executive-family-digital-protection' => 
  array (
    'title' => 'Executive & Family Digital Protection',
    'nav_label' => 'Executive & Family Digital Protection',
    'category' => 'digital-investigations',
    'badge' => 'VIP PRIVACY & RESIDENTIAL CYBER SHIELD',
    'tagline' => 'Bespoke privacy defense, home network security, and anti-surveillance protection for leaders and high-profile families.',
    'short_desc' => 'Tailored cybersecurity, threat intelligence, and digital privacy shielding protecting corporate executives, board members, public figures, and high-net-worth families from targeted cyber risks.',
    'overview' => 'C-suite executives, high-net-worth individuals, and public figures represent prime targets for sophisticated cybercriminals seeking corporate secrets, ransom opportunities, and private personal disclosures. Our Executive & Family Digital Protection service delivers 360-degree digital perimeter defense. We conduct comprehensive vulnerability audits of personal residences, executive smart home IoT devices, personal smartphones, tablets, and private email accounts. We scrub sensitive personal identifying information (PII) from data broker registries, implement secure encrypted communications, deploy SIM-swap protection, and monitor dark web channels for emerging threats against the family.',
    'why_needed' => 'While corporate offices are fortified with enterprise firewalls and SOC monitoring, executives frequently access sensitive corporate data from vulnerable home Wi-Fi networks and personal devices. Hackers actively target family members\' unsecured laptops and social accounts to gain lateral access into corporate crown jewels.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Residential & Smart Home Network Hardening',
        'desc' => 'Securing home routers, Wi-Fi 6 networks, smart TVs, and IoT cameras against unauthorized remote access.',
      ),
      1 => 
      array (
        'title' => 'Personal Device Forensic Health Checks',
        'desc' => 'Scanning personal phones and laptops for commercial spyware, stalkerware, and rogue configuration profiles.',
      ),
      2 => 
      array (
        'title' => 'SIM-Swap & Telecommunications Shielding',
        'desc' => 'Setting up carrier PIN protections, port-out freezes, and eSIM security to eliminate mobile hijacking.',
      ),
      3 => 
      array (
        'title' => 'Data Broker Privacy Scrubbing',
        'desc' => 'Removing home addresses, phone numbers, and family records from public search directories and data aggregators.',
      ),
      4 => 
      array (
        'title' => 'Dark Web Executive Threat Monitoring',
        'desc' => 'Continuous alerts for leaked personal credentials, passwords, and private records across illicit forums.',
      ),
      5 => 
      array (
        'title' => 'Travel Cybersecurity Protocols',
        'desc' => 'Hardened portable routers, burner configurations, and secure encrypted VPNs for international travel.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Threat Modeling & Reconnaissance',
        'desc' => 'Assessing the public digital footprint, family exposure levels, and personal device attack vectors.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Residential Network & Device Audit',
        'desc' => 'Penetration testing home Wi-Fi, smart home IoT hubs, personal laptops, smartphones, and tablets.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Forensic Sanitization & Hardening',
        'desc' => 'Eliminating identified stalkerware, configuring DNS filtering, and enforcing zero-trust access controls.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'PII Scrubbing & Carrier Shielding',
        'desc' => 'Excising family records from public data broker sites and locking carrier accounts with high-security PINs.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => '24/7 Threat Concierge Support',
        'desc' => 'Continuous dark web surveillance, VIP emergency response line, and periodic scheduled checkups.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Executive Cyber Risk Scorecard & Threat Profile',
      1 => 'Residential Network Hardening & Architecture Blueprint',
      2 => 'Device Sanitization & Spyware Audit Certificates',
      3 => 'PII Data Scrubbing Completion Report',
      4 => 'Dedicated Incident Concierge Hotline & Emergency Playbook',
    ),
    'compliance' => 
    array (
      0 => 'NIST Privacy Framework (Cybersecurity for High-Value Targets)',
      1 => 'Digital Personal Data Protection Act (DPDP) 2023',
      2 => 'ISO/IEC 27701 Privacy Information Management',
      3 => 'OSAC High-Risk Executive Protection Standards',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'How do you detect if an executive\'s personal phone has been tapped or infected with spyware?',
        'a' => 'We perform deep mobile forensic analysis, inspecting outbound network telemetry, examining system log files, checking for unauthorized root/jailbreak profiles, and analyzing installed certificates against known commercial stalkerware signatures.',
      ),
      1 => 
      array (
        'q' => 'Does this service disrupt our family\'s normal daily internet use?',
        'a' => 'Not at all. We design protections to operate invisibly in the background. Family members continue using their favorite apps and devices with enhanced, effortless security.',
      ),
      2 => 
      array (
        'q' => 'What happens if an executive or family member experiences an emergency while traveling abroad?',
        'a' => 'Our clients have 24/7 access to our dedicated emergency concierge. We provide remote emergency triage, account containment, and secure replacement device deployment anywhere in the world.',
      ),
    ),
  ),
  'cybersecurity-awareness-lea-training' => 
  array (
    'title' => 'Cybersecurity Awareness & LEA Training',
    'nav_label' => 'Cybersecurity Awareness & LEA Training',
    'category' => 'digital-investigations',
    'badge' => 'LAW ENFORCEMENT & INSTITUTIONAL ACADEMY',
    'tagline' => 'Specialized training programs in digital forensics, cybercrime investigation, and corporate fraud defense.',
    'short_desc' => 'Hands-on, practitioner-led capacity-building programs designed for police departments, law enforcement officers, judiciary personnel, corporate security teams, and academic institutions.',
    'overview' => 'As cybercrime tactics grow increasingly sophisticated, law enforcement personnel and corporate security officers require up-to-date, practical investigative techniques. Cyber Kovai\'s Cybersecurity Awareness & LEA Training division conducts specialized, interactive workshops and simulation labs. Led by certified digital forensic examiners and cyber intelligence practitioners, our modules cover end-to-end cybercrime investigations: electronic evidence seizure at crime scenes, mobile device extraction, cryptocurrency transaction tracing, open-source intelligence (OSINT), and preparation of Section 65B court evidence.',
    'why_needed' => 'Over 70% of electronic evidence in criminal prosecutions is contested due to procedural errors committed during first-response seizure. Specialized training empowers officers and corporate investigators to handle digital evidence correctly from day one, drastically boosting conviction rates and organizational resilience.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Crime Scene Digital Evidence Handling',
        'desc' => 'Hands-on training in Faraday packaging, volatile triage, and chain-of-custody documentation under ISO 27037.',
      ),
      1 => 
      array (
        'title' => 'Cryptocurrency Investigation & Seizure',
        'desc' => 'Tracing on-chain wallet hops, interacting with exchanges, and executing lawful wallet asset seizures.',
      ),
      2 => 
      array (
        'title' => 'Advanced OSINT & Social Media Reconnaissance',
        'desc' => 'De-anonymizing threat actors, geolocating imagery, and analyzing digital footprints using open-source tools.',
      ),
      3 => 
      array (
        'title' => 'CDR, IPDR & Tower Dump Analytics',
        'desc' => 'Parsing telecom Call Detail Records and Internet Protocol Detail Records for criminal movement mapping.',
      ),
      4 => 
      array (
        'title' => 'Dark Web & Cybercrime Syndicate Operations',
        'desc' => 'Navigating Tor hidden services, understanding escrow markets, and identifying malware-as-a-service kits.',
      ),
      5 => 
      array (
        'title' => 'Corporate Security & Employee Awareness',
        'desc' => 'Simulated phishing attacks, social engineering defenses, and incident escalation protocols for staff.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Training Needs Assessment',
        'desc' => 'Evaluating organizational proficiency levels, jurisdiction requirements, and specific threat landscape.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Hands-On Scenario Design',
        'desc' => 'Formulating realistic simulated cybercrime case files, forensic images, and blockchain audit scenarios.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Interactive Workshop Execution',
        'desc' => 'Conducting practitioner-led intensive bootcamps with 80% practical hands-on laboratory exercises.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Simulation Drills & Practical Exam',
        'desc' => 'Testing participants on live forensic artifact extraction, reporting, and evidence defense.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Certification & Ongoing Resources',
        'desc' => 'Issuing verified certificates of competency, field handbooks, and post-training advisory access.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Comprehensive Cybercrime Investigation Field Manual & SOPs',
      1 => 'Practical Forensic Toolkits & Open-Source Software Resource Pack',
      2 => 'Real-World Simulated Case Datasets for Ongoing Practice',
      3 => 'Official Certificate of Completion (Authorized by Cyber Kovai Academy)',
      4 => '6 Months Post-Training Technical Advisory Access',
    ),
    'compliance' => 
    array (
      0 => 'Bureau of Police Research & Development (BPR&D) Guidelines',
      1 => 'National Cyber Crime Training Centre (NCCTC) Curricula',
      2 => 'ISO/IEC 27037 Digital Evidence Standards',
      3 => 'Information Technology Act 2000 & Criminal Procedure Code',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Are your training sessions theoretical or hands-on?',
        'a' => 'All our training modules are 80% hands-on practical exercises. Participants analyze real (anonymized) digital forensic images, trace actual blockchain transactions, and build complete case dossiers in sandbox environments.',
      ),
      1 => 
      array (
        'q' => 'Can you conduct on-premise training sessions for police departments or corporate headquarters?',
        'a' => 'Yes. We conduct both on-premise intensive workshops at police academies and corporate facilities across India, as well as live virtual interactive bootcamps.',
      ),
      2 => 
      array (
        'q' => 'Are the certificates recognized for professional credentials?',
        'a' => 'Yes. Certificates issued by Cyber Kovai attest to verifiable practical competencies in digital forensics, OSINT, and cybercrime investigation recognized by legal and corporate sectors.',
      ),
    ),
  ),
  'child-digital-safety-protection' => 
  array (
    'title' => 'Child Digital Safety & Protection',
    'nav_label' => 'Child Digital Safety & Protection',
    'category' => 'digital-investigations',
    'badge' => 'CHILD SAFEGUARDING & CSAM PREVENTION',
    'tagline' => 'Confidential investigation of cyberbullying, predatory grooming, and child sexual abuse material (CSAM) reporting.',
    'short_desc' => 'Specialized, highly sensitive investigations to protect children and adolescents from online predators, cyberbullying, extortion, and digital exploitation risks.',
    'overview' => 'The digital landscape presents severe risks for children and adolescents, ranging from predatory grooming on gaming platforms and social apps to severe cyberbullying, sextortion, and non-consensual image distribution. Cyber Kovai\'s Child Digital Safety & Protection unit provides confidential, trauma-informed investigation services for concerned parents, educational institutions, child protection NGOs, and legal guardians. We conduct discrete forensic audits of devices to identify predatory communications, preserve evidence of cyberbullying for school and police interventions, track anonymous harassers, and execute immediate mandatory reporting of Child Sexual Abuse Material (CSAM) to national and international authorities (NCMEC / CyberTipline and National Cyber Crime Portal).',
    'why_needed' => 'Children often hesitate to tell parents about online threats out of fear, shame, or confusion, allowing predatory grooming or cyberbullying to escalate unchecked. Professional, compassionate investigation uncovers the truth, stops victimization, preserves legal evidence, and restores digital safety and emotional peace of mind.',
    'key_features' => 
    array (
      0 => 
      array (
        'title' => 'Anti-Grooming & Predator Investigation',
        'desc' => 'Identifying predatory behavioral patterns, fake underage profiles, and coercion attempts across messaging platforms.',
      ),
      1 => 
      array (
        'title' => 'Cyberbullying & Defamation Documentation',
        'desc' => 'Forensically capturing abusive group chats, smear pages, and anonymous harassment accounts with legal validity.',
      ),
      2 => 
      array (
        'title' => 'Minor Sextortion Emergency Response',
        'desc' => 'Immediate containment, non-payment guidance, and takedown of compromised personal imagery.',
      ),
      3 => 
      array (
        'title' => 'CSAM Detection & Mandatory Reporting',
        'desc' => 'Zero-tolerance identification and expedited reporting to NCMEC CyberTipline and Indian Cyber Crime units.',
      ),
      4 => 
      array (
        'title' => 'Gaming Platform & App Security Audits',
        'desc' => 'Reviewing Discord, Roblox, Minecraft, Snapchat, and Instagram privacy configurations and communication permissions.',
      ),
      5 => 
      array (
        'title' => 'Parental Digital Safety Consultation',
        'desc' => 'Equipping parents with discreet monitoring techniques and age-appropriate digital safety guidelines.',
      ),
    ),
    'methodology' => 
    array (
      0 => 
      array (
        'step' => '01',
        'title' => 'Confidential Consultation & Triage',
        'desc' => 'Understanding the situation with empathy, assessing imminent danger, and establishing a discrete action plan.',
      ),
      1 => 
      array (
        'step' => '02',
        'title' => 'Discrete Device & Chat Forensic Audit',
        'desc' => 'Extracting unallocated chats, hidden media caches, and app interaction logs under strict privacy controls.',
      ),
      2 => 
      array (
        'step' => '03',
        'title' => 'Predator & Harasser Attribution',
        'desc' => 'Cross-referencing digital handles, phone numbers, and IP traces to identify the individual behind the harassment.',
      ),
      3 => 
      array (
        'step' => '04',
        'title' => 'Emergency Takedown & Statutory Reporting',
        'desc' => 'Reporting CSAM or acute threats immediately to national law enforcement and international child protection bodies.',
      ),
      4 => 
      array (
        'step' => '05',
        'title' => 'Resolution Dossier & Parental Shielding',
        'desc' => 'Delivering evidence for school interventions or police FIRs, followed by robust parental control hardening.',
      ),
    ),
    'deliverables' => 
    array (
      0 => 'Confidential Child Safety Investigation Dossier',
      1 => 'Comprehensive Evidence Timeline with Attributed Communication Transcripts',
      2 => 'Emergency Takedown Confirmations & Escalation Records',
      3 => 'Law Enforcement / NCMEC Official Reporting Confirmation',
      4 => 'Personalized Child Digital Protection & Device Hardening Blueprint',
    ),
    'compliance' => 
    array (
      0 => 'Protection of Children from Sexual Offences (POCSO) Act 2012',
      1 => 'IT Act 2000 (Section 67B - Child Sexual Abuse Material Prohibition)',
      2 => 'NCMEC (National Center for Missing & Exploited Children) Standards',
      3 => 'Interpol Specialist Group on Crimes Against Children Guidelines',
      4 => 'Children\'s Online Privacy Protection Act (COPPA) Principles',
    ),
    'faqs' => 
    array (
      0 => 
      array (
        'q' => 'Will my child know that their phone or laptop is being investigated?',
        'a' => 'We discuss the approach with parents in advance. We can conduct the forensic examination discretely while the child is asleep or at school, or collaboratively with the child in a compassionate, non-judgmental manner.',
      ),
      1 => 
      array (
        'q' => 'What happens if Child Sexual Abuse Material (CSAM) is discovered?',
        'a' => 'We have a strict zero-tolerance legal and ethical policy. Any discovered CSAM is immediately sealed under chain of custody and reported through mandatory statutory channels to the National Cyber Crime Reporting Portal and NCMEC without delay.',
      ),
      2 => 
      array (
        'q' => 'Can you help stop anonymous cyberbullies targeting my child at school?',
        'a' => 'Yes. We forensically document all defamatory posts and messages with Section 65B certificates and trace the origins of anonymous accounts. This provides undeniable proof that school principals and police cyber cells must act upon.',
      ),
    ),
  ),
);

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