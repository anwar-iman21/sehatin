<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityReport;
use App\Models\CommunityReply;
use App\Models\CommunityThread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommunityModerationController extends Controller
{
    public function index()
    {
        $reports = CommunityReport::with(['reporter', 'reportable'])
            ->where('status', 'pending')->latest()->paginate(20);
        $unverifiedDoctors = User::where('role', '!=', 'admin')
            ->where('is_verified_doctor', false)
            ->orderBy('name')
            ->limit(100)
            ->get();

        return view('admin.community.moderation', compact('reports', 'unverifiedDoctors'));
    }

    public function resolve(CommunityReport $report)
    {
        $report->update(['status' => 'reviewed']);

        return back()->with('success', __('app.report_resolved'));
    }

    public function destroyReportedContent(CommunityReport $report)
    {
        $content = $report->reportable;
        abort_unless($content instanceof CommunityThread || $content instanceof CommunityReply, 404);

        DB::transaction(function () use ($content): void {
            if ($content instanceof CommunityThread) {
                $replyIds = $content->replies()->pluck('id');
                if ($replyIds->isNotEmpty()) {
                    CommunityReport::where('reportable_type', (new CommunityReply())->getMorphClass())
                        ->whereIn('reportable_id', $replyIds)
                        ->update(['status' => 'reviewed']);
                }
            }

            CommunityReport::where('reportable_type', $content->getMorphClass())
                ->where('reportable_id', $content->getKey())
                ->update(['status' => 'reviewed']);

            $content->delete();
        });

        return back()->with('success', __('app.report_content_deleted'));
    }

    public function verifyDoctor(Request $request, User $user)
    {
        abort_if($request->user()->is($user), 422, __('app.cannot_verify_self'));
        $user->is_verified_doctor = true;
        $user->save();

        return back()->with('success', __('app.doctor_verified_success'));
    }
}
