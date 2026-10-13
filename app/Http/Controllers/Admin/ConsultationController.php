<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        ConsultationMessage::expireInactiveConversations();
        $latestMessageIds = ConsultationMessage::query()
            ->selectRaw('MAX(id)')
            ->groupBy('user_id');
        $latestMessages = ConsultationMessage::with('user')
            ->whereIn('id', $latestMessageIds)
            ->orderByDesc('id')
            ->paginate(20);

        $latestMessageId = ConsultationMessage::max('id') ?? 0;

        return view('admin.consultations.index', compact('latestMessages', 'latestMessageId'));
    }

    public function updates(Request $request)
    {
        $validated = $request->validate(['after' => ['sometimes', 'integer', 'min:0']]);
        ConsultationMessage::expireInactiveConversations();

        $latestMessageIds = ConsultationMessage::query()
            ->selectRaw('MAX(id)')
            ->groupBy('user_id');
        $messages = ConsultationMessage::with('user')
            ->whereIn('id', $latestMessageIds)
            ->where('id', '>', $validated['after'] ?? 0)
            ->orderByDesc('id')
            ->get()
            ->map(fn (ConsultationMessage $message) => [
                'id' => $message->id,
                'sender' => $message->sender,
                'message' => $message->message,
                'created_at' => $message->created_at->diffForHumans(),
                'user' => [
                    'id' => $message->user->id,
                    'name' => $message->user->name,
                    'email' => $message->user->email,
                ],
                'show_url' => route('admin.consultations.show', $message->user),
                'delete_url' => route('admin.consultations.destroy', $message->user),
                'awaiting_reply' => $message->sender === 'user',
            ]);

        return response()->json([
            'messages' => $messages,
            'latest_message_id' => ConsultationMessage::max('id') ?? 0,
        ])->header('Cache-Control', 'no-store, private');
    }

    public function show(User $user)
    {
        abort_if($user->isAdmin(), 404);
        ConsultationMessage::expireInactiveConversations();

        $user->consultationMessages()
            ->where('sender', 'user')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        $messages = $user->consultationMessages()->with('admin')->orderBy('id')->get();

        return view('admin.consultations.show', compact('user', 'messages'));
    }

    public function messages(Request $request, User $user)
    {
        abort_if($user->isAdmin(), 404);
        $validated = $request->validate(['after' => ['sometimes', 'integer', 'min:0']]);
        ConsultationMessage::expireInactiveConversations();
        $after = $validated['after'] ?? 0;
        $reset = $after > 0 && !$user->consultationMessages()->whereKey($after)->exists();
        $messages = $user->consultationMessages()
            ->when(!$reset, fn ($query) => $query->where('id', '>', $after))
            ->with('admin')
            ->orderBy('id')
            ->get()
            ->map(fn (ConsultationMessage $message) => [
                'id' => $message->id,
                'sender' => $message->sender,
                'message' => $message->message,
                'sender_name' => $message->sender === 'user' ? $user->name : ($message->admin?->name ?? __('app.consultation_admin_label')),
            ]);

        $user->consultationMessages()->where('sender', 'user')->whereNull('read_at')->update(['read_at' => now()]);

        return response()->json(['messages' => $messages, 'reset' => $reset])
            ->header('Cache-Control', 'no-store, private');
    }

    public function reply(Request $request, User $user)
    {
        abort_if($user->isAdmin(), 404);
        ConsultationMessage::expireInactiveConversations();
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:4000'],
        ]);

        $user->consultationMessages()->create([
            'admin_id' => $request->user()->id,
            'sender' => 'admin',
            'message' => $validated['message'],
        ]);

        return redirect()->route('admin.consultations.show', $user)
            ->with('success', __('app.consultation_reply_sent'));
    }

    public function destroy(User $user)
    {
        abort_if($user->isAdmin(), 404);
        $user->consultationMessages()->delete();

        return redirect()->route('admin.consultations.index')
            ->with('success', __('app.consultation_deleted'));
    }
}