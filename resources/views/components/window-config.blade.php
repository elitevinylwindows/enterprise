@props(['code' => 'XO', 'width' => 60, 'height' => 48])

@php
    $codeParts = explode('-', $code);
    $segments = array_filter($codeParts, fn($p) => !in_array($p, ['T1', 'B1']));
    $hasTop = in_array('T1', $codeParts);
    $hasBottom = in_array('B1', $codeParts);
    $paneCount = count($segments);

    $svgWidth = 300;
    $svgHeight = 250;
    $paneWidth = $svgWidth / $paneCount;
    $paneY = $hasTop ? 50 : 0;
    $paneHeight = $svgHeight - ($hasTop ? 50 : 0) - ($hasBottom ? 50 : 0);
@endphp

<svg width="{{ $svgWidth }}" height="{{ $svgHeight }}" xmlns="http://www.w3.org/2000/svg" style="border:1px solid #ccc; background:#fff;">

    {{-- Top segment --}}
    @if($hasTop)
        <rect x="0" y="0" width="{{ $svgWidth }}" height="50" fill="#cce6f6" />
        <line x1="0" y1="50" x2="{{ $svgWidth }}" y2="50" stroke="#000" stroke-width="1" />
    @endif

    {{-- Main panes --}}
    @foreach($segments as $i => $pane)
        @php
            $x = $i * $paneWidth;
            $isX = $pane === 'X';
            $fill = $isX ? '#cce6f6' : '#e0e0e0';
        @endphp

        <rect x="{{ $x }}" y="{{ $paneY }}" width="{{ $paneWidth }}" height="{{ $paneHeight }}" fill="{{ $fill }}" stroke="#000" stroke-width="1"/>

        {{-- Decorative grid for X --}}
        @if($isX)
            @for($g = 1; $g < 4; $g++)
                <line x1="{{ $x + $g * ($paneWidth / 4) }}" y1="{{ $paneY }}" x2="{{ $x + $g * ($paneWidth / 4) }}" y2="{{ $paneY + $paneHeight }}" stroke="#99cbee" stroke-width="0.5" />
            @endfor
            @for($g = 1; $g < 4; $g++)
                <line x1="{{ $x }}" y1="{{ $paneY + $g * ($paneHeight / 4) }}" x2="{{ $x + $paneWidth }}" y2="{{ $paneY + $g * ($paneHeight / 4) }}" stroke="#99cbee" stroke-width="0.5" />
            @endfor

            {{-- Arrow direction --}}
           @php
    $yMid = $paneY + $paneHeight / 2;
    $yUp = $yMid - 10;
    $yDown = $yMid + 10;
    $xArrow = $arrowDir === 'right' ? $arrowX + 20 : $arrowX - 20;

    $arrowPoints = "$arrowX,$yMid $arrowX,$yUp $xArrow,$yMid $arrowX,$yDown";
@endphp

            <polygon points="{{ $arrowPoints }}" fill="#444" />
        @endif
    @endforeach

    {{-- Bottom segment --}}
    @if($hasBottom)
        <line x1="0" y1="{{ $svgHeight - 50 }}" x2="{{ $svgWidth }}" y2="{{ $svgHeight - 50 }}" stroke="#000" stroke-width="1" />
        <rect x="0" y="{{ $svgHeight - 50 }}" width="{{ $svgWidth }}" height="50" fill="#cce6f6" />
    @endif

    {{-- Label --}}
    <text x="10" y="{{ $svgHeight - 10 }}" font-size="12" fill="#555">
        {{ $code }} — {{ $width }}" x {{ $height }}"
    </text>
</svg>


























