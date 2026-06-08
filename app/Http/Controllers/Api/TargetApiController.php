<?php

namespace App\Http\Controllers\Api;

use App\Models\Target;
use Illuminate\Http\Request;

class TargetApiController extends BaseApiController
{
    /**
     * GET /api/v1/targets
     */
    public function index(Request $request)
    {
        $targets = Target::where('user_id', $request->user()->id)
                         ->orderByDesc('created_at')
                         ->get()
                         ->map(fn($t) => $this->formatTarget($t));

        return $this->success($targets);
    }

    /**
     * GET /api/v1/targets/{id}
     */
    public function show(Request $request, $id)
    {
        $target = Target::where('user_id', $request->user()->id)->find($id);
        if (!$target) return $this->notFound('Target tidak ditemukan.');
        return $this->success($this->formatTarget($target));
    }

    /**
     * POST /api/v1/targets
     * Body: { name, description?, type?, target_value?, deadline? }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:200',
            'description'  => 'nullable|string',
            'type'         => 'in:custom,weekly,monthly',
            'target_value' => 'integer|min:1|max:9999',
            'deadline'     => 'nullable|date|after:today',
        ]);

        $target = Target::create([
            'user_id'      => $request->user()->id,
            'name'         => $validated['name'],
            'description'  => $validated['description'] ?? null,
            'type'         => $validated['type'] ?? 'custom',
            'target_value' => $validated['target_value'] ?? 1,
            'current_value'=> 0,
            'deadline'     => $validated['deadline'] ?? null,
            'status'       => 'active',
        ]);

        return $this->success($this->formatTarget($target), 'Target berhasil ditambahkan!', 201);
    }

    /**
     * PUT|PATCH /api/v1/targets/{id}
     * Body: { name?, description?, target_value?, current_value?, deadline?, status? }
     */
    public function update(Request $request, $id)
    {
        $target = Target::where('user_id', $request->user()->id)->find($id);
        if (!$target) return $this->notFound('Target tidak ditemukan.');

        $validated = $request->validate([
            'name'          => 'sometimes|string|max:200',
            'description'   => 'sometimes|nullable|string',
            'target_value'  => 'sometimes|integer|min:1|max:9999',
            'current_value' => 'sometimes|integer|min:0',
            'deadline'      => 'sometimes|nullable|date',
            'status'        => 'sometimes|in:active,done,failed',
        ]);

        $target->update($validated);
        $target->checkAndUpdateStatus();

        return $this->success($this->formatTarget($target->fresh()), 'Target berhasil diperbarui!');
    }

    /**
     * DELETE /api/v1/targets/{id}
     */
    public function destroy(Request $request, $id)
    {
        $target = Target::where('user_id', $request->user()->id)->find($id);
        if (!$target) return $this->notFound('Target tidak ditemukan.');

        $target->delete();
        return $this->success(null, 'Target berhasil dihapus.');
    }

    /**
     * PATCH /api/v1/targets/{id}/increment
     * Tambah progress target +1 atau sejumlah value
     * Body: { value?: 1 }
     */
    public function increment(Request $request, $id)
    {
        $target = Target::where('user_id', $request->user()->id)->find($id);
        if (!$target) return $this->notFound('Target tidak ditemukan.');
        if ($target->status !== 'active') return $this->error('Target sudah tidak aktif.');

        $addValue = $request->input('value', 1);
        $target->increment('current_value', $addValue);
        $target->checkAndUpdateStatus();

        return $this->success($this->formatTarget($target->fresh()), 'Progress target diperbarui!');
    }

    // ── PRIVATE ──────────────────────────────────────
    private function formatTarget(Target $t): array
    {
        return [
            'id'               => $t->id,
            'name'             => $t->name,
            'description'      => $t->description,
            'type'             => $t->type,
            'target_value'     => $t->target_value,
            'current_value'    => $t->current_value,
            'progress_percent' => $t->getProgressPercent(),
            'deadline'         => $t->deadline?->toDateString(),
            'status'           => $t->status,
            'status_label'     => $t->getStatusLabel(),
            'created_at'       => $t->created_at->toDateTimeString(),
        ];
    }
}