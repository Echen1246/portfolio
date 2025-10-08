<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Thoughts on General Intelligence - Eddie Chen</title>
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 60px 40px;
        }

        .back-link {
            display: inline-block;
            color: #666666;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 40px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #000000;
        }

        .post-header {
            margin-bottom: 50px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 30px;
        }

        .post-title {
            font-size: 2.5rem;
            font-weight: 200;
            margin-bottom: 15px;
            color: #000000;
        }

        .post-meta {
            font-size: 14px;
            color: #999999;
            margin-bottom: 20px;
        }

        .post-excerpt {
            font-size: 1.2rem;
            color: #666666;
            font-weight: 200;
            line-height: 1.6;
        }

        .post-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333333;
        }

        .post-content h2 {
            font-size: 1.8rem;
            font-weight: 300;
            margin: 40px 0 20px;
            color: #000000;
        }

        .post-content h3 {
            font-size: 1.4rem;
            font-weight: 300;
            margin: 30px 0 15px;
            color: #000000;
        }

        .post-content p {
            margin-bottom: 20px;
        }

        .post-content ul, .post-content ol {
            margin: 20px 0;
            padding-left: 30px;
        }

        .post-content li {
            margin-bottom: 8px;
        }

        .post-content code {
            background: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9em;
        }

        .post-content pre {
            background: #f8f8f8;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
            margin: 20px 0;
            border: 1px solid #e0e0e0;
        }

        .post-content blockquote {
            border-left: 4px solid #e0e0e0;
            padding-left: 20px;
            margin: 20px 0;
            font-style: italic;
            color: #666666;
        }

        @media (max-width: 768px) {
            .container {
                padding: 40px 20px;
            }

            .post-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/#posts" class="back-link">← Back to Posts</a>
        
        <header class="post-header">
            <h1 class="post-title">My Thoughts on General Intelligence</h1>
            <div class="post-meta">
                Published on July 28, 2025 • 6 min read
            </div>
            <p class="post-excerpt">
                A philosophical exploration of AI through a radical lens. Examining whether current approaches to machine learning can truly achieve general intelligence, and what fundamental changes might be needed.
            </p>
        </header>

        <article class="post-content">
            <p>Let's take a step back and think about AI through a more radical lens. The systems and technologies we have today, from NLP to LLMs to tokenization, have all been groundbreaking innovations that change the way we live day to day. As a data science student, I could not be more happy that my skills in ML and mathematics are in more demand than ever; as a curious and creative individual, I can't help but wonder if we're going in the direction of AGI at all. Have humans, in the pursuit of profits and gamed improvements, lost sight of what General Intelligence really means? Can LLMs fundamentally create 'new' thought, or does that go against the very definition of an LLM? What if tokenization is a red herring?</p>

            <h2>The Human Learning Process</h2>

            <p>For me, I've always thought that in order for machines to achieve general intelligence, we must take a human approach; think of a newborn child, or maybe yourself x years ago. You were born with a number of neurons with your infant-sized brain. From day to day, you would go about your mundane life being cared for, taking in the vast world around you, every single experience, sight, sound, smell, touch, emotion, the most extreme multimodal learning. As you grow older, new neurons are grown; frequently used neurons are strengthened, and vice versa. We begin to learn basic concepts, from primitive emotions to elementary mathematics.</p>

            <h2>The Tokenization Problem</h2>

            <p>With this basic explanation of human learning in mind, we can now explore tokenization: this is the process where text gets chopped up into chunks (could be words, subwords or even characters), and each chunk is mapped to a fixed vector. The model can only work with these pre-defined symbols, so a chunk 'cat' will always be token X, and 'dog' will always be token Y. This is a far reach from how humans learn; we experience continuous sensory streams. No memory can be mapped to a single token, but we learn from a combination of senses and experiences that make that association concrete.</p>

            <p>A 'spaghetti' can be shaped by how we see it, what it smells like, what it tastes like, or how it can be a positive or negative experience. That's why everyone's definition of a 'spaghetti' may be different; for some, the texture is high quality grain, while for others it's processed mush; for some, it's a warm, home-cooked meal, while for others it's a traumatic food kitchen memory. For machines, 'spaghetti' will always just be token #2947, regardless of context, and can only be related to other tokens that were seen with it during training. This is a novelty problem; LLM's can't 'understand' why the smell of a dish may trigger childhood memories, or make someone sick, and can only pattern match from examples from people who disliked spaghetti. And so, this is the crux of my question: if LLMs can only regurgitate data it's seen before, how can an LLM achieve general intelligence?</p>

            <h2>The Missing Sensory Dimension</h2>

            <p>There is a massive, critical missing piece: sensory data. Human babies, while generally 'useless' (not actually useless, you know what I mean), are born with an incredible amount of sensory power that exceeds our advanced computers. The information we get from a visual nerve, the sound that is translated into our brain through vibrations, the smells that activate the various cortexes in our brain to process good and bad smells, the nerves throughout our body that can distinguish all physical sense, all combined into an experience, a memory, which stimulates the neurons in the brain. In comparison, we can only feed our machines one thing: text, broken down into chunks.</p>

            <p>Perhaps we're missing many, many complementary technologies for our computers that limit the data we have access to. Perhaps it's not a 'We've run out of data' problem, but more of a 'there's so much more data available, but beyond our reach' problem. The vast number of texts across the internet are an incredible source of information, no doubt; but a machine, a Generally Intelligent being in the future, will never truly understand anything, if it cannot learn through experience and the multimodal process we have. Would replicating the visual nerve push the needle of AGI along? What about nerves, or smell? What about a combination of all these?</p>

            <h2>The Future of Human-Machine Integration</h2>

            <p>Maybe I'm getting far ahead of myself when I say this, but a mix of man and machine should not be as taboo as we treat the concept today (at least, unspoken). It seems every single creature on Earth has the visual nerve, the capacity to sense things, feel, and combine their sensory experiences into a learning memory; yet, as humans who have gone beyond the reaches of our atmosphere, created supersonic vehicles and poked around DNA with gene editing tools, have not been able to do a true recreation of these capabilities. Cameras and microphones are not the same; they are for human brains to translate and comprehend, not a machine.</p>

            <p>It might be too early to talk about biotechnology and how we can combine man and machine (Cyberpunk-y), so baby steps that work with existing technology would be a great starting point. My brain, which does not yet think and work like an LLM and still has a semblance of creativity, can't think of a novel method besides tokenization, so tokenization will have to do. With simple text and tokens, how can we train our AI models to think differently? What about taking one specific part of the human learning process, the synaptic strengthening concept, and building it into reality? As in, repetitive experiences with a concept or word make that pathway more concrete, which can lead to specialization.</p>

            <h2>Repeated Intelligence vs. General Intelligence</h2>

            <p>I feel there are far more ideas but the speed of my fingers can't keep up with how fast I think. Going off this concept, we can go so far as to say that AI, being driven by LLMs, can be called RI instead, or Repeated/Regurgitated Intelligence.</p>

            <p>This is by no means a criticism of the brilliant scientists and predecessors that have pushed the field to what it is today; they are far more creative than me with the brains to back it up. But, as a sign of our times, we must think towards the future, and it seems to me that we are stuck in a rut. A thousand years from now, when we are all long gone, humanity will undoubtedly be in a different place. Current AI systems will be seen as primitive, like how us modern humans see the Code of Hammurabi on a stone tablet made eons ago; primitive, but a clear indication of how we got to where we are.</p>

            <p>Humanity will always prevail; but I can't help but wonder if I can, with my random thoughts and dreams, have the means one day to push the needle of human progress along.</p>
        </article>
    </div>
</body>
</html> 