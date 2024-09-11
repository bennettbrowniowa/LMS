

<div style="margin-left: {{ $level * 20 }}px;">
    <div>
        @if ($sequence->children->isNotEmpty())
            <span class="collapse-toggle" onclick="toggleVisibility(event)" style="cursor: pointer;">▼ {{ $sequence->title }}</span>
            <div class="collapse-content" style="display: none;">
                @foreach ($sequence->children as $child)
                    @include('Backend.LearningSequence.partials.children', ['sequence' => $child, 'level' => $level + 1])
                @endforeach
            </div>
        @else
            <span>{{ $sequence->title }}</span>
        @endif
    </div>
    <div>{{ $sequence->description }}</div>
</div>

<script>
    function toggleVisibility(event) {
        const content = event.target.nextElementSibling;
        if (content.style.display === 'none') {
            content.style.display = 'block';
        } else {
            content.style.display = 'none';
        }
    }
</script>






