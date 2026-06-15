{{--
  ╔══════════════════════════════════════════════════════════════════════════════╗
  ║  INDEX / LIST PAGE TEMPLATE                                                  ║
  ║  — Modernized data table, skeleton loader, empty state, pagination          ║
  ║  — Bootstrap 5 + Livewire 3 + Emerald Green theme                          ║
  ╠══════════════════════════════════════════════════════════════════════════════╣
  ║  LIVEWIRE COMPONENT MUST EXPOSE:                                             ║
  ║    public string $search   = '';                                             ║
  ║    public int    $perPage  = 10;                                             ║
  ║    public bool   $showFilters = false;                                       ║
  ║    public string $filterStatus = '';                                         ║
  ║    public string $filterGender = '';                                         ║
  ║    — computed/render property returning paginated $records                   ║
  ║    — method resetFilters()                                                   ║
  ║    — method doDelete(int $id)  (triggered by confirm-action modal)           ║
  ║                                                                              ║
  ║  RENAME: Replace every occurrence of 'students' / 'student' with your       ║
  ║  module name. Update column headers, cell content, and route names.          ║
  ╚══════════════════════════════════════════════════════════════════════════════╝
--}}

@extends('layouts.master')

{{-- ════ Breadcrumb title ════ --}}
@section('PageTitle')
    {{ trans('main_trans.list_students') }}
@endsection

{{-- ════ Page-specific CSS (if needed beyond master.blade.php) ════ --}}
@section('css')
@endsection

