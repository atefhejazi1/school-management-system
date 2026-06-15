{{--
  Skeleton Table Loader — Bootstrap 5 + Livewire 3

  Props (passed via @include or component slot):
    $rows    (int)  — number of skeleton rows,  default 6
    $cols    (int)  — number of skeleton columns, default 5
    $hasActions (bool) — include an actions column, default true

  Usage with Livewire wire:loading:
    <div wire:loading.block>
        @include('layouts.partials.skeleton-table', ['rows' => 8, 'cols' => 4])
    </div>
    <div wire:loading.remove>
        {{-- actual table --}}
    </div>

  Or used directly as a standalone block with its own wire:loading wrapper.
--}}
@php
    $skRows       = $rows       ?? 6;
    $skCols       = $cols       ?? 5;
    $skHasActions = $hasActions ?? true;
@endphp

<div class="sk-table-wrap" wire:loading.block>
    {{-- Header row --}}
    <div class="sk-header placeholder-glow">
        @for($c = 0; $c < $skCols; $c++)
            <div class="sk-th">
                <span class="placeholder sk-th-inner"
                      style="width:{{ rand(50, 85) }}%"></span>
            </div>
        @endfor
        @if($skHasActions)
            <div class="sk-th sk-th-actions">
                <span class="placeholder sk-th-inner" style="width:60%"></span>
            </div>
        @endif
    </div>

    {{-- Data rows --}}
    @for($r = 0; $r < $skRows; $r++)
        <div class="sk-row placeholder-glow">
            @for($c = 0; $c < $skCols; $c++)
                <div class="sk-td">
                    @if($c === 0)
                        {{-- First col: avatar + text --}}
                        <div class="sk-cell-lead">
                            <span class="placeholder sk-avatar"></span>
                            <div class="sk-cell-lines">
                                <span class="placeholder sk-line-a"
                                      style="width:{{ rand(55,90) }}%"></span>
                                <span class="placeholder sk-line-b"
                                      style="width:{{ rand(30,55) }}%"></span>
                            </div>
                        </div>
                    @elseif($c === $skCols - 1)
                        {{-- Last data col: badge-like --}}
                        <span class="placeholder sk-badge"
                              style="width:{{ rand(40,70) }}px"></span>
                    @else
                        <span class="placeholder sk-text"
                              style="width:{{ rand(45,80) }}%"></span>
                    @endif
                </div>
            @endfor
            @if($skHasActions)
                <div class="sk-td sk-td-actions">
                    <span class="placeholder sk-btn-sm"></span>
                    <span class="placeholder sk-btn-sm"></span>
                </div>
            @endif
        </div>
    @endfor
</div>

<style>
/* ── Skeleton table wrapper ── */
.sk-table-wrap {
    background: white;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

/* ── Header ── */
.sk-header {
    display: flex; align-items: center;
    padding: 14px 20px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    gap: 16px;
}
.sk-th { flex: 1; }
.sk-th-actions { flex: 0 0 100px; }
.sk-th-inner {
    display: block; height: 10px;
    border-radius: 5px;
    background: #e2e8f0;
}

/* ── Rows ── */
.sk-row {
    display: flex; align-items: center;
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    gap: 16px;
    animation: sk-pulse 1.6s ease-in-out infinite;
}
.sk-row:last-child { border-bottom: none; }
.sk-row:nth-child(even) { background: #fafafa; }

/* Stagger pulse per row */
.sk-row:nth-child(2)  { animation-delay: .08s; }
.sk-row:nth-child(3)  { animation-delay: .16s; }
.sk-row:nth-child(4)  { animation-delay: .24s; }
.sk-row:nth-child(5)  { animation-delay: .32s; }
.sk-row:nth-child(6)  { animation-delay: .40s; }

@keyframes sk-pulse {
    0%, 100% { opacity: 1; }
    50%       { opacity: .55; }
}

.sk-td { flex: 1; }
.sk-td-actions { flex: 0 0 100px; display: flex; gap: 8px; }

/* Cell shapes */
.sk-cell-lead { display: flex; align-items: center; gap: 10px; }
.sk-avatar {
    width: 34px; height: 34px; border-radius: 9px;
    background: #e2e8f0; flex-shrink: 0; display: block;
}
.sk-cell-lines { flex: 1; display: flex; flex-direction: column; gap: 5px; }
.sk-line-a { display: block; height: 10px; border-radius: 5px; background: #e2e8f0; }
.sk-line-b { display: block; height: 8px;  border-radius: 4px; background: #f0f4f8; }

.sk-text  { display: block; height: 10px; border-radius: 5px; background: #e2e8f0; }
.sk-badge { display: block; height: 22px; border-radius: 11px; background: #e8f5f0; }
.sk-btn-sm { display: block; width: 30px; height: 30px; border-radius: 8px; background: #f1f5f9; }
</style>
