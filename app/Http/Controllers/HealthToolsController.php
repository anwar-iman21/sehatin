<?php

namespace App\Http\Controllers;

use App\Models\ConsultationMessage;
use Illuminate\Http\Request;

class HealthToolsController extends Controller
{
    public function bmi()
    {
        return view('health-tools.bmi');
    }

    public function mentalHealthQuiz()
    {
        return view('health-tools.mental-health-quiz');
    }

    public function sdg()
    {
        return view('pages.sdg');
    }

    public function consultation(Request $request)
    {
        ConsultationMessage::expireInactiveConversations();
        $messages = collect();
        if ($user = $request->user()) {
            $user->consultationMessages()->where('sender', 'admin')->whereNull('read_at')->update(['read_at' => now()]);
            ConsultationMessage::touchConversation($user->id);
            $messages = $user->consultationMessages()->orderBy('id')->get();
        }

        return view('consultation.index', compact('messages'));
    }

    public function chat(Request $request)
    {
        ConsultationMessage::expireInactiveConversations();
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:4000'],
        ], [
            'message.required' => __('app.consultation_message_required'),
            'message.string' => __('app.consultation_message_required'),
            'message.min' => __('app.consultation_message_min'),
            'message.max' => __('app.consultation_message_max'),
        ]);

        if (blank($validated['message'])) {
            return response()->json(['message' => __('app.consultation_message_required')], 422);
        }

        $message = $request->user()->consultationMessages()->create([
            'sender' => 'user',
            'message' => $validated['message'],
        ]);

        return response()->json([
            'message' => [
                'id' => $message->id,
                'sender' => $message->sender,
                'body' => $message->message,
            ],
        ], 201);
    }

    public function consultationMessages(Request $request)
    {
        $validated = $request->validate(['after' => ['sometimes', 'integer', 'min:0']]);
        ConsultationMessage::expireInactiveConversations();
        $after = $validated['after'] ?? 0;
        $userMessages = $request->user()->consultationMessages();
        $reset = $after > 0 && !$request->user()->consultationMessages()->whereKey($after)->exists();
        $messages = $userMessages
            ->when(!$reset, fn ($query) => $query->where('sender', 'admin')->where('id', '>', $after))
            ->orderBy('id')
            ->get(['id', 'sender', 'message']);

        if ($messages->isNotEmpty()) {
            $request->user()->consultationMessages()
                ->whereIn('id', $messages->pluck('id'))
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }
            if (!$reset) {
                ConsultationMessage::touchConversation($request->user()->id);
            }

        return response()->json(['messages' => $messages, 'reset' => $reset])
            ->header('Cache-Control', 'no-store, private');
    }
}
