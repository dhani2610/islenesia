@extends('layouts.app')

@section('title', ($post->meta_title ?: $post->title) . ' | ' . ($siteSettings['site_name'] ?? 'Manunggaland'))
@section('meta_description', $post->meta_description ?: Str::limit(strip_tags($post->content), 160))
@section('meta_keywords', $post->meta_keywords ?: 'ekspor komoditas, manunggaland, pasar eropa china')
@section('og_image', $post->image_url)

@section('content')

<!-- Breadcrumb -->
<div style="background-color: #F1F5F9; padding: 1rem 0; border-bottom: 1px solid var(--slate-border); font-size: 0.85rem;">
    <div class="container">
        <a href="{{ route('home') }}" style="color: var(--slate-muted);">Beranda</a>
        <span style="margin: 0 0.5rem; color: #CBD5E1;">/</span>
        <a href="{{ route('blog.index') }}" style="color: var(--slate-muted);">Blog & Wawasan</a>
        <span style="margin: 0 0.5rem; color: #CBD5E1;">/</span>
        <span style="color: var(--navy-primary); font-weight: 600;">{{ Str::limit($post->title, 40) }}</span>
    </div>
</div>

<article class="section" style="background-color: #F8FAFC;">
    <div class="container" style="max-width: 960px;">
        <!-- Header Post -->
        <div style="margin-bottom: 2.5rem; text-align: center;">
            <span class="section-subtitle">{{ $post->category }}</span>
            <h1 style="font-size: 2.5rem; color: var(--navy-primary); margin-bottom: 1.25rem; line-height: 1.25;">
                {{ $post->title }}
            </h1>
            
            <div style="display: flex; align-items: center; justify-content: center; gap: 1.5rem; font-size: 0.85rem; color: var(--slate-muted); flex-wrap: wrap;">
                <span><i class="fa-regular fa-calendar"></i> {{ $post->published_at ? $post->published_at->format('d F Y') : date('d F Y') }}</span>
                <span><i class="fa-regular fa-user"></i> Tim Riset {{ $siteSettings['site_name'] ?? 'Manunggaland' }}</span>
                <span><i class="fa-regular fa-eye"></i> {{ $post->views_count }} Pembaca</span>
                <span><i class="fa-regular fa-comments"></i> {{ $comments->count() }} Komentar</span>
            </div>
        </div>

        <!-- Featured Image -->
        <div style="border-radius: 20px; overflow: hidden; margin-bottom: 3rem; box-shadow: var(--shadow-lg); aspect-ratio: 16/9; background-color: var(--navy-deep);">
            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        <!-- Main Body Content -->
        <div style="background: #FFFFFF; padding: 3rem; border-radius: 20px; border: 1px solid var(--slate-border); box-shadow: var(--shadow-sm); margin-bottom: 3rem;">
            <div class="rich-content" style="line-height: 1.85; color: var(--slate-body); font-size: 1.05rem;">
                {!! $post->content !!}
            </div>

            <!-- Interactivity: Like & Share Bar -->
            <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--slate-border); display: flex; justify-content: space-between; align-items: center; flex-wrap: gap; gap: 1.5rem;">
                <!-- Like Button -->
                <button type="button" class="btn btn-outline-navy btn-sm" id="likeBtn" onclick="likePost({{ $post->id }})" style="display: flex; align-items: center; gap: 0.5rem; font-weight: 700; transition: all 0.3s ease; {{ ($isLiked ?? false) ? 'border-color: #EF4444; background: #FEF2F2; color: #DC2626;' : '' }}">
                    <i class="fa-solid fa-heart" id="likeHeartIcon" style="color: #EF4444; transition: transform 0.2s ease;"></i>
                    <span><span id="likeBtnLabel">{{ ($isLiked ?? false) ? 'Disukai' : 'Sukai Artikel' }}</span> (<span id="likesCountText">{{ $post->likes_count }}</span>)</span>
                </button>

                <!-- Social Share Buttons -->
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 0.825rem; font-weight: 600; color: var(--slate-muted); margin-right: 0.5rem;">Bagikan:</span>
                    
                    @php
                        $currentUrl = urlencode(url()->current());
                        $encodedTitle = urlencode($post->title);
                    @endphp
                    
                    <!-- WhatsApp -->
                    <a href="https://api.whatsapp.com/send?text={{ $encodedTitle }}%20{{ $currentUrl }}" target="_blank" rel="noopener" class="social-icon-btn" title="Bagikan ke WhatsApp" style="background: #25D366; color: #FFFFFF; border-color: #25D366;">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    
                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $currentUrl }}" target="_blank" rel="noopener" class="social-icon-btn" title="Bagikan ke LinkedIn" style="background: #0A66C2; color: #FFFFFF; border-color: #0A66C2;">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $currentUrl }}" target="_blank" rel="noopener" class="social-icon-btn" title="Bagikan ke Facebook" style="background: #1877F2; color: #FFFFFF; border-color: #1877F2;">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>

                    <!-- Copy Link -->
                    <button type="button" class="social-icon-btn" onclick="copyArticleLink()" title="Salin Tautan" style="background: #F1F5F9; color: var(--navy-primary); border: 1px solid var(--slate-border); cursor: pointer;">
                        <i class="fa-solid fa-link"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div style="background: #FFFFFF; padding: 2.5rem; border-radius: 20px; border: 1px solid var(--slate-border); box-shadow: var(--shadow-sm); margin-bottom: 4rem;">
            <h3 style="font-size: 1.35rem; color: var(--navy-primary); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-regular fa-comments text-gold"></i>
                <span>Diskusi & Komentar ({{ $comments->count() }})</span>
            </h3>

            @if(session('comment_success'))
                <div style="background: #ECFDF5; border: 1px solid #10B981; color: #065F46; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.875rem;">
                    {{ session('comment_success') }}
                </div>
            @endif

            <!-- Comments List -->
            @if($comments->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 2.5rem;">
                    @foreach($comments as $comment)
                        <div style="padding: 1.25rem; background: #F8FAFC; border-radius: 12px; border: 1px solid var(--slate-border);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <strong style="color: var(--navy-primary); font-size: 0.95rem;">{{ $comment->author_name }}</strong>
                                <span style="font-size: 0.775rem; color: var(--slate-muted);">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p style="font-size: 0.875rem; color: var(--slate-body); line-height: 1.6;">{{ $comment->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="color: var(--slate-muted); font-size: 0.875rem; margin-bottom: 2rem;">Belum ada komentar pada artikel ini. Jadilah yang pertama memberikan tanggapan!</p>
            @endif

            <!-- Comment Submission Form -->
            <div style="border-top: 1px solid var(--slate-border); padding-top: 2rem;">
                <h4 style="font-size: 1.1rem; color: var(--navy-primary); margin-bottom: 1rem;">Tuliskan Komentar Anda</h4>
                <form action="{{ route('blog.comment', $post->id) }}" method="POST">
                    @csrf
                    
                    <!-- Anti-bot honeypot trap field -->
                    <input type="text" name="website_trap" style="display:none;" tabindex="-1" autocomplete="off">

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--navy-primary); margin-bottom: 0.35rem;">Nama Lengkap *</label>
                            <input type="text" name="author_name" value="{{ old('author_name') }}" required class="wa-form-input" placeholder="Nama Anda">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--navy-primary); margin-bottom: 0.35rem;">Email (Tidak dipublikasikan) *</label>
                            <input type="email" name="author_email" value="{{ old('author_email') }}" required class="wa-form-input" placeholder="email@domain.com">
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--navy-primary); margin-bottom: 0.35rem;">Isi Komentar *</label>
                        <textarea name="comment" rows="3" required class="wa-form-textarea" placeholder="Tuliskan pandangan atau pertanyaan Anda seputar komoditas ini...">{{ old('comment') }}</textarea>
                    </div>

                    <!-- Anti-Bot Captcha Verification Box -->
                    <div style="background: #F8FAFC; border: 1px solid var(--slate-border); border-radius: 12px; padding: 1.15rem; margin-bottom: 1.25rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.8125rem; font-weight: 700; color: var(--navy-primary); margin-bottom: 0;">
                                <i class="fa-solid fa-shield-halved text-gold"></i>
                                <span>Verifikasi Keamanan (Anti-Bot) *</span>
                            </label>
                            <button type="button" onclick="refreshCommentCaptcha()" style="background: none; border: none; color: var(--slate-muted); font-size: 0.775rem; cursor: pointer; display: flex; align-items: center; gap: 0.35rem;" title="Ganti Pertanyaan">
                                <i class="fa-solid fa-arrows-rotate" id="commentCaptchaSpin"></i> Ganti
                            </button>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="background: #E2E8F0; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 800; font-family: monospace; font-size: 1.15rem; letter-spacing: 2px; color: var(--navy-primary); user-select: none;">
                                <span id="commentCaptchaQuestion">{{ $captchaQuestion ?? '7 + 5' }}</span> = ?
                            </div>
                            <input type="number" name="captcha_answer" required class="wa-form-input" style="max-width: 140px;" placeholder="Jawaban" autocomplete="off">
                        </div>
                        @error('captcha_answer')
                            <div style="color: #EF4444; font-size: 0.8rem; margin-top: 0.4rem; font-weight: 600;">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-navy btn-sm">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim Komentar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
            <div>
                <div class="section-header" style="text-align: left; margin-bottom: 2rem;">
                    <span class="section-subtitle">ARTIKEL LAINNYA</span>
                    <h2 class="section-title">Wawasan Terkait</h2>
                </div>
                <div class="blog-grid">
                    @foreach($relatedPosts as $rel)
                        <div class="blog-card">
                            <div class="blog-image-wrap">
                                <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" loading="lazy">
                            </div>
                            <div class="blog-body">
                                <h3 class="blog-title">
                                    <a href="{{ route('blog.show', $rel->slug) }}">{{ $rel->title }}</a>
                                </h3>
                                <p class="blog-excerpt">{{ Str::limit($rel->excerpt, 90) }}</p>
                                <a href="{{ route('blog.show', $rel->slug) }}" style="color: var(--navy-primary); font-weight: 700; font-size: 0.85rem; margin-top: auto;">
                                    Baca &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</article>

