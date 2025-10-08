<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPT E3: Building a Character-Level Language Model - Eddie Chen</title>
    
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

        .post-content pre {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 16px;
            margin: 20px 0;
            overflow-x: auto;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 0.9em;
            line-height: 1.4;
        }

        .post-content code {
            background-color: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 0.9em;
        }

        .output-block {
            background-color: #f1f3f4;
            border-left: 4px solid #4285f4;
            padding: 12px 16px;
            margin: 15px 0;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 0.85em;
            border-radius: 0 6px 6px 0;
        }


        @media (max-width: 768px) {
            .post-title {
                font-size: 2rem;
            }
            
            .post-content {
                font-size: 1rem;
            }

            .post-content pre {
                padding: 12px;
                font-size: 0.8em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/#posts" class="back-link">← Back to Posts</a>
        
        <header class="post-header">
            <h1 class="post-title">GPT E3: Building a Character-Level Language Model</h1>
            <div class="post-meta">
                Published on July 25, 2025 • 12 min read
            </div>
            <p class="post-excerpt">
                A recreation of ChatGPT2 with GPT-3 features, implementing character-level tokenization, rotary embeddings, and training on Project Gutenberg literature. Complete with 303M parameters and mixed precision training.
            </p>
        </header>

        <article class="post-content">
            <p>This is a recreation of ChatGPT2 (inspired by Andrej Karpathy) with features from the GPT-3 paper to serve as an 'updated' version. We will start by using the project_gutenberg dataset on HuggingFace, which is a comprehensive collection of literature spanning centuries.</p>

            <h2>Setup and Dependencies</h2>
            
            <p>We begin by setting up our environment and importing the necessary libraries. This implementation runs on Modal's serverless cloud with GPU acceleration.</p>

            <pre><code># Core Python and PyTorch
!pip install datasets
import math
import torch
import torch.nn as nn
from torch.nn import functional as F
import numpy as np
from datasets import load_dataset

# Make sure we're using a GPU (this notebook is being run on Modal with an L4 and minimal CPU/RAM)
device = 'cuda' if torch.cuda.is_available() else 'cpu'
print(f"Using device: {device}")

# Reproducibility
torch.manual_seed(1337)
if torch.cuda.is_available():
    torch.cuda.manual_seed(1337)</code></pre>

            <div class="output-block">
                Using device: cuda
            </div>

            <h2>Data Loading and Preprocessing</h2>

            <p>We load the Project Gutenberg dataset, limiting ourselves to 300 English books for computational efficiency. This gives us a substantial corpus of literature to train on.</p>

            <pre><code>from datasets import load_dataset

# Load English books and take only first 300
ds = load_dataset("manu/project_gutenberg", split="en", streaming=True)
ds_limited = ds.take(300)  

print("First item:", next(iter(ds_limited)))

# Concatenate all texts into one big string
text_data = ""
book_count = 0

for item in ds_limited:
    text_data += item['text'] + "\n\n"
    book_count += 1

print(f"Processed {book_count} English books")
print(f"Total dataset characters: {len(text_data)}")
print("Preview first 1000 characters:")
print(text_data[:100])</code></pre>

            <div class="output-block">
                Processed 300 English books<br>
                Total dataset characters: 116795982<br>
                Preview first 100 characters:<br>
                The Project Gutenberg eBook, Addison, by William John Courthope...
            </div>

            <h2>Character-Level Tokenization</h2>

            <p>We implement character-level tokenization, creating mappings between characters and integers. This approach is simpler than BPE but requires more tokens to represent the same text.</p>

            <pre><code># Gets unique characters
chars = sorted(list(set(text_data)))
vocab_size = len(chars)

# Create mappings
stoi = {ch:i for i,ch in enumerate(chars)}
itos = {i:ch for i,ch in enumerate(chars)}

def encode(s):
    return [stoi[c] for c in s]  # encode string to int
def decode(l):
    return ''.join([itos[i] for i in l])  # decode int to string

# Encode dataset
data = torch.tensor(encode(text_data), dtype=torch.long)

print(f"Dataset vocab size: {vocab_size}, total tokens: {len(data)}")</code></pre>

            <div class="output-block">
                Dataset vocab size: 406, total tokens: 116795982
            </div>

            <p>The vocab size from the cell above tells us there are 406 unique characters, as we are performing character-level tokenization. These characters would include A-Z, punctuation, whitespace, special characters and more. This is much more efficient than using word-level tokenization, which would (1) take much longer and (2) more compute.</p>

            <h2>Data Splitting and Batch Generation</h2>

            <p>We split our data into training and validation sets (90/10 split) and implement batch generation for efficient training.</p>

            <pre><code>n = int(0.9 * len(data))
train_data = data[:n]
val_data = data[n:]

print(f"Train tokens: {len(train_data)}, Val tokens: {len(val_data)}")

block_size = 128  # context length
batch_size = 64   # sequences per batch

def get_batch(split):
    data_split = train_data if split == 'train' else val_data
    ix = torch.randint(len(data_split) - block_size, (batch_size,))
    x = torch.stack([data_split[i:i+block_size] for i in ix])
    y = torch.stack([data_split[i+1:i+block_size+1] for i in ix])
    x, y = x.to(device), y.to(device)
    return x, y

xb, yb = get_batch('train')
print(xb.shape, yb.shape)</code></pre>

            <div class="output-block">
                Train tokens: 105116383, Val tokens: 11679599<br>
                torch.Size([64, 128]) torch.Size([64, 128])
            </div>

            <h2>GPT Model Architecture with GPT-3 Improvements</h2>

            <p>This cell will define the GPT model. I am making a few subtle changes from Karpathy's original GPT-2 code:</p>
            
            <p>Based on GPT-3, we used Rotary Position Embeddings over absolute learned positions.</p>
            
            <p>We performed normalization at the start of the block.</p>
            
            <p>Residual Scaling (1/√2): We scale residual connections to prevent divergence on deep nets.</p>

            <pre><code># GPT Config class (matches Karpathy's GPTConfig)
class GPTConfig:
    def __init__(self, vocab_size, block_size, n_layer=12, n_head=12, n_embd=768):
        self.vocab_size = vocab_size
        self.block_size = block_size
        self.n_layer = n_layer
        self.n_head = n_head
        self.n_embd = n_embd

# Rotary Embeddings (GPT-3 style)
def apply_rotary_emb(q, k):
    # Simple RoPE implementation
    seq_len = q.size(-2)
    dim = q.size(-1)
    theta = 10000 ** (-torch.arange(0, dim, 2, device=q.device).float() / dim)
    pos = torch.arange(seq_len, device=q.device).float().unsqueeze(1)
    angle = pos * theta.unsqueeze(0)

    sin, cos = angle.sin(), angle.cos()
    q1, q2 = q[..., ::2], q[..., 1::2]
    k1, k2 = k[..., ::2], k[..., 1::2]

    q = torch.cat([q1*cos - q2*sin, q1*sin + q2*cos], dim=-1)
    k = torch.cat([k1*cos - k2*sin, k1*sin + k2*cos], dim=-1)
    return q, k

# Multi-Head Attention with RoPE
class CausalSelfAttention(nn.Module):
    def __init__(self, config):
        super().__init__()
        assert config.n_embd % config.n_head == 0
        self.n_head = config.n_head
        self.head_dim = config.n_embd // config.n_head

        self.c_attn = nn.Linear(config.n_embd, 3 * config.n_embd)
        self.c_proj = nn.Linear(config.n_embd, config.n_embd)

        self.register_buffer("mask", torch.tril(torch.ones(config.block_size, config.block_size))
                             .view(1, 1, config.block_size, config.block_size))

    def forward(self, x):
        B, T, C = x.size()

        qkv = self.c_attn(x)
        q, k, v = qkv.split(C, dim=2)

        # reshape into heads
        q = q.view(B, T, self.n_head, self.head_dim).transpose(1, 2)
        k = k.view(B, T, self.n_head, self.head_dim).transpose(1, 2)
        v = v.view(B, T, self.n_head, self.head_dim).transpose(1, 2)

        # Apply rotary embeddings
        q, k = apply_rotary_emb(q, k)

        att = (q @ k.transpose(-2, -1)) * (1.0 / math.sqrt(self.head_dim))
        att = att.masked_fill(self.mask[:, :, :T, :T] == 0, float('-inf'))
        att = F.softmax(att, dim=-1)

        y = att @ v
        y = y.transpose(1, 2).contiguous().view(B, T, C)

        return self.c_proj(y)

# FeedForward (Karpathy style)
class MLP(nn.Module):
    def __init__(self, config):
        super().__init__()
        self.net = nn.Sequential(
            nn.Linear(config.n_embd, 4 * config.n_embd),
            nn.GELU(),
            nn.Linear(4 * config.n_embd, config.n_embd),
        )

    def forward(self, x):
        return self.net(x)

# Transformer Block (Pre-LayerNorm GPT-3 style)
class Block(nn.Module):
    def __init__(self, config):
        super().__init__()
        self.ln1 = nn.LayerNorm(config.n_embd)
        self.attn = CausalSelfAttention(config)
        self.ln2 = nn.LayerNorm(config.n_embd)
        self.mlp = MLP(config)

    def forward(self, x):
        # Pre-LN + residual scaling (GPT-3 stability trick)
        x = x + self.attn(self.ln1(x)) / math.sqrt(2)
        x = x + self.mlp(self.ln2(x)) / math.sqrt(2)
        return x

# Full GPT Model
class GPT(nn.Module):
    def __init__(self, config):
        super().__init__()
        self.config = config

        self.token_emb = nn.Embedding(config.vocab_size, config.n_embd)
        self.pos_emb = nn.Parameter(torch.zeros(1, config.block_size, config.n_embd))  # still keep learned pos emb
        self.drop = nn.Dropout(0.1)

        self.blocks = nn.Sequential(*[Block(config) for _ in range(config.n_layer)])
        self.ln_f = nn.LayerNorm(config.n_embd)

        self.head = nn.Linear(config.n_embd, config.vocab_size, bias=False)

        self.block_size = config.block_size
        self.apply(self._init_weights)

    def _init_weights(self, module):
        if isinstance(module, nn.Linear):
            nn.init.normal_(module.weight, mean=0.0, std=0.02)
            if module.bias is not None:
                nn.init.zeros_(module.bias)
        elif isinstance(module, nn.Embedding):
            nn.init.normal_(module.weight, mean=0.0, std=0.02)

    def forward(self, idx, targets=None):
        B, T = idx.shape
        assert T <= self.block_size, "Cannot forward, sequence too long."

        token_embeddings = self.token_emb(idx)
        position_embeddings = self.pos_emb[:, :T, :]
        x = self.drop(token_embeddings + position_embeddings)

        x = self.blocks(x)
        x = self.ln_f(x)
        logits = self.head(x)

        loss = None
        if targets is not None:
            loss = F.cross_entropy(logits.view(-1, logits.size(-1)), targets.view(-1))

        return logits, loss

    def generate(self, idx, max_new_tokens):
        for _ in range(max_new_tokens):
            idx_cond = idx[:, -self.block_size:]
            logits, _ = self(idx_cond)
            logits = logits[:, -1, :]
            probs = F.softmax(logits, dim=-1)
            idx_next = torch.multinomial(probs, num_samples=1)
            idx = torch.cat((idx, idx_next), dim=1)
        return idx</code></pre>

            <h2>Model Configuration and Parameter Count</h2>

            <p>We will aim for ~300M parameters for efficiency. Note: When I revisit this project, I intend to change the parameters to ~1B, which will also require me to switch our tokenization to sub-word BPE. I should also try to find more data to train on rather than Gutenberg alone. For now, considering our constraints, these results are fine.</p>

            <pre><code>config = GPTConfig(
    vocab_size=vocab_size,
    block_size=512,   # longer context
    n_layer=24,       # deeper network
    n_head=16,
    n_embd=1024       # wider embeddings
)

model = GPT(config).to(device)

n_params = sum(p.numel() for p in model.parameters())
print(f"Model parameters: {n_params/1e6:.2f}M")

# Optimizer
optimizer = torch.optim.AdamW(model.parameters(), lr=3e-4, betas=(0.9, 0.95), weight_decay=0.1)</code></pre>

            <div class="output-block">
                Model parameters: 303.67M
            </div>

            <h2>Training Loop with Mixed Precision</h2>

            <p>We implement a comprehensive training loop with mixed precision training, gradient clipping, learning rate scheduling, and periodic evaluation.</p>

            <pre><code># Hyperparameters
max_iters = 20000         # more steps for big model
eval_interval = 1000      # evaluate/print periodically
eval_iters = 200
log_interval = 100
lr = 3e-4
min_lr = 1e-5
warmup_iters = 1000
grad_clip = 1.0
checkpoint_path = "gpt_char_large.pt"

def get_lr(it):
    if it < warmup_iters:
        return lr * it / warmup_iters
    if it > max_iters:
        return min_lr
    decay_ratio = (it - warmup_iters) / (max_iters - warmup_iters)
    return min_lr + (lr - min_lr) * 0.5 * (1 + math.cos(math.pi * decay_ratio))

@torch.no_grad()
def estimate_loss():
    out = {}
    model.eval()
    for split in ['train', 'val']:
        losses = torch.zeros(eval_iters)
        for k in range(eval_iters):
            X, Y = get_batch(split)
            _, loss = model(X, Y)
            losses[k] = loss.item()
        out[split] = losses.mean()
    model.train()
    return out

# Training loop
for iter in range(max_iters):
    # update learning rate
    lr_current = get_lr(iter)
    for param_group in optimizer.param_groups:
        param_group['lr'] = lr_current

    # fetch batch
    xb, yb = get_batch('train')

    # forward/backward in mixed precision
    with torch.cuda.amp.autocast(enabled=(device == 'cuda')):
        logits, loss = model(xb, yb)

    optimizer.zero_grad(set_to_none=True)
    scaler.scale(loss).backward()

    # gradient clipping
    scaler.unscale_(optimizer)
    torch.nn.utils.clip_grad_norm_(model.parameters(), grad_clip)

    # step optimizer
    scaler.step(optimizer)
    scaler.update()

    # log training loss
    if iter % log_interval == 0:
        print(f"step {iter}: train loss {loss.item():.4f}")

    # evaluate and save checkpoint
    if iter % eval_interval == 0:
        losses = estimate_loss()
        print(f"step {iter}: val loss {losses['val']:.4f}")

        # save checkpoint
        torch.save(model.state_dict(), checkpoint_path)
        print(f"Checkpoint saved to {checkpoint_path}")

        # generate sample text
        context = torch.zeros((1, 1), dtype=torch.long, device=device)
        print(decode(model.generate(context, max_new_tokens=500)[0].tolist()))
        print("-" * 80)</code></pre>

            <div class="output-block">
                step 0: train loss 6.1108<br>
                step 0: val loss 6.0962<br>
                ...<br>
                step 1000: train loss 1.4537<br>
                step 1000: val loss 1.4452<br>
                <br>
                was the servant Flance ladied<br>
                The entire triors in the church smilw,<br>
                Undercry Dantmy, which Sellowly<br>
                ...
            </div>

            <h2>Text Generation and Results</h2>

            <p>We've finished training and our loss is sub-1.0, which means our char-level model is learning strong predictive patterns and is pretty decent for Project Gutenberg. After training, we'll need to load the checkpoint and generate text.</p>

            <pre><code># Load best model (if not already in memory)
checkpoint_path = "gpt_char_large.pt"
model.load_state_dict(torch.load(checkpoint_path))
model.eval()

# Start token (just zero = start of sequence)
context = torch.zeros((1, 1), dtype=torch.long, device=device)

# Generate text
generated = model.generate(context, max_new_tokens=1000)
print(decode(generated[0].tolist()))</code></pre>

            <div class="output-block">
                is before anything that can be done.<br>
                <br>
                Nor can the plane be resorted by late as in Nova Scotia, a general meeting<br>
                of the Literal Peruvian Pennant, surviving Pedigne Mount, forbiding brans spectur miniassiss, anteses,<br>
                bus, ixit Coris effant, ot dar is m. bis = Ape x) min mandegereebasin<br>
                <br>
                Mamin Olaur epis.<br>
                <br>
                Benut olivâ mes.. A l'a.: A V. T in A b N& I (Harethyzin')<br>
                ...
            </div>

            <h2>Advanced Generation with Controls</h2>

            <p>We implement more sophisticated text generation with temperature and top-k sampling controls for better output quality.</p>

            <pre><code>def generate_with_controls(prompt="", max_new_tokens=500, temperature=0.8, top_k=50):
    # Encode prompt
    idx = torch.tensor([stoi.get(c, 0) for c in prompt], dtype=torch.long, device=device)[None, ...]
    
    for _ in range(max_new_tokens):
        idx_cond = idx[:, -config.block_size:]
        logits, _ = model(idx_cond)
        logits = logits[:, -1, :] / temperature  # adjust temperature
        if top_k is not None:
            v, _ = torch.topk(logits, top_k)
            logits[logits < v[:, [-1]]] = -float('Inf')
        probs = F.softmax(logits, dim=-1)
        idx_next = torch.multinomial(probs, num_samples=1)
        idx = torch.cat((idx, idx_next), dim=1)
    return decode(idx[0].tolist())

