<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/lissajous.svg">
    <link rel="alternate icon" href="/favicon.ico">
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- p5.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.7.0/p5.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            font-weight: 200;
            background-color: #ffffff;
            color: #000000;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Top Left Animation */
        #top-left-animation {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            opacity: 0.6;
            pointer-events: none;
        }

        /* Quick Links Overlay */
        .quick-links {
            position: fixed;
            top: 50%;
            right: 30px;
            transform: translateY(-50%);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .quick-links a {
            color: rgba(0, 0, 0, 0.6);
            text-decoration: none;
            font-size: 13px;
            font-weight: 200;
            transition: all 0.3s ease;
            padding: 12px 0;
            position: relative;
            text-align: right;
        }

        .quick-links a:not(:last-child)::after {
            content: '';
            position: absolute;
            right: -15px;
            top: 50%;
            width: 1px;
            height: 20px;
            background: rgba(0, 0, 0, 0.2);
            transform: translateY(-50%) rotate(90deg);
        }

        .quick-links a:hover {
            color: rgba(0, 0, 0, 0.9);
            transform: translateX(-5px);
        }

        .quick-links a.active {
            color: #000000;
            font-weight: 300;
        }

        /* Sections */
        .section {
            min-height: 100vh;
            padding: 60px 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .section-content {
            max-width: 800px;
            width: 100%;
            text-align: center;
        }

        /* Home Section */
        #home {
            position: relative;
            background: #ffffff;
        }

        .home-content {
            position: relative;
            z-index: 2;
            padding: 40px;
        }

        .home-title {
            font-size: 3.5rem;
            font-weight: 200;
            margin-bottom: 20px;
            color: #000000;
        }

        .home-subtitle {
            font-size: 1.5rem;
            font-weight: 200;
            color: #666666;
            margin-bottom: 30px;
            min-height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .typing-text {
            display: inline-block;
            vertical-align: baseline;
        }

        .cursor {
            display: inline-block;
            background-color: #666666;
            width: 2px;
            height: 1em;
            vertical-align: baseline;
            animation: blink 1s infinite;
            margin: 0;
            padding: 0;
            border: none;
            transform: translateY(2px);
        }

        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }

        .divider {
            color: #999999;
            font-weight: 300;
            margin: 0 5px;
        }



        /* Section Styles */
        .section {
            background: #ffffff;
            border-bottom: 1px solid #f0f0f0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 200;
            margin-bottom: 30px;
            color: #000000;
        }

        .section-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333333;
            margin-bottom: 20px;
        }

        .content-left {
            text-align: left;
        }

        .content-center {
            text-align: center;
        }

        /* Projects Section */
        .project-carousel-container {
            position: relative;
            margin-top: 40px;
            overflow: hidden;
        }

        .project-carousel {
            display: flex;
            gap: 30px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 20px 0;
            -webkit-overflow-scrolling: touch;
        }

        .project-carousel::-webkit-scrollbar {
            height: 6px;
        }

        .project-carousel::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .project-carousel::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .project-carousel::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        .project-card {
            flex: 0 0 350px;
            height: 300px;
            padding: 25px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: white;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: inherit;
        }

        .carousel-nav {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .carousel-btn {
            padding: 8px 16px;
            background: #f5f5f5;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 200;
            transition: all 0.3s ease;
        }

        .carousel-btn:hover {
            background: #e0e0e0;
        }

        .project-title {
            font-size: 1.4rem;
            font-weight: 300;
            margin-bottom: 15px;
            color: #000000;
            flex-shrink: 0;
        }

        .project-description {
            font-size: 1rem;
            line-height: 1.6;
            color: #666666;
            margin-bottom: 20px;
            flex-grow: 1;
            overflow-y: auto;
            max-height: 150px;
            padding-right: 8px;
        }

        .project-description::-webkit-scrollbar {
            width: 4px;
        }

        .project-description::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .project-description::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .project-description::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        .project-tech {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            flex-shrink: 0;
        }

        .tech-tag {
            background: #f5f5f5;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            color: #666666;
            font-weight: 200;
        }

        /* Posts Section */
        .post-list {
            max-width: 600px;
            margin: 40px auto 0;
        }

        .post-item {
            padding: 25px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .post-item:last-child {
            border-bottom: none;
        }

        .post-title {
            font-size: 1.3rem;
            font-weight: 300;
            margin-bottom: 8px;
            color: #000000;
        }

        .post-title a {
            color: #000000;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .post-title a:hover {
            color: #666666;
        }

        .post-date {
            font-size: 0.9rem;
            color: #999999;
            margin-bottom: 10px;
        }

        .post-excerpt {
            font-size: 1rem;
            line-height: 1.6;
            color: #666666;
        }

        /* Post Pagination */
        .post-pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 40px;
        }

        .pagination-btn {
            padding: 10px 15px;
            background-color: #ffffff;
            border: 2px solid #e0e0e0;
            color: #666666;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 400;
            transition: all 0.3s ease;
            min-width: 45px;
        }

        .pagination-btn:hover {
            border-color: #000000;
            color: #000000;
        }

        .pagination-btn.active {
            background-color: #000000;
            color: #ffffff;
            border-color: #000000;
        }

        .post-page {
            transition: opacity 0.3s ease;
        }

        /* Contact Section */
        .contact-info {
            max-width: 400px;
            margin: 40px auto 0;
        }

        .contact-item {
            margin-bottom: 20px;
        }

        .contact-label {
            font-size: 0.9rem;
            color: #999999;
            margin-bottom: 5px;
        }

        .contact-value {
            font-size: 1.1rem;
            color: #000000;
            font-weight: 200;
        }

        .contact-value a {
            color: #000000;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .contact-value a:hover {
            color: #666666;
        }

        /* Resume Section */
        .resume-content {
            text-align: center;
            max-width: 500px;
            margin: 0 auto;
        }

        .resume-viewer {
            margin: 30px 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        .pdf-viewer {
            border: none;
            display: block;
            border-radius: 8px;
        }

        .resume-download {
            margin-top: 30px;
        }

        .download-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 400;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: 2px solid #000000;
        }

        .download-button:hover {
            background-color: #ffffff;
            color: #000000;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .download-button svg {
            transition: transform 0.3s ease;
        }

        .download-button:hover svg {
            transform: translateY(2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .quick-links {
                right: 15px;
            }

            .section {
                padding: 40px 20px;
            }

            .home-title {
                font-size: 2.5rem;
            }

            .home-subtitle {
                font-size: 1.2rem;
            }

            .about-title {
                font-size: 2rem;
            }

            .resume-viewer {
                margin: 20px 0;
            }

            .pdf-viewer {
                height: 500px;
            }

            .download-button {
                padding: 12px 24px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Top Left Animation -->
    <div id="top-left-animation"></div>
    
    <!-- Quick Links Overlay -->
    <nav class="quick-links">
        <a href="#home" class="nav-link active">Home</a>
        <a href="#about" class="nav-link">About</a>
        <a href="#projects" class="nav-link">Projects</a>
        <a href="#posts" class="nav-link">Posts</a>
        <a href="#resume" class="nav-link">Resume</a>
        <a href="#contact" class="nav-link">Contact</a>
        <a href="#life-thesis" class="nav-link">Life Thesis</a>
    </nav>

    <!-- Home Section -->
    <section id="home" class="section">
        <div class="section-content">
            <div class="home-content content-center">
                <h1 class="home-title">Eddie Chen</h1>
                <p class="home-subtitle">
                    <span class="typing-text" id="staticText"></span><span class="typing-text" id="dynamicText"></span><span id="endText"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section">
        <div class="section-content">
            <div class="content-left">
                <h2 class="section-title">About</h2>
                <ul class="section-text" style="margin-left: 1.5em;">
                    <li>I'm a Data Science and Economics student at Arizona State University (Class of '26, Dean's List)</li>
                    <li>I was born in San Jose and grew up between the Bay Area and China</li>
                    <li>I focus on mathematics and frontier AI, with experience building full-stack applications and deploying production ML systems</li>
                    <li>Co-founded mymelo.org and build microservices/Android apps that serve thousands of users monthly</li>
                    <li>My technical foundation spans Python, JavaScript, Java, and SQL – mostly self-taught through projects and competitions</li>
                    <li>Outside of tech, I powerlift, game, and am learning guitar and bouldering. I also follow economic trends and history closely</li>
                    <li>I split my time between San Francisco and Phoenix – always happy to connect about interesting projects</li>
                    <li>My vision for the future revolves around embodied AI and robotics, but we must fit our software around this mold. Currently spending time on ML tool synthesis and continuous learning, and learning robotics/drone tech as a hobby</li>
                </ul>
                <br><br><br>
                <div style="font-style: italic; color: #555; text-align: left;">
                    "The best way to predict the future is to create it." – Peter Drucker
                </div>
                
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="section">
        <div class="section-content">
            <div class="content-center">
                <h2 class="section-title">Projects</h2>
                <div class="project-carousel-container">
                    <div class="project-carousel" id="projectCarousel">
                        <a href="https://www.mymelo.org/" target="_blank" class="project-card">
                            <h3 class="project-title">Melo (HackTech 2025)</h3>
                            <p class="project-description">
                                Developed a 48-hour dermatology triage prototype achieving 97% image-classification 
                                accuracy on a 30K-image dataset. Trained a custom CNN with Gemini 2.0 Pro, 
                                deployed with Streamlit using Auth0/MongoDB for authentication and persistence.
                            </p>
                            <div class="project-tech">
                                <span class="tech-tag">Python</span>
                                <span class="tech-tag">CNN</span>
                                <span class="tech-tag">Gemini 2.0 Pro</span>
                                <span class="tech-tag">Streamlit</span>
                                <span class="tech-tag">Auth0</span>
                                <span class="tech-tag">MongoDB</span>
                            </div>
                        </a>
                        <a href="https://grocero.vercel.app/" target="_blank" class="project-card">
                            <h3 class="project-title">Grocero</h3>
                            <p class="project-description">
                                Full-stack meal planning platform serving 5,000+ monthly users. Features curated 
                                recipe database with intelligent ingredient aggregation that generates consolidated 
                                shopping lists, reducing food waste and simplifying grocery planning.
                            </p>
                            <div class="project-tech">
                                <span class="tech-tag">React</span>
                                <span class="tech-tag">Node.js</span>
                                <span class="tech-tag">Firebase</span>
                                <span class="tech-tag">Server Caching</span>
                                <span class="tech-tag">Full-stack</span>
                            </div>
                        </a>
                        <a href="https://github.com/Echen1246/GPT-E3.git" target="_blank" class="project-card">
                            <h3 class="project-title">GPT E3</h3>
                            <p class="project-description">
                                A recreation of ChatGPT2 with GPT-3 features, implementing character-level tokenization, 
                                rotary embeddings, and training on Project Gutenberg literature. Complete with 303M parameters, 
                                mixed precision training, and advanced text generation capabilities.
                            </p>
                            <div class="project-tech">
                                <span class="tech-tag">Python</span>
                                <span class="tech-tag">PyTorch</span>
                                <span class="tech-tag">Character-Level</span>
                                <span class="tech-tag">Rotary Embeddings</span>
                                <span class="tech-tag">Jupyter</span>
                            </div>
                        </a>
                        <div class="project-card">
                            <h3 class="project-title">Orchestrate.ai</h3>
                            <p class="project-description">
                                A distributed automation system that transforms any computer into an AI-powered worker. 
                                Built a centralized dashboard for deploying and orchestrating browser automation agents 
                                across multiple machines simultaneously. Users can send natural language tasks 
                                (like "fill out 100 job applications") to agents that autonomously navigate websites, 
                                fill forms, and complete repetitive browser work - eliminating the need for human 
                                clicking and typing while scaling productivity exponentially.
                            </p>
                            <div class="project-tech">
                                <span class="tech-tag">Electron</span>
                                <span class="tech-tag">Node.js</span>
                                <span class="tech-tag">WebSockets</span>
                                <span class="tech-tag">Playwright</span>
                                <span class="tech-tag">OpenAI API</span>
                            </div>
                        </div>
                        <a href="https://lahacks-kpg2-2cjvqzcg6-echen1246s-projects.vercel.app/" target="_blank" class="project-card">
                            <h3 class="project-title">Syllab.ai</h3>
                            <p class="project-description">
                                AI-powered educational platform designed to enhance learning experiences through 
                                intelligent content generation and personalized study recommendations. Built during 
                                LAHacks with modern web technologies and advanced NLP capabilities.
                            </p>
                            <div class="project-tech">
                                <span class="tech-tag">Next.js</span>
                                <span class="tech-tag">AI/ML</span>
                                <span class="tech-tag">NLP</span>
                                <span class="tech-tag">Vercel</span>
                                <span class="tech-tag">Education</span>
                            </div>
                        </a>
                        <a href="https://www.atomicpdf.org/" target="_blank" class="project-card">
                            <h3 class="project-title">AtomicPDF</h3>
                            <p class="project-description">
                                Web-based PDF toolkit built with React/Supabase/Stripe, serving 10k monthly 
                                active users and processing over 20k PDF tasks per month. Part of Atomic Suite 
                                with streamlined user experience and robust processing capabilities.
                            </p>
                            <div class="project-tech">
                                <span class="tech-tag">React</span>
                                <span class="tech-tag">Supabase</span>
                                <span class="tech-tag">Stripe</span>
                                <span class="tech-tag">PDF Processing</span>
                            </div>
                        </a>
                        <a href="https://chromewebstore.google.com/detail/scrapy/hohnpoeceiecjgbihcapbbkgcjjmjlfh?hl=en-US" target="_blank" class="project-card">
                            <h3 class="project-title">Scrapy</h3>
                            <p class="project-description">
                                A Chrome extension designed to assist data scientists and students with gathering 
                                relevant data for research or development. Features intelligent data filtering 
                                and saves website data in multiple formats for analysis.
                            </p>
                            <div class="project-tech">
                                <span class="tech-tag">JavaScript</span>
                                <span class="tech-tag">Chrome Extension</span>
                                <span class="tech-tag">Data Scraping</span>
                                <span class="tech-tag">Data Science</span>
                            </div>
                        </a>
                        <a href="https://sentiscape.laravel.cloud/" target="_blank" class="project-card">
                            <h3 class="project-title">Sentiscape</h3>
                            <p class="project-description">
                                A comprehensive sentiment analysis platform that processes text data to extract 
                                emotional insights and sentiment trends. Built with Laravel and modern web 
                                technologies to provide real-time sentiment analysis capabilities for businesses 
                                and researchers.
                            </p>
                            <div class="project-tech">
                                <span class="tech-tag">Laravel</span>
                                <span class="tech-tag">PHP</span>
                                <span class="tech-tag">Sentiment Analysis</span>
                                <span class="tech-tag">NLP</span>
                                <span class="tech-tag">Machine Learning</span>
                            </div>
                        </a>

                    </div>
                    <div class="carousel-nav">
                        <button class="carousel-btn" onclick="scrollCarousel('left')">← Previous</button>
                        <button class="carousel-btn" onclick="scrollCarousel('right')">Next →</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Posts Section -->
    <section id="posts" class="section">
        <div class="section-content">
            <div class="content-center">
                <h2 class="section-title">Posts</h2>
                <!-- Dynamic post list will be populated by JavaScript -->
                <div class="post-list" id="postList"></div>
                
                <!-- Dynamic pagination controls will be populated by JavaScript -->
                <div class="post-pagination" id="postPagination"></div>
            </div>
        </div>
    </section>

    <!-- Resume Section -->
    <section id="resume" class="section">
        <div class="section-content">
            <div class="content-center">
                <h2 class="section-title">Resume</h2>
                <div class="resume-content">
                    <p class="section-text">
                        View and download my latest resume to learn more about my experience, education, and technical skills.
                    </p>
                    <div class="resume-viewer">
                        <iframe 
                            src="/Edward Chen's Resume.pdf" 
                            type="application/pdf" 
                            width="100%" 
                            height="600"
                            class="pdf-viewer">
                            <p>Your browser does not support PDF viewing. <a href="/Edward Chen's Resume.pdf" target="_blank">Click here to download the PDF</a>.</p>
                        </iframe>
                    </div>
                    <div class="resume-download">
                        <a href="/Edward Chen's Resume.pdf" download="Edward_Chen_Resume.pdf" class="download-button">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7,10 12,15 17,10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Download Resume
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section">
        <div class="section-content">
            <div class="content-center">
                <h2 class="section-title">Contact</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-label">Email</div>
                        <div class="contact-value">
                            <a href="mailto:echen1246@gmail.com">echen1246@gmail.com</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-label">Phone</div>
                        <div class="contact-value">
                            <a href="tel:+19257255285">925-725-5285</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-label">GitHub</div>
                        <div class="contact-value">
                            <a href="https://github.com/Echen1246" target="_blank">github.com/Echen1246</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-label">Portfolio</div>
                        <div class="contact-value">
                            <a href="https://eddie.laravel.cloud" target="_blank">eddie.laravel.cloud</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-label">University</div>
                        <div class="contact-value">Arizona State University</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Life Thesis Section -->
    <section id="life-thesis" class="section">
        <div class="section-content">
            <div class="content-left">
                <h2 class="section-title">Life Thesis</h2>
                <div class="section-text" style="font-size: 1.2rem; line-height: 1.8; color: #333;">
                    <h3 style="font-weight: 300; margin-bottom: 20px; color: #000;">Here's How To Live: Create</h3>
                    <p style="margin-bottom: 20px; font-style: italic;">by Derek Sivers</p>
                    
                    <p style="margin-bottom: 20px;">
                        <strong>Die empty.</strong><br>
                        Get every idea out of your head and into reality.
                    </p>
                    
                    <p style="margin-bottom: 20px;">
                        Calling yourself creative doesn't make it true. Only launched creations are real. 
                        Unrealized ideas are just regrets.
                    </p>
                    
                    <p style="margin-bottom: 20px;">
                        Don't wait for inspiration. Work every day, no matter what. The Muse is a myth. 
                        Creativity comes from the work, not before it.
                    </p>
                    
                    <p style="margin-bottom: 20px;">
                        Suspend judgment when creating the first draft. Let it be terrible. 
                        You can't edit a blank page.
                    </p>
                    
                    <p style="margin-bottom: 20px;">
                        Create for yourself first. If it moves you, it will move others. 
                        Authenticity resonates more than perfection.
                    </p>
                    
                    <p style="margin-bottom: 20px;">
                        Ship it before you're ready. Done is better than perfect. 
                        You'll learn more from launching than from planning.
                    </p>
                    
                    <p style="margin-bottom: 20px;">
                        When you're gone, your work shows who you were. Not your intentions, 
                        not what you consumed, but only what you put out into the world.
                    </p>
                    
                    <p style="margin-bottom: 30px;">
                        <strong>Create.</strong>
                    </p>
                    
                    <div style="font-style: italic; color: #777; font-size: 0.9rem; margin-top: 30px;">
                        — Adapted from Derek Sivers' "How to Live"
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Top Left Animation
        let t = 0;
        let w = 250;
        let animationCanvas;
        let alpha = 100; // Define alpha for transparency

        function setup() {
            animationCanvas = createCanvas(250, 350);
            animationCanvas.parent('top-left-animation');
        }

        function draw() {
            clear(); // Use clear() instead of background() for full transparency
            stroke(0, 96);
            
            // Your exact animation function
            function a(x, y) {
                let k = (4 + sin(y * 2 - t) * 3) * cos(x / 29);
                let e = y / 8 - 13;
                let d = sqrt(k * k + e * e); // mag function
                
                let q = 3 * sin(k * 2) + 0.3 / k + sin(y / 25) * k * (9 + 4 * sin(e * 9 - d * 3 + t * 2));
                let c = d - t;
                
                point((q) + 30 * cos(c) + 130, q * sin(c) + d * 39 - 250);
            }
            
            // Your exact loop
            for (t += PI / 240, i = 1e4; i--;) {
                a(i, i / 235);
            }
        }

        // Typing Animation
        document.addEventListener('DOMContentLoaded', function() {
            const staticText = document.getElementById('staticText');
            const dynamicText = document.getElementById('dynamicText');
            const cursor = document.getElementById('cursor');
            
            const staticString = "I";
            const verbs = [
                "build",
                "train", 
                "fine-tune",
                "optimize",
            ];
            const endString = "models.";
            
            let currentVerbIndex = 0;
            let verbIndex = 0;
            let isTyping = true;
            let isDeleting = false;
            
            // Initialize the text immediately
            function initializeText() {
                staticText.textContent = "I ";
                dynamicText.innerHTML = verbs[0] + '<span class="cursor"></span>';
                const endText = document.getElementById('endText');
                endText.textContent = " " + endString;
                
                // Start the verb animation after a delay
                setTimeout(() => {
                    isDeleting = true;
                    isTyping = true;
                    verbIndex = verbs[0].length;
                    animateVerb();
                }, 2000);
            }
            
            function animateVerb() {
                const currentVerb = verbs[currentVerbIndex];
                
                if (isTyping && !isDeleting) {
                    if (verbIndex < currentVerb.length) {
                        dynamicText.innerHTML = currentVerb.substring(0, verbIndex + 1) + '<span class="cursor"></span>';
                        verbIndex++;
                        setTimeout(animateVerb, 80);
                    } else {
                        isTyping = false;
                        setTimeout(() => {
                            isDeleting = true;
                            isTyping = true;
                            animateVerb();
                        }, 2000);
                    }
                } else if (isDeleting) {
                    if (verbIndex > 0) {
                        dynamicText.innerHTML = currentVerb.substring(0, verbIndex - 1) + '<span class="cursor"></span>';
                        verbIndex--;
                        setTimeout(animateVerb, 50);
                    } else {
                        isDeleting = false;
                        currentVerbIndex = (currentVerbIndex + 1) % verbs.length;
                        verbIndex = 0; // Reset for next verb
                        setTimeout(() => {
                            isTyping = true;
                            animateVerb();
                        }, 300);
                    }
                }
            }
            
            // Start the typing animation
            initializeText();
            
            // Navigation functionality
            const navLinks = document.querySelectorAll('.nav-link');
            
            // Smooth scrolling for navigation links
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetSection = document.getElementById(targetId);
                    
                    if (targetSection) {
                        targetSection.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Update active navigation on scroll
            function updateActiveNav() {
                const sections = document.querySelectorAll('.section');
                const scrollPos = window.scrollY + window.innerHeight / 2;
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    const sectionId = section.getAttribute('id');
                    
                    if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                        navLinks.forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === `#${sectionId}`) {
                                link.classList.add('active');
                            }
                        });
                    }
                });
            }
            
            window.addEventListener('scroll', updateActiveNav);
        });

        // Carousel functionality
        function scrollCarousel(direction) {
            const carousel = document.getElementById('projectCarousel');
            const cardWidth = 350 + 30; // card width + gap
            const scrollAmount = direction === 'left' ? -cardWidth : cardWidth;
            
            carousel.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }

        // Dynamic post management system
        const blogPosts = [
            {
                title: "My First SWE Internship Interview Experience",
                url: "/posts/my-first-swe-interview-lessons",
                date: "September 23, 2025",
                excerpt: "Lessons learned from my first software engineering interview experience at Neuralink. A reflection on the technical depth, behavioral preparation, and live coding challenges that define modern SWE interviews."
            },
            {
                title: "Artificial Intelligence & Geopolitical Commentary",
                url: "/posts/ai-geopolitics",
                date: "July 30, 2025",
                excerpt: "An in-depth look at some recent geopolitical events, AI developments, and the Eastern Bloc's response to the US's AI dominance."
            },
            {
                title: "My Thoughts on General Intelligence",
                url: "/posts/my-thoughts-on-general-intelligence",
                date: "July 28, 2025",
                excerpt: "A philosophical exploration of AI through a radical lens. Examining whether current approaches to machine learning can truly achieve general intelligence, and what fundamental changes might be needed."
            },
            {
                title: "GPT E3: Building a Character-Level Language Model",
                url: "/posts/gpt-e3-implementation",
                date: "July 25, 2025",
                excerpt: "A recreation of ChatGPT2 with GPT-3 features, implementing character-level tokenization, rotary embeddings, and training on Project Gutenberg literature. Complete with 303M parameters and mixed precision training."
            },
            {
                title: "nuRAG: Mimicking Human Memory in Retrieval-Augmented Generation",
                url: "/posts/nurag-blog-post",
                date: "July 19, 2025",
                excerpt: "An exploration of memory-inspired approaches to improve RAG system performance. Traditional RAG systems use single flat vector storage, but nuRAG implements a tier-based approach inspired by human memory formation and consolidation."
            },
            {
                title: "The Memory Wall: Why AI Must Become Human Before It Can Surpass Us",
                url: "/posts/the-memory-wall",
                date: "July 11, 2025",
                excerpt: "An exploration of AI memory systems and their fundamental limitations. Why current approaches to machine memory may be hitting a wall, and how embodied experience might be the key to the next breakthrough in artificial intelligence."
            },
            {
                title: "Building Scalable Web Applications",
                url: "/posts/building-scalable-web-applications",
                date: "March 15, 2024",
                excerpt: "Exploring best practices for building web applications that can grow with your business. From architecture decisions to performance optimization techniques."
            },
            {
                title: "The Future of Frontend Development",
                url: "/posts/future-of-frontend-development",
                date: "February 28, 2024",
                excerpt: "A look at emerging trends and technologies shaping the future of frontend development, including new frameworks, tools, and methodologies."
            },
            {
                title: "Effective API Design Principles",
                url: "/posts/effective-api-design-principles",
                date: "January 20, 2024",
                excerpt: "Key principles and best practices for designing APIs that are intuitive, maintainable, and developer-friendly."
            }
        ];

        const POSTS_PER_PAGE = 4;
        let currentPage = 1;

        // Function to parse date strings into Date objects for sorting
        function parseDate(dateString) {
            return new Date(dateString);
        }

        // Function to sort posts by date (newest first)
        function sortPostsByDate(posts) {
            return posts.sort((a, b) => parseDate(b.date) - parseDate(a.date));
        }

        // Function to generate pagination based on total posts
        function generatePagination(totalPosts, currentPage) {
            const totalPages = Math.ceil(totalPosts / POSTS_PER_PAGE);
            const paginationContainer = document.getElementById('postPagination');
            
            if (totalPages <= 1) {
                paginationContainer.innerHTML = '';
                return;
            }
            
            let paginationHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const activeClass = i === currentPage ? 'active' : '';
                paginationHTML += `<button class="pagination-btn ${activeClass}" onclick="showPostPage(${i})" data-page="${i}">${i}</button>`;
            }
            
            paginationContainer.innerHTML = paginationHTML;
        }

        // Function to render posts for a specific page
        function renderPostsForPage(posts, pageNumber) {
            const startIndex = (pageNumber - 1) * POSTS_PER_PAGE;
            const endIndex = startIndex + POSTS_PER_PAGE;
            const postsForPage = posts.slice(startIndex, endIndex);
            
            const postListContainer = document.getElementById('postList');
            let postsHTML = '<div class="post-page" data-page="' + pageNumber + '">';
            
            postsForPage.forEach(post => {
                postsHTML += `
                    <article class="post-item">
                        <h3 class="post-title">
                            <a href="${post.url}">${post.title}</a>
                        </h3>
                        <p class="post-date">${post.date}</p>
                        <p class="post-excerpt">${post.excerpt}</p>
                    </article>
                `;
            });
            
            postsHTML += '</div>';
            postListContainer.innerHTML = postsHTML;
        }

        // Function to show a specific page
        function showPostPage(pageNumber) {
            currentPage = pageNumber;
            const sortedPosts = sortPostsByDate([...blogPosts]);
            renderPostsForPage(sortedPosts, pageNumber);
            generatePagination(sortedPosts.length, pageNumber);
        }

        // Function to add a new post (automatically sorts and repaginates)
        function addNewPost(post) {
            blogPosts.push(post);
            showPostPage(1); // Go to first page to show the new post (if it's the newest)
        }

        // Initialize posts system when page loads
        document.addEventListener('DOMContentLoaded', function() {
            showPostPage(1); // Show first page by default
        });
    </script>
</body>
</html> 