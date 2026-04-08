<?php

namespace Database\Seeders;

use App\Models\Path;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            'Web Development' => [
                'Frontend Development',
                'Backend Development',
                'Full-Stack Development',
                'Web Accessibility',
                'Progressive Web Apps (PWA)',
                'Web Security',
            ],
            'Mobile Application Development' => [
                'Android Development',
                'iOS Development',
                'Cross-Platform Development (Flutter, React Native)',
                'Mobile UI/UX',
                'Mobile Performance Optimization',
            ],
            'Desktop Application Development' => [
                'Windows Applications (.NET, WinForms, WPF)',
                'macOS Applications',
                'Linux Applications',
                'Cross-platform desktop apps (Electron, Qt)',
            ],
            'Game Development' => [
                'Game Programming (Unity, Unreal Engine)',
                'Game Design',
                'Graphics Programming',
                'Physics Simulation',
                'AR/VR Game Development',
            ],
            'Cybersecurity' => [
                'Ethical Hacking / Penetration Testing',
                'Application Security',
                'Network Security',
                'Cloud Security',
                'Cryptography',
                'Digital Forensics',
                'Security Engineering',
                'Threat Analysis',
            ],
            'Networking' => [
                'Network Engineering',
                'Network Administration',
                'Wireless Networks',
                'Network Automation',
                'SDN (Software Defined Networking)',
            ],
            'Systems Programming' => [
                'Operating Systems Development',
                'Embedded Systems',
                'Firmware Development',
                'Device Drivers',
                'Low-level programming (C, C++)',
            ],
            'Cloud Computing' => [
                'Cloud Architecture (AWS, Azure, GCP)',
                'Cloud Engineering',
                'Serverless Computing',
                'Cloud Migration',
            ],
            'DevOps & SRE' => [
                'CI/CD (Continuous Integration/Delivery)',
                'Infrastructure as Code (Terraform, Ansible)',
                'Monitoring & Logging',
                'Site Reliability Engineering (SRE)',
                'Containerization (Docker, Kubernetes)',
            ],
            'Data Engineering' => [
                'Data Pipelines',
                'ETL (Extract, Transform, Load)',
                'Big Data (Hadoop, Spark)',
                'Data Warehousing',
            ],
            'Artificial Intelligence & Machine Learning' => [
                'Machine Learning Engineering',
                'Deep Learning',
                'Natural Language Processing (NLP)',
                'Computer Vision',
                'Reinforcement Learning',
            ],
            'Data Science & Analytics' => [
                'Data Analysis',
                'Statistical Modeling',
                'Business Intelligence',
                'Visualization (Power BI, Tableau)',
            ],
            'Software Testing & QA' => [
                'Manual Testing',
                'Automated Testing',
                'Performance Testing',
                'Test Engineering',
            ],
            'Software Architecture' => [
                'System Design',
                'Microservices Architecture',
                'Distributed Systems',
                'API Design',
            ],
            'Software Maintenance & Support' => [
                'Bug Fixing',
                'Legacy System Maintenance',
                'Technical Support Engineering',
            ],
            'UI/UX Design' => [
                'User Interface Design',
                'User Experience Research',
                'Interaction Design',
                'Design Systems',
            ],
            'Product Engineering' => [
                'Product Management (technical side)',
                'Agile / Scrum Development',
                'MVP Development',
            ],
            'Blockchain & Web3' => [
                'Smart Contracts (Solidity)',
                'Decentralized Apps (DApps)',
                'Crypto Systems',
            ],
            'Internet of Things (IoT)' => [
                'IoT Development',
                'Smart Devices',
                'Edge Computing',
            ],
            'Robotics' => [
                'Robot Programming',
                'Automation Systems',
                'Control Systems',
            ],
            'Quantum Computing (Advanced)' => [
                'Quantum Algorithms',
                'Quantum Programming',
            ],
            'AR/VR & Mixed Reality' => [
                'Virtual Reality',
                'Augmented Reality',
                'Spatial Computing',
            ],
        ];

        foreach ($fields as $category => $paths) {
            foreach ($paths as $title) {
                Path::updateOrCreate(
                    ['slug' => Str::slug($title)],
                    [
                        'title' => $title,
                        'category' => $category,
                        'description' => "Professional learning journey for {$title} within the {$category} field. Start your path to mastery today.",
                        'is_published' => true,
                    ]
                );
            }
        }

        // Add some existing playlists to a sample path for demonstration
        $backendPath = Path::where('slug', 'backend-development')->first();
        if ($backendPath) {
            $backendPath->playlists()->syncWithoutDetaching([
                1 => ['order' => 1], // JAVA OOP
                2 => ['order' => 2], // PHP
            ]);
        }
    }
}
