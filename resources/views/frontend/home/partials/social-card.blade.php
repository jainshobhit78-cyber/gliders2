@php
    $p = strtolower(trim($post->platform));
    $handles = [
        'facebook'  => $settings->social_facebook ?? null,
        'linkedin'  => $settings->social_linkedin ?? null,
        'instagram' => $settings->social_instagram ?? null,
    ];
    $meta = [
        'facebook'  => ['name' => 'Facebook',  'cls' => 'fb', 'icon' => 'f'],
        'linkedin'  => ['name' => 'LinkedIn',  'cls' => 'li', 'icon' => 'in'],
        'instagram' => ['name' => 'Instagram', 'cls' => 'ig', 'icon' => '◎'],
    ][$p] ?? ['name' => ucfirst($p), 'cls' => 'fb', 'icon' => '★'];
    $handle = $post->link ?: ($handles[$p] ?? '#');
    $img = $post->image
        ? (\Illuminate\Support\Str::startsWith($post->image, ['http://', 'https://', '/']) ? $post->image : '/uploads/social/' . $post->image)
        : null;
@endphp
<div class="social-card">
    <div class="social-card-head">
        <span class="social-ic social-ic--{{ $meta['cls'] }}">{{ $meta['icon'] }}</span>
        <div class="social-card-meta">
            <a href="{{ $handle ?: '#' }}" target="_blank" rel="noopener" class="social-card-name social-card-name--{{ $meta['cls'] }}">{{ $meta['name'] }}</a>
            <span class="social-card-date">{{ $post->post_date ? \Carbon\Carbon::parse($post->post_date)->format('M d, Y') : '' }}</span>
        </div>
        <span class="social-card-dots">&#8942;</span>
    </div>
    <div class="social-card-body">
        <p class="social-card-text">{{ $post->content }}</p>
        @if($img)
            <span class="social-card-img" style="background-image:url('{{ $img }}');"></span>
        @endif
    </div>
    <div class="social-card-foot">
        <span class="social-card-reacts">
            <span class="react react--like">👍</span><span class="react react--love">❤</span>
            <span class="react-count">{{ $post->likes }}</span>
        </span>
        @if($p === 'instagram')
            <a href="{{ $handle ?: '#' }}" target="_blank" rel="noopener" class="social-card-link">View on Instagram</a>
        @else
            <span class="social-card-stats">{{ $post->comments }} Comments &nbsp;·&nbsp; {{ $post->shares }} Shares</span>
        @endif
    </div>
</div>
