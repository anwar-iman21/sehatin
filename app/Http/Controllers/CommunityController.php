<?php

namespace App\Http\Controllers;

use App\Models\CommunityReply;
use App\Models\CommunityReport;
use App\Models\CommunityThread;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $threads = CommunityThread::query()
            ->with('user')
            ->withCount('replies')
            ->when($request->query('category'), fn ($query, $category) => $query->where('category', $category))
            ->when($request->query('sort') === 'popular', fn ($query) => $query->orderByDesc('views')->orderByDesc('created_at'),
                fn ($query) => $query->latest())
            ->paginate(12)
            ->withQueryString();

        $categories = CommunityThread::query()->select('category')->distinct()->orderBy('category')->pluck('category');

        return view('community.index', compact('threads', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => ['required', Rule::in(array_keys(__('app.community_categories')))],
            'title' => ['required', 'string', 'min:8', 'max:200'],
            'body' => ['required', 'string', 'min:10', 'max:10000'],
            'is_question' => ['sometimes', 'boolean'],
        ]);
        $validated['is_question'] = $request->boolean('is_question');
        $thread = $request->user()->communityThreads()->create($validated);

        return redirect()->route('community.show', $thread)->with('success', __('app.thread_created'));
    }

    public function show(CommunityThread $thread)
    {
        $thread->increment('views');
        $thread->load(['user', 'replies.user']);

        return view('community.show', compact('thread'));
    }

    public function reply(Request $request, CommunityThread $thread)
    {
        $validated = $request->validate(['body' => ['required', 'string', 'min:2', 'max:5000']]);
        $thread->replies()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
            'doctor_verified' => (bool) $request->user()->is_verified_doctor,
        ]);

        return back()->with('success', __('app.reply_created'));
    }

    public function report(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(['thread', 'reply'])],
            'id' => ['required', 'integer', 'min:1'],
            'reason' => ['required', Rule::in(['spam', 'abuse', 'misinformation', 'privacy', 'other'])],
            'details' => ['nullable', 'string', 'max:1000'],
        ]);

        $model = $validated['type'] === 'thread'
            ? CommunityThread::findOrFail($validated['id'])
            : CommunityReply::findOrFail($validated['id']);
        abort_if($model->user_id === $request->user()->id, 403);

        $model->reports()->firstOrCreate(
            ['reporter_id' => $request->user()->id, 'status' => 'pending'],
            ['reason' => $validated['reason'], 'details' => $validated['details'] ?? null]
        );

        return back()->with('success', __('app.report_received'));
    }
}
