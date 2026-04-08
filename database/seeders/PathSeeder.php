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
                'Laravel Mastery',
                'Node.js Engineering',
                'Python Backend (FastAPI)',
                'Go (Golang) Systems',
                'Java Spring Boot',
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
                        'roadmap' => $this->getDetailedRoadmap($title, $category),
                        'is_published' => true,
                    ]
                );
            }
        }
    }

    private function getDetailedRoadmap(string $title, string $category): array
    {
        $base = [
            'objectives' => [
                "Master the core principles of {$title}.",
                "Understand industry-standard workflows in the {$category} field.",
                'Build a professional portfolio demonstrating specialized skills.',
            ],
            'technologies' => ['Industry Standard Tools', 'Core Programming', 'Project Management'],
            'steps' => [
                ['title' => 'Foundational Phase', 'description' => "Introduction to the history and core concepts of {$title}."],
                ['title' => 'Core Technical Skills', 'description' => "Deep dive into the essential tools and languages used in {$category}."],
                ['title' => 'Advanced Specialization', 'description' => 'Mastering complex patterns and high-level technical requirements.'],
                ['title' => 'Real-world Application', 'description' => 'Building and deploying industrial-grade projects.'],
                ['title' => 'Professional Proficiency', 'description' => 'Final polish, industry standards, and interview preparation.'],
            ],
        ];

        return match ($title) {
            'Frontend Development' => [
                'objectives' => [
                    'Build lightning-fast, highly interactive user interfaces.',
                    'Master modern reactive frameworks like React, Vue, or Livewire.',
                    'Ensure 100% accessible and responsive design cross-browser.',
                    'Optimize web applications for Core Web Vitals and SEO.',
                ],
                'technologies' => ['HTML5', 'CSS3/Tailwind', 'JavaScript ES6+', 'React/Vue/Livewire', 'Vite', 'TypeScript'],
                'steps' => [
                    ['title' => 'Semantic HTML & Modern CSS', 'description' => 'Master Flexbox, CSS Grid, and responsive patterns without frameworks.'],
                    ['title' => 'JavaScript Logic Core', 'description' => 'Async/Await, DOM manipulation, JSON handling, and functional programming.'],
                    ['title' => 'The Modern Build Tooling', 'description' => 'Learn NPM environment, Vite configuration, and PostCSS processing.'],
                    ['title' => 'State & UI Frameworks', 'description' => 'Component architecture, hooks/props, and global state management.'],
                    ['title' => 'API Orchestration', 'description' => 'Connecting to REST/GraphQL backends and handling async data streams.'],
                    ['title' => 'Performance & Accessibility', 'description' => 'Mastering Lighthouse scores, ARIA compliance, and lazy loading.'],
                    ['title' => 'Testing & Production', 'description' => 'Writing unit tests with Jest/Vitest and deploying to Vercel/Netlify.'],
                ],
            ],
            'Backend Development' => [
                'objectives' => [
                    'Architect scalable database schemas and server logic.',
                    'Build high-performance REST and GraphQL APIs.',
                    'Implement professional authentication and security protocols.',
                    'Master server-side state management and caching strategies.',
                ],
                'technologies' => ['Laravel (PHP)', 'Node.js', 'PostgreSQL/MySQL', 'Redis', 'Docker', 'REST/GraphQL'],
                'steps' => [
                    ['title' => 'Server Logic Foundations', 'description' => 'Master request-response cycles, routing, and controller logic.'],
                    ['title' => 'Relational Data Mastery', 'description' => 'Eloquent ORM, complex joins, indexing, and data normalization.'],
                    ['title' => 'Security & Auth', 'description' => 'Passport/Sanctum implementation, JWT, and defense against OWASP top 10.'],
                    ['title' => 'Real-time Systems', 'description' => 'WebSockets, broadcasting, and event-driven architecture.'],
                    ['title' => 'Caching & Performance', 'description' => 'Redis implementation, query optimization, and job queues.'],
                    ['title' => 'Cloud & Infrastructure', 'description' => 'Dockerizing apps and managing Nginx/Apache configurations.'],
                ],
            ],
            'Laravel Mastery' => [
                'objectives' => [
                    'Master the most popular PHP framework in the world.',
                    'Build enterprise-ready applications using TALL stack.',
                    'Master Eloquent, Service Container, and Job Queues.',
                ],
                'technologies' => ['PHP 8.3/8.4', 'Laravel 11/13', 'Livewire', 'PostgreSQL', 'Alpine.js'],
                'steps' => [
                    ['title' => 'Core PHP & OOP', 'description' => 'Deep dive into classes, interfaces, and modern PHP syntax.'],
                    ['title' => 'Laravel Foundations', 'description' => 'Routing, Middleware, Controllers, and Blade templating.'],
                    ['title' => 'Eloquent Deep Dive', 'description' => 'Relationships, Scopes, Accessors, and Query Optimization.'],
                    ['title' => 'Reactive Development', 'description' => 'Building dynamic UIs without JS using Livewire.'],
                    ['title' => 'Testing & CI/CD', 'description' => 'Writing Pest/PHPUnit tests and automated deployments.'],
                ],
             ],
             'Node.js Engineering' => [
                'objectives' => [
                    'Master the V8 engine and the asynchronous nature of Node.',
                    'Build scalable microservices and real-time APIs.',
                    'Master Express, NestJS, and Direct-DOM manipulation.',
                ],
                'technologies' => ['JavaScript/TypeScript', 'Node.js', 'Express/NestJS', 'MongoDB/Prisma', 'BullMQ'],
                'steps' => [
                    ['title' => 'Event Loop & Libuv', 'description' => 'Understanding non-blocking I/O and architectural patterns.'],
                    ['title' => 'Express.js Essentials', 'description' => 'Building RESTful APIs with standard middleware and error handling.'],
                    ['title' => 'NestJS Architecture', 'description' => 'Mastering Dependency Injection and modular architecture.'],
                    ['title' => 'Data Persistence (NoSQL/SQL)', 'description' => 'Integrating MongoDB or PostgreSQL with Prisma ORM.'],
                    ['title' => 'Microservices with RabbitMQ', 'description' => 'Scalable inter-service communication and distributed logging.'],
                ],
             ],
            'Full-Stack Development' => [
                'objectives' => [
                    'Bridge the gap between client and server seamlessly.',
                    'Understand the full lifecycle of a digital product.',
                    'Deploy and maintain self-sustaining web applications.',
                ],
                'technologies' => ['TALL Stack', 'MERN Stack', 'PostgreSQL', 'Docker', 'GitHub Actions'],
                'steps' => [
                    ['title' => 'Frontend Sync', 'description' => 'Build reactive interfaces that interact perfectly with server state.'],
                    ['title' => 'Backend Core', 'description' => 'Set up scalable server logic and automated data management.'],
                    ['title' => 'The Bridge (API Layer)', 'description' => 'Design clean contracts between the UI and the data server.'],
                    ['title' => 'DevOps & Deployment', 'description' => 'Automate the build, test, and release cycle across environments.'],
                    ['title' => 'Maintenance at Scale', 'description' => 'Implement monitoring, logging, and horizontal scaling strategies.'],
                ],
            ],
            'Game Programming (Unity, Unreal Engine)' => [
                'objectives' => [
                    'Master the mathematics of 3D spatial transformations.',
                    'Write high-performance gameplay systems in C# or C++.',
                    'Implement complex AI and physics-based interactions.',
                ],
                'technologies' => ['Unity/Unreal', 'C#/C++', 'HLSL Shaders', 'DirectX/Vulkan', 'Blender Integration'],
                'steps' => [
                    ['title' => 'Mathematical Foundations', 'description' => 'Vectors, Quaternions, and Dot/Cross products in 3D space.'],
                    ['title' => 'Game Engine Architecture', 'description' => 'Mastering the Game Loop, Component systems, and Scene Graphs.'],
                    ['title' => 'Gameplay Scripting', 'description' => 'Implementing player controllers, weapon systems, and inventory logic.'],
                    ['title' => 'AI & Pathfinding', 'description' => 'NavMeshes, Behavior Trees, and Finite State Machines.'],
                    ['title' => 'Physics & Collision', 'description' => 'RigidBody physics, raycasting, and trigger-based events.'],
                    ['title' => 'Rendering & VFX', 'description' => 'Shader development and particle systems for immersive visuals.'],
                ],
            ],
            'Cybersecurity' => [
                'objectives' => [
                    'Identify and mitigate advanced system vulnerabilities.',
                    'Design impenetrable network architectures.',
                    'Conduct professional digital forensics and incident response.',
                ],
                'technologies' => ['Kali Linux', 'Metasploit', 'Wireshark', 'Burp Suite', 'Python Automation'],
                'steps' => [
                    ['title' => 'Networking Deep Dive', 'description' => 'Mastering TCP/IP, OSI model, and network protocol analysis.'],
                    ['title' => 'Offensive Fundamentals', 'description' => 'Information gathering, OSINT, and vulnerability scanning.'],
                    ['title' => 'Exploitation Mechanics', 'description' => 'Buffer overflows, SQL injection, and XSS exploitation.'],
                    ['title' => 'Defensive Hardening', 'description' => 'Firewall configuration, IDS/IPS tuning, and OS hardening.'],
                    ['title' => 'Governance & Compliance', 'description' => 'Studying ISO 27001, SOC2, and legal framework requirements.'],
                ],
            ],
            'Artificial Intelligence & Machine Learning' => [
                'objectives' => [
                    'Design and train sophisticated neural network models.',
                    'Process and analyze massive datasets for predictive insights.',
                    'Implement modern NLP and Computer Vision solutions.',
                ],
                'technologies' => ['Python', 'PyTorch/TensorFlow', 'CUDA', 'Scikit-learn', 'HuggingFace'],
                'steps' => [
                    ['title' => 'Computational Math', 'description' => 'Linear Algebra, Calculus, and Probability for AI modeling.'],
                    ['title' => 'Data Engineering for AI', 'description' => 'ETL pipelines, data cleaning, and feature engineering at scale.'],
                    ['title' => 'Statistical Learning', 'description' => 'Regression, decision trees, and ensemble methods.'],
                    ['title' => 'Deep Learning Foundations', 'description' => 'Backpropagation, activation functions, and gradient descent.'],
                    ['title' => 'Vision & Language', 'description' => 'CNNs for image processing and Transformers for NLP.'],
                    ['title' => 'Reinforcement Learning', 'description' => 'Training agents through environmental feedback loops.'],
                ],
            ],
            'Cloud Architecture (AWS, Azure, GCP)' => [
                'objectives' => [
                    'Architect globally distributed, high-availability clouds.',
                    'Optimize cloud spend while maximizing performance.',
                    'Implement zero-trust security in multi-cloud environments.',
                ],
                'technologies' => ['AWS/Azure/GCP', 'Terraform', 'Kubernetes', 'Serverless', 'IAM'],
                'steps' => [
                    ['title' => 'Cloud Core Services', 'description' => 'Mastering VPCs, EC2, S3, and managed database systems.'],
                    ['title' => 'Infrastructure as Code', 'description' => 'Deep dive into Terraform and CloudFormation for automation.'],
                    ['title' => 'The Serverless Paradigm', 'description' => 'Building infinitely scalable apps with Lambda and Functions.'],
                    ['title' => 'Cloud Security (IAM)', 'description' => 'Mastering identity management and complex permission policies.'],
                    ['title' => 'Cost & Lifecycle Management', 'description' => 'Monitoring cloud costs and automating resource lifecycles.'],
                ],
            ],
            'Blockchain & Web3' => [
                'objectives' => [
                    'Write secure, gas-optimized Smart Contracts.',
                    'Build decentralized apps (DApps) with Web3 integrations.',
                    'Understand cryptographic primitives and DeFi mechanics.',
                ],
                'technologies' => ['Solidity', 'Ethereum/EVM', 'Ethers.js', 'IPFS', 'Hardhat'],
                'steps' => [
                    ['title' => 'Cryptographic Primitives', 'description' => 'Hashing, Public-Key signatures, and Merkle Trees.'],
                    ['title' => 'Blockchain Internals', 'description' => 'Consensus algorithms, P2P networking, and gas mechanics.'],
                    ['title' => 'Solidity Mastery', 'description' => 'Writing, testing, and auditing Ethereum smart contracts.'],
                    ['title' => 'DeFi Architecture', 'description' => 'Building AMMs, lending protocols, and yield strategies.'],
                    ['title' => 'DApp Frontend Bridge', 'description' => 'Connecting modern UIs to decentralized smart contracts.'],
                ],
            ],
            default => $base,
        };
    }

    private function getRoadmapDescription(string $title, string $category): string
    {
        return match ($title) {
            'Frontend Development' => 'Master the art of building beautiful, responsive user interfaces. Focus on HTML5, CSS3, modern JavaScript (ES6+), and popular frameworks like React or Vue. Learn accessibility, performance optimization, and mobile-first design.',
            'Backend Development' => 'Build the robust engines that power web applications. Master server-side languages like Laravel (PHP), Node.js, or Java. Learn database design (SQL/NoSQL), API development (REST/GraphQL), and server security.',
            'Laravel Mastery' => 'The ultimate path to becoming a Laravel artisan. Master the entire ecosystem from core framework logic to Sail, Pail, Pint, and Livewire/Flux.',
            'Node.js Engineering' => 'High-performance server-side JavaScript. Learn to build event-driven, scalable network applications and microservices.',
            'Python Backend (FastAPI)' => 'Rapid development with modern Python. Master FastAPI, Pydantic, and asynchronous data processing for AI-integrated backends.',
            'Go (Golang) Systems' => 'Build lightning-fast, concurrent systems. Master Go primitives, channels, and performance-critical network services.',
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
            'Artificial Intelligence & Machine Learning' => 'The core of modern intelligence. Understand the foundations of statistical learning, neural networks, and their real-world applications.',
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
