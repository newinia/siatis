<a
    href="{{ $route }}"
    class="result-badge {{ $badgeClass }}"
>
    <span class="material-symbols-outlined result-icon">
        {{ $hasilIcon }}
    </span>

    <div class="result-content">
        <span class="result-title">
            {{ $labelTahapan }}
        </span>

        <span class="result-status {{ $hasilClass }}">
            <span class="status-dot {{ $hasilDotClass }}"></span>
            {{ $hasil }}
        </span>
    </div>

    <span class="result-arrow">
        ›
    </span>
</a>