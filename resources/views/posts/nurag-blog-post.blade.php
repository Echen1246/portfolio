<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nuRAG: Mimicking Human Memory in Retrieval-Augmented Generation</title>
    
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

        .post-subtitle {
            font-style: italic;
            color: #666666;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .post-content {
            font-size: 1.1rem;
            color: #333333;
        }

        .post-content h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #000000;
            margin: 40px 0 20px 0;
            line-height: 1.3;
        }

        .post-content h3 {
            font-size: 1.4rem;
            font-weight: 500;
            color: #000000;
            margin: 30px 0 15px 0;
            line-height: 1.4;
        }

        .post-content h4 {
            font-size: 1.2rem;
            font-weight: 500;
            color: #000000;
            margin: 25px 0 10px 0;
            line-height: 1.4;
        }

        .post-content p {
            margin-bottom: 20px;
            text-align: justify;
        }

        .post-content em {
            font-style: italic;
            color: #555555;
        }

        .post-content strong {
            font-weight: 600;
            color: #000000;
        }

        .post-content blockquote {
            border-left: 4px solid #e0e0e0;
            padding-left: 20px;
            margin: 30px 0;
            font-style: italic;
            color: #555555;
        }

        .post-content pre {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
            margin: 20px 0;
            border: 1px solid #e9ecef;
        }

        .post-content code {
            background-color: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 0.9em;
        }

        .post-content pre code {
            background: none;
            padding: 0;
        }

        .post-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            font-size: 0.95rem;
        }

        .post-content th,
        .post-content td {
            border: 1px solid #e0e0e0;
            padding: 12px;
            text-align: left;
        }

        .post-content th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #000000;
        }

        .post-content tr:nth-child(even) {
            background-color: #fafafa;
        }

        .post-content ul, .post-content ol {
            margin: 20px 0;
            padding-left: 30px;
        }

        .post-content li {
            margin-bottom: 8px;
        }


        @media (max-width: 768px) {
            .post-title {
                font-size: 2rem;
            }
            
            .post-content {
                font-size: 1rem;
            }

            .post-content table {
                font-size: 0.85rem;
            }

            .post-content th,
            .post-content td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/#posts" class="back-link">← Back to Posts</a>
        
        <header class="post-header">
            <h1 class="post-title">nuRAG: Mimicking Human Memory in Retrieval-Augmented Generation</h1>
            <div class="post-meta">
                Published on July 19, 2025 • 15 min read
            </div>
            <p class="post-excerpt">
                An exploration of memory-inspired approaches to improve RAG system performance. Traditional RAG systems use single flat vector storage, but nuRAG implements a tier-based approach inspired by human memory formation and consolidation.
            </p>
        </header>

        <article class="post-content">
            <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 20px 0;">

            <h2>Introduction: Beyond Traditional RAG</h2>

            <p>RAG stands for Retrieval Augmented Generation. For those less familiar with the concept, we can think of a RAG layer as a battery pack for memory. If your 'phone' (the LLM) runs out of 'battery' (context window), we can connect an external memory source—the RAG layer—to provide additional context.</p>

            <p>Traditional RAG systems, which I'll refer to as <strong>NaiveRAG</strong>, use a single flat vector storage for all information. This introduces a critical efficiency problem: as the knowledge base grows, retrieval times increase, eventually causing more harm than good. Existing solutions include adding more RAG layers (like connecting multiple batteries), but this only delays the inevitable scalability issues.</p>

            <p>Modern research has produced sophisticated approaches to address these limitations, including <strong>HiRAG</strong> (Hierarchical RAG) and <strong>RAGCache</strong>. However, for this experiment, I implemented simplified versions inspired by these concepts due to technical constraints, which I'll refer to as my "HiRAG" and "CacheRAG" implementations to distinguish them from the official research.</p>

            <h2>How Advanced RAG Architectures Actually Work</h2>

            <p>Before diving into my experimental implementations, it's important to understand how these advanced RAG architectures work according to their official research papers:</p>

            <h3>Traditional RAG Architecture</h3>

            <p>Traditional RAG systems follow a straightforward pipeline: document chunking, embedding generation, vector storage, and similarity-based retrieval. The process works as follows:</p>

            <ol>
                <li><strong>Document Processing</strong>: Source documents are split into fixed-size chunks (typically 200-1000 tokens)</li>
                <li><strong>Embedding Generation</strong>: Each chunk is converted into dense vector representations using embedding models</li>
                <li><strong>Vector Storage</strong>: All embeddings are stored in a flat vector database (FAISS, Pinecone, Chroma)</li>
                <li><strong>Query Processing</strong>: User queries are embedded using the same model</li>
                <li><strong>Retrieval</strong>: Top-k most similar chunks are retrieved using cosine similarity or other distance metrics</li>
                <li><strong>Generation</strong>: Retrieved chunks are concatenated with the query as context for the LLM</li>
            </ol>

            <p>While effective for basic use cases, this approach suffers from several limitations: poor handling of document structure, inability to capture hierarchical relationships, and scalability issues as the knowledge base grows.</p>

            <h3>HiRAG: Hierarchical Knowledge Integration</h3>

            <p>Based on recent research, HiRAG addresses fundamental challenges in traditional RAG systems by utilizing hierarchical knowledge to enhance semantic understanding and structure capturing capabilities. The official HiRAG architecture includes:</p>

            <p><strong>Core Innovation</strong>: HiRAG creates multi-level semantic relationships between entities and concepts, capturing both local (within-document) and global (cross-document) hierarchical structures while maintaining semantic coherence across different abstraction levels.</p>

            <p><strong>Key Components</strong>:</p>
            <ul>
                <li><strong>Hierarchical Knowledge Graph Construction</strong>: Creates comprehensive semantic relationships beyond simple document chunking</li>
                <li><strong>Structure-Aware Indexing</strong>: Organizes information at multiple granularities simultaneously</li>
                <li><strong>Hierarchical Retrieval</strong>: Leverages structural relationships during retrieval, enabling traversal up or down the hierarchy based on query requirements</li>
            </ul>

            <h3>RAGCache: Intelligent Computational Caching</h3>

            <p>The official RAGCache research introduces a sophisticated multilevel dynamic caching system that goes far beyond simple document caching. RAGCache identifies performance bottlenecks as long sequences due to knowledge injection and implements:</p>

            <p><strong>Core Architecture</strong>:</p>
            <ul>
                <li><strong>Multilevel Caching</strong>: Caches key-value pairs from attention mechanisms, intermediate computational states, and knowledge representations</li>
                <li><strong>Intelligent Replacement</strong>: Uses semantic similarity, computational cost, and access patterns for cache management decisions</li>
                <li><strong>Dynamic Adaptation</strong>: Adjusts caching strategy based on usage patterns and computational efficiency</li>
            </ul>

            <p><strong>Key Innovations</strong>:</p>
            <ul>
                <li>Caches intermediate computational states rather than just final results</li>
                <li>Considers computational cost when making eviction decisions</li>
                <li>Uses semantic similarity to predict cache utility</li>
                <li>Achieves significant latency reduction while maintaining accuracy</li>
            </ul>

            <h3>My Experimental Implementations</h3>

            <p>For this comparative study, I implemented simplified versions of these approaches due to technical constraints:</p>

            <ul>
                <li><strong>My "HiRAG"</strong>: Uses a basic two-level parent-child document structure</li>
                <li><strong>My "CacheRAG"</strong>: Implements simple LRU (Least Recently Used) caching over traditional RAG</li>
                <li><strong>nuRAG</strong>: My novel memory-inspired approach detailed below</li>
            </ul>

            <p>While these simplified implementations don't capture the full sophistication of the official research, they provide a foundation for comparing different architectural approaches to RAG optimization.</p>

            <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 40px 0;">

            <h2>The Human Memory Inspiration</h2>

            <p>I created <strong>nuRAG</strong> (naming still under consideration) to mimic human cognitive behaviors—specifically how we form, consolidate, and retrieve memories. While I'm not a cognitive scientist, deep introspection led me to several key insights about human memory:</p>

            <h3>Core Memory Principles</h3>

            <ol>
                <li><strong>Frequency-Based Formation</strong>: Memories we use most (like our parents' phone numbers or home addresses) become deeply ingrained. I can still recall every address I've lived in since childhood.</li>

                <li><strong>Effort-Based Consolidation</strong>: Memories we 'work for' stick better—neurons that fire together, wire together. Information requiring cognitive effort is more likely to be retained.</li>

                <li><strong>Emotional Connection</strong>: Memories formed during "AHA!" moments or emotional experiences are strongly reinforced. This concept draws inspiration from Deepseek's novel distillation approaches.</li>

                <li><strong>Multi-Sensory Association</strong>: While current hardware limitations prevent full implementation, humans retrieve long-lost memories through sensory triggers—a scent reminds us of an old friend, or a taste brings back childhood memories.</li>
            </ol>

            <p><em>These insights should be taken with a grain of salt. I'm open to questions, critiques, or contributions through [email/Instagram], and I'm certainly not the most gifted when it comes to remembering things!</em></p>

            <h2>nuRAG Architecture: Human-like Memory Tiers</h2>

            <p>Building on open-source foundations, nuRAG implements a <strong>temporal, tier-based, dynamic learning approach</strong> to information retrieval.</p>

            <h3>Key Features</h3>

            <h4>1. Memory Tier System</h4>
            <pre><code>def __init__(self, model_name: str = "all-MiniLM-L6-v2"):
    super().__init__(model_name)
    # Memory Tiers
    self.memory_tiers = {
        "working": {},
        "short_term": {},
        "long_term": {}
    }
    self.indices = {} # FAISS indices for each tier
    self.doc_id_to_tier = {} # Fast lookup for a doc's tier

    # Consolidation Parameters
    self.consolidation_params = {
        'decay_lambda': 0.01,
        'w_recency': 0.4,
        'w_frequency': 0.5,
        'w_emotion': 0.1,
        'stm_threshold': 0.3,
        'ltm_threshold': 0.7,
        # --- NEW: Saliency parameter for "Aha!" moments ---
        'saliency_boost': 0.8 # How much an "Aha!" moment boosts the score
    }
    self.total_docs = 0</code></pre>

            <p>The system organizes information into three distinct tiers:</p>
            <ul>
                <li><strong>Working Memory</strong>: Initial storage for new information</li>
                <li><strong>Short-Term Memory</strong>: Accessed or moderately important information</li>
                <li><strong>Long-Term Memory</strong>: Highly accessed, important, or salient information</li>
            </ul>

            <h4>2. Dynamic Consolidation Mechanism</h4>
            <pre><code>def _consolidate_memories(self):
    # (This method is slightly modified to use the doc_id_to_tier mapping)
    promotions = defaultdict(list)
    for tier_name, tier_items in self.memory_tiers.items():
        for doc_id, item in tier_items.items():
            item.consolidation_score = self._calculate_consolidation_score(item)
            if tier_name == "working" and item.consolidation_score >= self.consolidation_params['stm_threshold']:
                promotions['to_stm'].append(doc_id)
            elif tier_name == "short_term" and item.consolidation_score >= self.consolidation_params['ltm_threshold']:
                promotions['to_ltm'].append(doc_id)

    for doc_id in promotions['to_stm']:
        if doc_id in self.memory_tiers['working']:
            item = self.memory_tiers['working'].pop(doc_id)
            item.memory_tier = "short_term"
            self.memory_tiers['short_term'][doc_id] = item
            self.doc_id_to_tier[doc_id] = "short_term"
    for doc_id in promotions['to_ltm']:
        if doc_id in self.memory_tiers['short_term']:
            item = self.memory_tiers['short_term'].pop(doc_id)
            item.memory_tier = "long_term"
            self.memory_tiers['long_term'][doc_id] = item
            self.doc_id_to_tier[doc_id] = "long_term"

    self._rebuild_indices()</code></pre>

            <h4>3. "AHA! Moment" Reward System</h4>
            <pre><code>def process_aha_moment(self, contributing_doc_ids: List[str]):
    """
    Applies a strong consolidation reward to memories that led to a
    high-confidence, correct outcome.
    """
    print(f"💡 Aha! Moment Triggered for {len(contributing_doc_ids)} memories.")
    for doc_id in contributing_doc_ids:
        tier = self.doc_id_to_tier.get(doc_id)
        if not tier: continue

        item = self.memory_tiers[tier][doc_id]

        # Apply the saliency boost
        boost = self.consolidation_params['saliency_boost']
        item.consolidation_score += (1.0 - item.consolidation_score) * boost
        item.emotional_weight = max(item.emotional_weight, 1.5) # Mark as highly salient

        # Check for immediate promotion
        if item.consolidation_score >= self.consolidation_params['ltm_threshold']:
            if tier != 'long_term':
                # Promote directly to long-term memory
                self.memory_tiers[tier].pop(doc_id)
                item.memory_tier = 'long_term'
                self.memory_tiers['long_term'][doc_id] = item
                self.doc_id_to_tier[doc_id] = 'long_term'

    # Update indices after potential promotions
    self._rebuild_indices()</code></pre>

            <p>This unique feature significantly boosts memories that contribute to successful retrievals, mimicking how humans reinforce memories associated with positive outcomes.</p>

            <h4>4. Tier-Based Retrieval with Recency Bias</h4>
            <pre><code>def retrieve(self, query: str, k: int = 5) -> Tuple[List[str], List[str]]:
    if not self.is_ready: return [], []

    if np.random.rand() < 0.1:
        self._consolidate_memories()

    query_embedding = np.array([self.encoder.embed_query(query)], dtype=np.float32)

    results = []
    retrieved_doc_ids_set = set()

    tier_boosts = {"working": 0.2, "short_term": 0.1, "long_term": 0.0}

    for tier_name, boost in tier_boosts.items():
        if self.indices.get(tier_name):
            index_info = self.indices[tier_name]
            scores, indices = index_info['index'].search(query_embedding, k=k)

            for score, idx in zip(scores[0], indices[0]):
                if idx != -1:
                    doc_id = index_info['doc_ids'][idx]
                    if doc_id not in retrieved_doc_ids_set:
                        item = self.memory_tiers[tier_name][doc_id]
                        item.update_access()
                        final_score = score * (1 + item.consolidation_score + boost)
                        results.append((item.content, final_score, doc_id))
                        retrieved_doc_ids_set.add(doc_id)

    results.sort(key=lambda x: x[1], reverse=True)
    top_k_results = results[:k]

    # Return both the content and the doc_ids for the reward mechanism
    retrieved_content = [content for content, _, _ in top_k_results]
    retrieved_doc_ids = [doc_id for _, _, doc_id in top_k_results]

    return retrieved_content, retrieved_doc_ids</code></pre>

            <p><em>For detailed implementation, visit the <a href="https://github.com/Echen1246/nuRAG" target="_blank" style="color: #333; text-decoration: underline;">GitHub repository</a>.</em></p>

            <h2>Experimental Comparison</h2>

            <h3>Systems Tested</h3>
            <ul>
                <li><strong>Naive RAG</strong>: Single flat vector store</li>
                <li><strong>Hierarchical RAG (My Implementation)</strong>: Two-level parent-child structure</li>
                <li><strong>Cache RAG (My Implementation)</strong>: LRU cache over Naive RAG</li>
                <li><strong>Human-like Memory RAG (nuRAG)</strong>: Our tier-based approach</li>
            </ul>

            <h3>Methodology</h3>
            <pre><code># Core evaluation setup
from datasets import load_dataset
from ragas.metrics import context_precision, context_recall, faithfulness

# Load SQuAD dataset subset
dataset = load_dataset("squad", split="train[:1000]")
test_queries = dataset.select(range(25))  # Resource-constrained evaluation

# Initialize systems with consistent embeddings
embedding_model = SentenceTransformer('all-MiniLM-L6-v2')

for system in [naive_rag, hierarchical_rag, cache_rag, nurag]:
    system.initialize(embedding_model)
    system.load_documents(documents)</code></pre>

            <p>The experiment used the Stanford Question Answering Dataset (SQuAD) with 1,000 documents and 25 test queries for evaluation, focusing on three key metrics:</p>

            <ul>
                <li><strong>Context Precision</strong>: Relevance of retrieved documents</li>
                <li><strong>Context Recall</strong>: Whether ground truth answers were found</li>
                <li><strong>Faithfulness</strong>: How well contexts support generated answers</li>
            </ul>

            <h3>Results</h3>

            <table>
                <thead>
                    <tr>
                        <th>System</th>
                        <th>Context Precision</th>
                        <th>Context Recall</th>
                        <th>Faithfulness</th>
                        <th>Avg Retrieval Time (s)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Naive RAG</td>
                        <td>0.193</td>
                        <td>0.6</td>
                        <td>0.576</td>
                        <td>0.008019</td>
                    </tr>
                    <tr>
                        <td>My Hierarchical RAG</td>
                        <td>0.120</td>
                        <td>0.4</td>
                        <td>0.326</td>
                        <td>0.008924</td>
                    </tr>
                    <tr>
                        <td>My Cache RAG</td>
                        <td>0.214</td>
                        <td>0.6</td>
                        <td>0.513</td>
                        <td>0.008110</td>
                    </tr>
                    <tr style="background-color: #f0f8ff;">
                        <td><strong>nuRAG</strong></td>
                        <td><strong>0.202</strong></td>
                        <td><strong>1.0</strong></td>
                        <td><strong>0.899</strong></td>
                        <td><strong>0.007372</strong></td>
                    </tr>
                </tbody>
            </table>

            <h3>Key Findings</h3>

            <p><strong>Perfect Context Recall</strong>: nuRAG achieved 1.0 Context Recall, successfully retrieving the ground truth document for all 25 queries—a significant improvement over other systems.</p>

            <p><strong>Superior Faithfulness</strong>: With a 0.899 Faithfulness score, nuRAG's retrieved contexts strongly supported correct answers, nearly doubling the performance of traditional approaches.</p>

            <p><strong>Fastest Retrieval</strong>: Despite its complexity, nuRAG was the fastest system, suggesting that intelligent memory organization improves efficiency.</p>

            <p>The "AHA! moment" mechanism likely played a crucial role, reinforcing correct documents in memory and leading to consistently better retrieval performance.</p>

            <h2>What This Means</h2>

            <p>The initial results suggest that incorporating memory-like behaviors into RAG systems can yield significant improvements:</p>

            <h3>Immediate Benefits</h3>
            <ul>
                <li><strong>More Reliable RAG</strong>: Systems that learn and reinforce important information show improved consistency</li>
                <li><strong>Faster Retrieval</strong>: Tiered organization eliminates the need to search entire corpora uniformly</li>
                <li><strong>Adaptive Performance</strong>: Memory systems can adapt to individual usage patterns</li>
            </ul>

            <h3>Future Implications</h3>
            <ul>
                <li><strong>Enhanced AI Agents</strong>: Memory-capable RAG could serve as a foundation for more sophisticated agents requiring extended information retention</li>
                <li><strong>Personalized Systems</strong>: Adaptive memory could enable truly personalized AI interactions</li>
                <li><strong>Extended Context Windows</strong>: This approach may contribute to longer, more coherent conversations</li>
            </ul>

            <h2>Next Steps</h2>

            <h3>Immediate Experiments</h3>
            <ol>
                <li><strong>Scale Testing</strong>: Evaluate with the full 1,000 query dataset for statistical robustness</li>
                <li><strong>Parameter Tuning</strong>: Optimize consolidation parameters (<code>decay_lambda</code>, weights, thresholds)</li>
                <li><strong>Dynamic k-values</strong>: Test varying retrieval quantities across different scenarios</li>
            </ol>

            <h3>Advanced Research</h3>
            <ol>
                <li><strong>Realistic Answer Generation</strong>: Implement actual LLM-based answer generation rather than placeholders</li>
                <li><strong>Complex Query Patterns</strong>: Test with multi-hop reasoning and conversational contexts</li>
                <li><strong>Catastrophic Forgetting</strong>: Explore how nuRAG handles conflicting information updates</li>
                <li><strong>Enhanced Emotional Weighting</strong>: Develop more sophisticated saliency mechanisms</li>
            </ol>
            <h3>Improvements</h3>
            <ol>
                <li><strong>Canonical HiRAG/RAGCache Implementation</strong>: While I did my best to make our custom version as close to the original as possible, these are still significantly dumbed down. I plan to find a way to implement the original architectures in a way to make testing more competitive, and expand on nuRAG to make it even more robust.</li>
                <li><strong>Dataset Choice</strong>: Using the SQuAD dataset was a bit of a cop out, it's not the best test for RAG systems. I plan to use hotpotQA for the next iteration for a more realistic test.</li>
                <li><strong>More Advanced Memory System</strong>: I plan to implement more detailed decay/forgetting mechanisms to prevent repetition of information and overfitting.</li>   
                <li><strong>Correctness</strong>: We blew the other custom models out of the water when it came to speed and context recall due to our 'AHA" moment, but our precision is still lacking.</li>
            </ol>

            <h2>Conclusion</h2>

            <p>This experiment provides initial evidence that mimicking human memory processes can significantly enhance RAG performance. By achieving perfect recall while maintaining speed advantages, nuRAG demonstrates the potential for memory-inspired approaches to create more intelligent and efficient information retrieval systems.</p>

            <p>Most importantly, I hope these developments contribute to longer context windows for LLM systems, enabling truly extended conversations between humans and AI.</p>

            <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 40px 0;">

            <p><strong>Disclaimer</strong>: This represents version 1.0 of the experiment. Due to API cost constraints (I'm poor), we used simplified versions of comparison systems while retaining core functionalities. Future iterations will incorporate full implementations and larger-scale testing.</p>

            <p><em>For complete implementation details, code, and reproducible experiments, visit the <a href="https://github.com/Echen1246/nuRAG" target="_blank" style="color: #333; text-decoration: underline;">nuRAG GitHub repository</a>.</em></p>

            <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 40px 0;">

            <p><em>Questions, critiques, or contributions welcome! Contact me through email or Instagram.</em></p>
        </article>
    </div>
</body>
</html> 