{{-- ════════════════════════════════════════════════════════
     CONTENT
════════════════════════════════════════════════════════ --}}
@section('content')

    {{-- ── Page Header ── --}}
    @include('layouts.partials.page-header', [
        'ph_icon'         => 'fas fa-user-graduate',
        'ph_title'        => trans('main_trans.list_students'),
        'ph_subtitle'     => trans('main_trans.students_subtitle'),
        'ph_action_label' => trans('main_trans.add_new'),
        'ph_action_event' => 'openCreateModal',
        {{-- Alternative: 'ph_action_url' => route('admin.students.create') --}}
        'ph_extra_buttons' => [
            [
                'label' => trans('main_trans.export'),
                'icon'  => 'fas fa-file-excel',
                'event' => 'exportExcel',
                'class' => 'btn-emerald-outline',
            ],
        ],
    ])

    {{-- ── Main Card ── --}}
    <div class="admin-card">

        {{-- ┌─────────────────────────────────────────────────────────┐
             │  CARD HEADER: Title + Search + Per-Page + Filter toggle │
             └─────────────────────────────────────────────────────────┘ --}}
        <div class="admin-card-header">

            <div class="admin-card-title">
                <i class="fas fa-list"></i>
                {{ trans('main_trans.list_students') }}
                <span class="pill pill-info ms-2">
                    {{ $totalCount ?? 0 }} {{ trans('main_trans.records_count') }}
                </span>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">

                {{-- Search --}}
                <div class="ip-search-wrap">
                    <i class="fas fa-magnifying-glass ip-search-icon"></i>
                    <input type="text"
                           class="form-control ip-search"
                           wire:model.live.debounce.400ms="search"
                           placeholder="{{ trans('main_trans.search_placeholder') }}"
                           autocomplete="off">
                </div>

                {{-- Per-page --}}
                <select class="form-select ip-per-page"
                        wire:model.live="perPage"
                        title="{{ trans('main_trans.per_page_label') }}">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>

                {{-- Filter toggle --}}
                <button type="button"
                        class="btn btn-outline-secondary ip-filter-btn"
                        wire:click="$toggle('showFilters')"
                        title="{{ trans('main_trans.filter') }}">
                    <i class="fas fa-sliders-h me-1"></i>
                    {{ trans('main_trans.filter') }}
                    @if($filterStatus || $filterGender)
                        <span class="badge bg-danger ms-1" style="font-size:.65rem;padding:2px 5px;border-radius:50px;">
                            {{ collect([$filterStatus, $filterGender])->filter()->count() }}
                        </span>
                    @endif
                </button>

            </div>
        </div>{{-- /.admin-card-header --}}

        {{-- ┌─────────────────────────────────────────────┐
             │  EXPANDED FILTER ROW (toggled by Livewire)  │
             └─────────────────────────────────────────────┘ --}}
        @if($showFilters)
            <div class="ip-filters-row">
                <div class="row g-3 p-3 align-items-end">

                    {{-- Status filter --}}
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label mb-1">{{ trans('main_trans.status') }}</label>
                        <select class="form-select" wire:model.live="filterStatus">
                            <option value="">{{ trans('main_trans.select_option') }}</option>
                            <option value="1">{{ trans('main_trans.active') }}</option>
                            <option value="0">{{ trans('main_trans.inactive') }}</option>
                        </select>
                    </div>

                    {{-- Gender filter --}}
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label mb-1">{{ trans('main_trans.gender_label') }}</label>
                        <select class="form-select" wire:model.live="filterGender">
                            <option value="">{{ trans('main_trans.select_option') }}</option>
                            <option value="male">{{ trans('main_trans.male') }}</option>
                            <option value="female">{{ trans('main_trans.female') }}</option>
                        </select>
                    </div>

                    {{-- Reset --}}
                    <div class="col-sm-6 col-md-2 d-flex align-items-end">
                        <button type="button"
                                class="btn btn-emerald-outline w-100"
                                wire:click="resetFilters">
                            <i class="fas fa-rotate-left me-1"></i>
                            {{ trans('main_trans.reset') }}
                        </button>
                    </div>

                </div>
            </div>
        @endif

        {{-- ┌─────────────────────────────────────────────────────────┐
             │  SKELETON LOADER — auto-shown via wire:loading.block    │
             │  inside the partial itself. No wrapper needed here.     │
             └─────────────────────────────────────────────────────────┘ --}}
        @include('layouts.partials.skeleton-table', [
            'rows'       => (int)($perPage ?? 10),
            'cols'       => 5,
            'hasActions' => true,
        ])

        {{-- ┌──────────────────────────────────────────────────────────┐
             │  REAL CONTENT — hidden via wire:loading.remove           │
             │  Shows: empty-state OR table + pagination                │
             └──────────────────────────────────────────────────────────┘ --}}
        <div wire:loading.remove>

            @if($records->isEmpty())

                {{-- ═══ EMPTY STATE ═══ --}}
                @include('layouts.partials.empty-state', [
                    'type'        => $search || $filterStatus || $filterGender
                                        ? 'no_results'
                                        : 'no_data',
                    'action'      => $search || $filterStatus || $filterGender
                                        ? null
                                        : trans('main_trans.add_new'),
                    'actionEvent' => 'openCreateModal',
                ])

            @else

                {{-- ═══ DATA TABLE ═══ --}}
                <div class="table-responsive">
                    <table class="table admin-table">

                        <thead>
                            <tr>
                                {{-- Row number --}}
                                <th class="text-center" style="width:50px;">
                                    {{ trans('main_trans.row_num') }}
                                </th>

                                {{-- NAME — sortable example --}}
                                <th>
                                    <button type="button"
                                            class="btn p-0 border-0 bg-transparent text-muted fw-bold d-flex align-items-center gap-1"
                                            wire:click="sortBy('name')">
                                        {{ trans('main_trans.name_label') }}
                                        @if($sortField === 'name')
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"
                                               style="font-size:.7rem;"></i>
                                        @else
                                            <i class="fas fa-sort" style="font-size:.7rem;opacity:.4;"></i>
                                        @endif
                                    </button>
                                </th>

                                <th>{{ trans('main_trans.email_label') }}</th>
                                <th>{{ trans('main_trans.phone_label') }}</th>
                                <th class="text-center">{{ trans('main_trans.status') }}</th>
                                <th class="text-center" style="width:130px;">
                                    {{ trans('main_trans.actions') }}
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($records as $record)
                            <tr wire:key="student-{{ $record->id }}">

                                {{-- Row number --}}
                                <td class="text-center text-muted fw-semibold" style="font-size:.78rem;">
                                    {{ $records->firstItem() + $loop->index }}
                                </td>

                                {{-- Name + avatar + sub-info --}}
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="tbl-avatar">
                                            @if($record->image)
                                                <img src="{{ asset('storage/' . $record->image) }}"
                                                     alt="{{ $record->name }}">
                                            @else
                                                <span class="tbl-avatar-initials">
                                                    {{ mb_strtoupper(mb_substr($record->name, 0, 1)) }}
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark lh-1"
                                                 style="font-size:.88rem;">
                                                {{ $record->name }}
                                            </div>
                                            <div class="text-muted mt-1" style="font-size:.74rem;">
                                                {{ trans('main_trans.national_id') }}:
                                                {{ $record->national_id ?? '—' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td class="text-muted" style="font-size:.85rem;">
                                    {{ $record->email ?? '—' }}
                                </td>

                                {{-- Phone --}}
                                <td class="text-muted" style="font-size:.85rem;">
                                    {{ $record->phone ?? '—' }}
                                </td>

                                {{-- Status badge --}}
                                <td class="text-center">
                                    @if($record->is_active)
                                        <span class="pill pill-success">
                                            <i class="fas fa-circle" style="font-size:6px;"></i>
                                            {{ trans('main_trans.active') }}
                                        </span>
                                    @else
                                        <span class="pill pill-danger">
                                            <i class="fas fa-circle" style="font-size:6px;"></i>
                                            {{ trans('main_trans.inactive') }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Action icon-buttons --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-1">

                                        {{-- View --}}
                                        <a href="{{ route('admin.students.show', $record->id) }}"
                                           class="btn-icon btn-icon-info"
                                           title="{{ trans('main_trans.view_details') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Edit (Livewire modal) --}}
                                        <button type="button"
                                                class="btn-icon btn-icon-warning"
                                                title="{{ trans('main_trans.edit') }}"
                                                wire:click="$dispatch('openEditModal', { id: {{ $record->id }} })">
                                            <i class="fas fa-pen-to-square"></i>
                                        </button>

                                        {{-- Delete (routes through confirm-action modal) --}}
                                        <button type="button"
                                                class="btn-icon btn-icon-danger"
                                                title="{{ trans('main_trans.delete_btn') }}"
                                                wire:click="$dispatch('confirm-action', [{
                                                    title:        '{{ addslashes(trans('main_trans.delete_btn')) }}',
                                                    message:      '{{ addslashes(trans('main_trans.confirm_delete')) }}',
                                                    sub:          '{{ addslashes(trans('main_trans.confirm_delete_desc')) }}',
                                                    event:        'doDelete',
                                                    params:       { id: {{ $record->id }} },
                                                    type:         'delete',
                                                    componentId:  '{{ $this->getId() }}'
                                                }])">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>{{-- /.table-responsive --}}

                {{-- ═══ PAGINATION BAR ═══ --}}
                @if($records->hasPages())
                    <div class="ip-pagination-wrap">
                        <span class="ip-pagination-info">
                            {{ trans('main_trans.showing_results') }}
                            <strong>{{ $records->firstItem() }}</strong>
                            —
                            <strong>{{ $records->lastItem() }}</strong>
                            {{ trans('main_trans.of_results') }}
                            <strong>{{ $records->total() }}</strong>
                            {{ trans('main_trans.records_count') }}
                        </span>
                        {{ $records->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @endif

            @endif

        </div>{{-- /wire:loading.remove --}}

    </div>{{-- /.admin-card --}}

@endsection

{{-- ════ Page-specific JS ════ --}}
@section('js')
@endsection
