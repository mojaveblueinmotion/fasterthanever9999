<?php

namespace App\Models\Traits;

use App\Models\Auth\User;
use App\Models\Setting\Globals\Approval;
use App\Models\Setting\Globals\MenuFlow;

trait HasApprovals
{
    /** Approval by all module **/
    public function approvals()
    {
        return $this->morphMany(Approval::class, 'target');
    }

    /** Approval by specific module **/
    public function approval($module)
    {
        return $this->approvals()->whereModule($module);
    }

    /** Use this function when submit **/
    public function generateApproval($module)
    {
        if ($this->approval($module)->exists()) {
            $this->approval($module)->delete();
        }

        $flows = MenuFlow::hasModule($module)->orderBy('order')->get();
        if (!$flows->count()) {
            return $this->responseError(
                [
                    'message' => 'Flow Approval tidak terdapat!'
                ]
            );
        }

        $results = [];
        foreach ($flows as $item) {
            $results[] = new Approval(
                [
                    'module' => $module,
                    'role_id' => $item->role_id,
                    'order' => $item->order,
                    'type' => $item->type,
                    'status' => 'new',
                ]
            );
        }

        return $this->approval($module)->saveMany($results);
    }

    public function resetStatusApproval($module)
    {
        return $this->approval($module)
            ->update(
                [
                    'status'      => 'new',
                    'user_id'     => null,
                    'position_id' => null,
                    'note'        => null,
                    'approved_at' => null,
                ]
            );
    }

    /** Use this function before submit **/
    public function getFlowApproval($module)
    {
        return MenuFlow::with('role')
            ->whereHas(
                'menu',
                function ($q) use ($module) {
                    $q->where('module', $module);
                }
            )
            ->orderBy('order')
            ->get()
            ->groupBy('order');
    }

    public function rejected($module)
    {
        return $this->approval($module)->whereStatus('rejected')->latest()->first();
    }

    public function firstNewApproval($module)
    {
        return $this->approval($module)
            ->whereStatus('new')
            ->orderBy('order')
            ->first();
    }

    /** Check auth user can action approval by specific module **/
    public function checkApproval($module)
    {
        if ($new = $this->firstNewApproval($module)) {
            $user = auth()->user()->load('roles');
            // dd(
            //     103,
            //     json_decode($new),
            //     $module,
            //     $user->getRoleIds(),
            //     $this->approval($module)
            //         ->where('order', $new->order)
            //         ->whereStatus('new')
            //         ->whereIn('role_id', $user->getRoleIds())
            //         ->exists()
            // );
            return $this->approval($module)
                ->where('order', $new->order)
                ->whereStatus('new')
                ->whereIn('role_id', $user->getRoleIds())
                ->exists();
        }

        return false;
    }

    public function getNewUserIdsApproval($module)
    {
        $role_ids = [];
        if ($new = $this->firstNewApproval($module)) {
            $role_ids = $this->approval($module)
                ->where('order', $new->order)
                ->whereStatus('new')
                ->pluck('role_id')
                ->toArray();
        }
        return User::whereHas(
            'roles',
            function ($q) use ($role_ids) {
                $q->whereIn('id', $role_ids);
            }
        )
            ->pluck('id')
            ->toArray();
    }

    /** Reject data by specific module by specific module **/
    public function rejectApproval($module, $note)
    {
        if ($new = $this->firstNewApproval($module)) {
            $user = auth()->user();
            return $this->approval($module)
                ->where('order', $new->order)
                ->whereStatus('new')
                ->whereIn('role_id', $user->getRoleIds())
                ->update(
                    [
                        'status' => 'rejected',
                        'user_id' => $user->id,
                        'position_id' => $user->position_id,
                        'note' => $note,
                        'approved_at' => null,
                    ]
                );
        }
    }

    /** Approve data by specific module **/
    public function approveApproval($module, $note = null)
    {
        if ($new = $this->firstNewApproval($module)) {
            $user = auth()->user();
            return $this->approval($module)
                ->where('order', $new->order)
                ->whereStatus('new')
                ->whereIn('role_id', $user->getRoleIds())
                ->update(
                    [
                        'status' => 'approved',
                        'user_id' => $user->id,
                        'position_id' => $user->position_id,
                        'note' => $note,
                        'approved_at' => now(),
                    ]
                );
        }
    }
}
