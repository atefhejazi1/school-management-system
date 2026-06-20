@extends('layouts.super-admin.master')

@section('title', trans('super_dash.platform_creators_title'))

@section('PageTitle', trans('super_dash.platform_creators_title'))

@section('content')

    <div class="ph-wrap">
        <div class="ph-title-group">
            <div>
                <h1 class="ph-title">{{ trans('super_dash.platform_creators_heading') }}</h1>
                <p class="ph-subtitle">{{ trans('super_dash.platform_creators_subtitle') }}</p>
            </div>
        </div>
    </div>

    <div class="admin-card flat-card mb-4">
        <div class="admin-card-header" style="border-bottom:none;">
            <span class="admin-card-title">{{ trans('super_dash.create_platform_creator_account') }}</span>
        </div>
        <div class="p-4 pt-0">
            <form method="POST" action="{{ route('super-admin.admins.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{ trans('super_dash.full_name_label') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ trans('super_dash.email_address_label') }}</label>
                        <input type="email" name="email" value="{{ old('email') }}" dir="ltr"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ trans('super_dash.password_label') }}</label>
                        <input type="password" name="password" dir="ltr"
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ trans('super_dash.password_confirmation_label') }}</label>
                        <input type="password" name="password_confirmation" dir="ltr" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn-flat-emerald mt-3">{{ trans('super_dash.create_account_btn') }}</button>
            </form>
        </div>
    </div>

    <div class="admin-card flat-card">
        <div class="admin-card-header" style="border-bottom:none;">
            <span class="admin-card-title">{{ trans('super_dash.current_accounts_count') }} ({{ $superAdmins->count() }})</span>
        </div>
        <div class="table-responsive">
            <table class="table admin-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('super_dash.name_th') }}</th>
                        <th>{{ trans('super_dash.email_address_label') }}</th>
                        <th>{{ trans('super_dash.created_at_th') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($superAdmins as $admin)
                        <tr>
                            <td class="text-muted" style="font-size:.8rem;">{{ $admin->id }}</td>
                            <td><span class="fw-semibold" style="color:#334155;">{{ $admin->name }}</span></td>
                            <td><span dir="ltr" style="font-size:.85rem;">{{ $admin->email }}</span></td>
                            <td><span style="font-size:.8rem; color:#94a3b8;">{{ $admin->created_at?->format('Y/m/d') ?? '—' }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .flat-card { box-shadow: none !important; }

        .btn-flat-emerald {
            background: #059669;
            color: #ffffff;
            border: none;
            font-family: 'Cairo', sans-serif;
            font-weight: 700;
            border-radius: 8px;
            padding: 10px 22px;
            font-size: .88rem;
        }
        .btn-flat-emerald:hover { background: #047857; color: #ffffff; }
    </style>

@endsection