# Example usage
print(generate_with_controls("Once upon a time"))</code></pre>

            <div class="output-block">
                Once upon a time one had been fostered by the boys, so I<br>
                had hoped to do it and talk. The store of Spanish people had arrived at<br>
                that time and back such an interestimulate, and the other simp of thoff.<br>
                Heat--e-o-tohe--po-pich of a boy d-bev-jac-e-hon---er---e-s---h.<br>
                ...
            </div>
            <div class="output-block">
                torch.save(model.state_dict(), "gpt_char_large_final.pt")           
            </div>


            <p>I expected it, but wow.... seriously terrible. Stay tuned for more!</p>

            <p>We seem to have output nonsense right? Well, yes. This is what I expected from our fresh trained char-level model, and absolutely falls short of the more modern BPE approach (subword tokenization). In order to have intelligible output, we'd probably need billions of parameters and data beyond Gutenberg. However, for today, that falls out of scope.</p>

            <p>Our next project will be trying to implement more modern approaches LIKE BPE and others that we've seen from the GPT3, GPT4 papers. Thanks for reading!</p>

            <h3>Key Improvements for Future Iterations:</h3>
            <ul>
                <li><strong>Subword Tokenization:</strong> Implement BPE (Byte Pair Encoding) for more efficient text representation</li>
                <li><strong>Scale Up:</strong> Target ~1B parameters for better performance (please reach out if you can help me with renting GPUs)</li>
                <li><strong>Better Data:</strong> Incorporate larger, more diverse datasets beyond Project Gutenberg (fineweb is really cool)</li>
                <li><strong>Advanced Techniques:</strong> Implement techniques from GPT-3 and GPT-4 papers</li>
                <li><strong>Fine-tuning:</strong> Add instruction tuning and RLHF for better controllability</li>
            </ul>

        </article>
    </div>
</body>
</html> 