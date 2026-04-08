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
                        'description' => $this->getRoadmapDescription($title, $category),
                        'roadmap' => $this->getRoadmapSteps($title, $category),
                        'is_published' => true,
                    ]
                );
            }
        }
    }

    private function getRoadmapSteps(string $title, string $category): array
    {
        return match ($title) {
            'Frontend Development' => [
                ['title' => 'HTML5 & Modern CSS', 'description' => 'Master semantic structure, Flexbox, Grid, and responsive design fundamentals.'],
                ['title' => 'JavaScript Logic', 'description' => 'Deep dive into ES6+, Async/Await, DOM manipulation, and browser APIs.'],
                ['title' => 'The Toolchain', 'description' => 'Learn NPM, Vite, and utility-first CSS frameworks like Tailwind CSS.'],
                ['title' => 'Framework Mastery', 'description' => 'Choose React, Vue, or Livewire to build dynamic, component-based UIs.'],
                ['title' => 'Advanced Frontend', 'description' => 'Focus on state management, accessibility (ARIA), and performance optimization.'],
            ],
            'Backend Development' => [
                ['title' => 'Core Language', 'description' => 'Master PHP or Node.js logic, OOP principles, and control flow.'],
                ['title' => 'The Framework', 'description' => 'Learn Laravel or Express.js for robust, scalable server-side development.'],
                ['title' => 'Data Persistence', 'description' => 'Master SQL migrations, relationships, indexing, and ORM patterns.'],
                ['title' => 'API & Security', 'description' => 'Build REST/GraphQL APIs with secure authentication and middleware.'],
                ['title' => 'Deployment & CI/CD', 'description' => 'Automate deployments to cloud environments using modern CI/CD tools.'],
            ],
            'Full-Stack Development' => [
                ['title' => 'Frontend Foundations', 'description' => 'Build responsive UIs that provide intuitive user experiences.'],
                ['title' => 'Backend Integration', 'description' => 'Connect your frontend to secure, performant server-side logic.'],
                ['title' => 'Full-Lifecycle Mastery', 'description' => 'Manage the entire stack from database schema to cloud hosting.'],
            ],
            'Game Development' => [
                ['title' => 'Engine Core', 'description' => 'Master Unity with C# or Unreal Engine with C++.'],
                ['title' => '3D Transformation', 'description' => 'Learn the mathematics of vectors, matrices, and spatial physics.'],
                ['title' => 'Game Loop Logic', 'description' => 'Implement game mechanics, object pooling, and input handling.'],
                ['title' => 'Shaders & Effects', 'description' => 'Create immersive visuals using particle systems and vertex shaders.'],
            ],
            'Blockchain & Web3' => [
                ['title' => 'Decentralization', 'description' => 'Understand how distributed ledgers and consensus algorithms work.'],
                ['title' => 'Smart Contracts', 'description' => 'Master Solidity to build secure and audited on-chain protocols.'],
                ['title' => 'DApp Integration', 'description' => 'Connect decentralized protocols to modern web interfaces.'],
            ],
            'Artificial Intelligence & Machine Learning' => [
                ['title' => 'Data Science Foundations', 'description' => 'Master Python, NumPy, and Pandas for data manipulation.'],
                ['title' => 'Classical ML', 'description' => 'Learn supervised and unsupervised modeling with Scikit-learn.'],
                ['title' => 'Deep Learning', 'description' => 'Build neural networks using PyTorch or TensorFlow frameworks.'],
                ['title' => 'LLMs & Modern AI', 'description' => 'Explore transformer architectures and the future of generative AI.'],
            ],
            'Cybersecurity' => [
                ['title' => 'Defensive Basics', 'description' => 'Learn networking protocols and the CIA triad of security.'],
                ['title' => 'Ethical Hacking', 'description' => 'Study penetration testing methods to identify system vulnerabilities.'],
                ['title' => 'Security Engineering', 'description' => 'Design systems that are inherently secure by default.'],
            ],
            'Cloud Architecture (AWS, Azure, GCP)' => [
                ['title' => 'Compute & Networking', 'description' => 'Master EC2, VPCs, and global traffic management.'],
                ['title' => 'Serverless & Scale', 'description' => 'Build infinitely scalable apps using Lambda and managed DBs.'],
                ['title' => 'Infrastructure as Code', 'description' => 'Provision and manage entire clouds using Terraform or Pulumi.'],
            ],
            default => [
                ['title' => 'Introductory Concepts', 'description' => "Understand the fundamental landscape of {$title}."],
                ['title' => 'Intermediate Workflow', 'description' => "Master the core tools and standard industry practices for {$category}."],
                ['title' => 'Advanced Specialization', 'description' => 'Deep dive into edge cases, optimization, and complex implementations.'],
                ['title' => 'Industry Mastery', 'description' => 'Apply your skills to professional-grade projects and career readiness.'],
            ],
        };
    }

    private function getRoadmapDescription(string $title, string $category): string
    {
        return match ($title) {
            'Frontend Development' => 'Master the art of building beautiful, responsive user interfaces. Focus on HTML5, CSS3, modern JavaScript (ES6+), and popular frameworks like React or Vue. Learn accessibility, performance optimization, and mobile-first design.',
            'Backend Development' => 'Build the robust engines that power web applications. Master server-side languages like Laravel (PHP), Node.js, or Java. Learn database design (SQL/NoSQL), API development (REST/GraphQL), and server security.',
            'Full-Stack Development' => 'The complete package. Bridge the gap between frontend and backend. Learn to build entire web applications from scratch, manage deployments, and understand the full lifecycle of software development.',
            'Web Accessibility' => 'Ensure the web is usable by everyone. Deep dive into ARIA patterns, semantic HTML, keyboard navigation, and testing tools to meet WCAG standards.',
            'Progressive Web Apps (PWA)' => 'Combine the best of web and mobile. Learn service workers, manifest files, and offline data strategies to build apps that work everywhere, even without an internet connection.',
            'Web Security' => 'Protect your applications from modern threats. Study OWASP Top 10, encryption, secure authentication, and defense-against-CSRF/XSS attacks.',
            'Android Development' => 'Build native mobile apps for the world’s most popular OS. Master Kotlin and Android Studio, learn about Material Design, and explore Jetpack Compose.',
            'iOS Development' => 'Create premium experiences for the Apple ecosystem. Master Swift and SwiftUI, learn App Store guidelines, and explore native frameworks like CoreData and Combine.',
            'Cross-Platform Development (Flutter, React Native)' => 'Write once, run everywhere. Master Flutter (Dart) or React Native (JS/TS) to build high-performance apps for both iOS and Android simultaneously.',
            'Mobile UI/UX' => 'Design for the thumb. Master mobile-specific design patterns, gestures, navigation flows, and micro-interactions optimized for small screens.',
            'Mobile Performance Optimization' => 'Ensure your apps run smooth on any device. Learn about memory management, background processing, asset optimization, and battery efficiency.',
            'Ethical Hacking / Penetration Testing' => 'Think like a hacker to protect systems. Learn reconnaissance, vulnerability analysis, exploitation, and reporting to secure enterprise environments.',
            'Application Security' => 'Secure the code itself. Focus on DevSecOps, static/dynamic analysis (SAST/DAST), and building security directly into the SDLC.',
            'Network Security' => 'Fortify the perimeter. Learn about firewalls, VPNs, IDS/IPS, and securing network protocols to prevent unauthorized access.',
            'Cloud Security' => 'Secure your infrastructure in the cloud. Focus on IAM, VPC security, data encryption at rest/transit, and compliance in AWS, Azure, or GCP.',
            'Cryptography' => 'The science of secrets. Learn about hashing, symmetric/asymmetric encryption, digital signatures, and PKI infrastructure.',
            'Digital Forensics' => 'Investigate cyber incidents. Learn to collect, preserve, and analyze digital evidence to reconstruct events and identify attackers.',
            'Security Engineering' => 'Design systems that are secure by default. Build robust security architectures, authentication systems, and automated defense mechanisms.',
            'Threat Analysis' => 'Stay ahead of the curve. Learn to identify, assess, and mitigate emerging cybersecurity threats and actor behaviors.',
            'Cloud Architecture (AWS, Azure, GCP)' => 'Design scalable and resilient systems in the cloud. Master architectural patterns, cost optimization, and high availability across global regions.',
            'Cloud Engineering' => 'The hands-on side of the cloud. Learn to provision resources, manage scaling, and automate infrastructure using cloud-native tools.',
            'Serverless Computing' => 'Focus on code, not servers. Master AWS Lambda, Google Cloud Functions, and Event-driven architectures.',
            'Cloud Migration' => 'Moving the world to the cloud. Learn strategies for refactoring, rehosting, and replatforming legacy applications to modern cloud environments.',
            'CI/CD (Continuous Integration/Delivery)' => 'Automate the path from code to production. Build robust pipelines using GitHub Actions, GitLab CI, or Jenkins to ensure fast and reliable releases.',
            'Infrastructure as Code (Terraform, Ansible)' => 'Manage your infrastructure with code. Master Terraform for provisioning and Ansible for configuration management to ensure parity across environments.',
            'Monitoring & Logging' => 'Know what’s happening in real-time. Implement Prometheus, Grafana, and ELK stack to gain observability into your distributed systems.',
            'Site Reliability Engineering (SRE)' => 'The bridge between development and operations. Focus on availability, latency, performance, and capacity planning through automation.',
            'Containerization (Docker, Kubernetes)' => 'Master the deployment standard. Learn to containerize apps with Docker and orchestrate them at scale using Kubernetes clusters.',
            'Machine Learning Engineering' => 'Move models from notebooks to production. Learn to build scalable ML pipelines, manage models, and integrate AI into real-world applications.',
            'Deep Learning' => 'Unlock the power of neural networks. Master TensorFlow or PyTorch, learn about CNNs for vision, RNNs for sequences, and Transformers.',
            'Natural Language Processing (NLP)' => 'Teach machines to understand human language. Focus on sentiment analysis, machine translation, chatbots, and large language models (LLMs).',
            'Computer Vision' => 'Give eyes to your applications. Learn image processing, object detection, facial recognition, and spatial awareness using OpenCV and deep learning.',
            'Reinforcement Learning' => 'Train agents through trial and error. Explore Q-learning, policy gradients, and their applications in robotics and game AI.',
            'Game Programming (Unity, Unreal Engine)' => 'Bring worlds to life with code. Master C# for Unity or C++ for Unreal Engine, and learn the math behind 3D transformations.',
            'Game Design' => 'The art of fun. Learn about mechanics, level design, storytelling, and player psychology to create engaging gameplay experiences.',
            'Blockchain & Web3' => 'The future of decentralized finance and apps. Master Solidity, learn about dApps, smart contracts, and the mechanics of Ethereum and other L1s.',
            'UI/UX Design' => 'Design beautiful and intuitive digital products. Master Figma, learn user research, wireframing, prototyping, and the principles of visual design.',
            'Software Architecture' => 'Master the big picture. Learn about microservices, monolithic design, hexagonal architecture, and how to build scalable, maintainable systems.',
            'System Design' => 'Prepare for high-level technical challenges. Learn to design distributed systems, load balancing, caching strategies, and database sharding.',
            'Microservices Architecture' => 'Decompose the monolith. Learn service discovery, API gateways, inter-service communication, and managing distributed data.',
            'Distributed Systems' => 'Build systems that scale across the globe. Master consistency models, consensus algorithms like Paxos/Raft, and handling network partitions.',
            'API Design' => 'Build interfaces that developers love. Master REST, GraphQL, gRPC, versioning strategies, and comprehensive documentation.',
            'Software Testing & QA' => 'Ensure excellence in every release. Master unit testing, integration testing, and E2E testing using tools like Jest, Pest, or Cypress.',
            'Automated Testing' => 'Save time and prevent regressions. Learn to build automated test suites that run in your CI/CD pipelines.',
            'Performance Testing' => 'Stress test your limits. Master load testing and spike testing using JMeter or k6 to ensure your app can handle the traffic.',
            'Data Engineering' => 'The plumbing of the data world. Learn to build data pipelines, manage big data with Spark/Hadoop, and design robust data warehouses.',
            'Data Pipelines' => 'Move and transform data at scale. Master Airflow, Kafka, and ETL processes to ensure data is where it needs to be.',
            'AI & Machine Learning' => 'The core of modern intelligence. Understand the foundations of statistical learning, neural networks, and their real-world applications.',
            'Artificial Intelligence & Machine Learning' => 'The core of modern intelligence. Understand the foundations of statistical learning, neural networks, and their real-world applications.',
            'Blockchain & Web3' => 'The future of decentralized finance and apps. Master Solidity, learn about dApps, smart contracts, and the mechanics of Ethereum and other L1s.',
            'Cybersecurity' => 'The complete guide to digital defense. From ethical hacking to network security and threat analysis.',
            'DevOps & SRE' => 'Master the culture of automation. Combine development and operations to ship high-quality software faster and more reliably.',
            'Data Science & Analytics' => 'Turn data into insights. Master Python/R, statistical modeling, and data visualization to drive business decisions.',
            'Software Maintenance & Support' => 'The vital art of keeping software alive. Learn legacy code refactoring, bug hunting, and technical support excellence.',
            'Robotics' => 'Build the machines of the future. Learn robot programming, control systems, and the integration of hardware and software.',
            'Internet of Things (IoT)' => 'Connect the physical world. Master embedded programming, sensor integration, and cloud communication for smart devices.',
            'Quantum Computing (Advanced)' => 'Explore the frontier of computing. Learn about qubits, quantum gates, and algorithms that will redefine technology.',
            'AR/VR & Mixed Reality' => 'Create immersive digital worlds. Master spatial computing, 3D engines, and user interaction in virtual and augmented reality.',
            default => "A professional, curated roadmap for mastering {$title} within the {$category} field. Follow this sequence of expert-led playlists to achieve career-ready skills.",
        };
    }
}