@push('scripts')
<script>
    function likePost(postId) {
        var btn = document.getElementById('likeBtn');
        var likesText = document.getElementById('likesCountText');
        var label = document.getElementById('likeBtnLabel');
        var heart = document.getElementById('likeHeartIcon');
        
        if (heart) {
            heart.style.transform = 'scale(1.3)';
            setTimeout(function() { heart.style.transform = 'scale(1)'; }, 200);
        }

        fetch("{{ url('blog') }}/" + postId + "/like", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.success) {
                if (likesText) likesText.textContent = data.likes_count;
                if (data.liked) {
                    btn.style.borderColor = '#EF4444';
                    btn.style.background = '#FEF2F2';
                    btn.style.color = '#DC2626';
                    if (label) label.textContent = 'Disukai';
                } else {
                    btn.style.borderColor = '';
                    btn.style.background = '';
                    btn.style.color = '';
                    if (label) label.textContent = 'Sukai Artikel';
                }
            }
        })
        .catch(function(err) { console.error(err); });
    }

    function refreshCommentCaptcha() {
        var spin = document.getElementById('commentCaptchaSpin');
        if (spin) spin.classList.add('fa-spin');
        fetch("{{ route('captcha.refresh') }}?scope=comment")
            .then(function(res) { return res.json(); })
            .then(function(data) {
                var qEl = document.getElementById('commentCaptchaQuestion');
                if (qEl && data.question) qEl.textContent = data.question;
            })
            .catch(function(err) { console.error(err); })
            .finally(function() {
                if (spin) spin.classList.remove('fa-spin');
            });
    }

    function copyArticleLink() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Tautan artikel berhasil disalin ke clipboard!');
        });
    }
</script>
@endpush


@endsection
