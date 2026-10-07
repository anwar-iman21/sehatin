@extends('admin.layouts.app')
@section('title', __('admin.faqs'))
@section('page-title', __('admin.faqs'))

@section('content')
<div class="table-card">
    <div class="table-header">
        <h3><i class="fas fa-question-circle" style="color:var(--green-600)"></i> {{ __('admin.faqs') }}</h3>
        <a href="{{ route('admin.faq.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('admin.add_faq') }}</a>
    </div>
    <div style="overflow-x:auto">
        <table>
            <thead>
                <tr>
                    <th>{{ __('admin.faq_question') }}</th>
                    <th>{{ __('admin.order') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                    <tr>
                        <td>
                            <div style="font-weight:600;max-width:480px">{{ Str::limit($faq->question, 80) }}</div>
                            <div style="font-size:.75rem;color:var(--slate-400);margin-top:.2rem">{{ Str::limit($faq->answer, 80) }}</div>
                        </td>
                        <td style="text-align:center">{{ $faq->order }}</td>
                        <td>
                            @if($faq->is_active)
                                <span class="badge badge-green"><i class="fas fa-circle" style="font-size:.45rem"></i> {{ __('admin.active') }}</span>
                            @else
                                <span class="badge badge-gray"><i class="fas fa-circle" style="font-size:.45rem"></i> {{ __('admin.inactive') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="td-actions">
                                <a href="{{ route('admin.faq.edit', $faq) }}" class="btn btn-xs btn-outline"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger btn-delete-confirm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--slate-400);padding:3rem">{{ __('admin.no_data') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
