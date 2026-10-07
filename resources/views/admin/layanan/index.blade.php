@extends('admin.layouts.app')
@section('title', __('admin.services'))
@section('page-title', __('admin.services'))

@section('content')
<div class="table-card">
    <div class="table-header">
        <h3><i class="fas fa-stethoscope" style="color:var(--green-600)"></i> {{ __('admin.services') }}</h3>
        <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('admin.add_service') }}</a>
    </div>
    <div style="overflow-x:auto">
        <table>
            <thead>
                <tr>
                    <th>{{ __('admin.service_name') }}</th>
                    <th>Ikon</th>
                    <th>{{ __('admin.order') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $svc)
                    <tr>
                        <td>
                            <div style="font-weight:600">{{ $svc->name }}</div>
                            <div style="font-size:.75rem;color:var(--slate-400)">{{ Str::limit($svc->description, 60) }}</div>
                        </td>
                        <td><i class="{{ $svc->icon ?? 'fas fa-circle' }}" style="color:var(--green-600);font-size:1.1rem"></i></td>
                        <td style="text-align:center">{{ $svc->order }}</td>
                        <td>
                            @if($svc->is_active)
                                <span class="badge badge-green"><i class="fas fa-circle" style="font-size:.45rem"></i> {{ __('admin.active') }}</span>
                            @else
                                <span class="badge badge-gray"><i class="fas fa-circle" style="font-size:.45rem"></i> {{ __('admin.inactive') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="td-actions">
                                <a href="{{ route('layanan.detail', $svc) }}" target="_blank" class="btn btn-xs btn-outline"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.layanan.edit', $svc) }}" class="btn btn-xs btn-outline"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.layanan.destroy', $svc) }}" method="POST" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger btn-delete-confirm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--slate-400);padding:3rem">{{ __('admin.no_data') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
