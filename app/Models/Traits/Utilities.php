<?php

namespace App\Models\Traits;

trait Utilities
{
    public function checkAction($action, $perms)
    {
        $user = auth()->user();
        switch ($action) {
            case 'create':
                return $user->checkPerms($perms . '.create');
            case 'show':
            case 'history':
                return $user->checkPerms($perms . '.view');
            case 'edit':
                return $user->checkPerms($perms . '.edit');
            case 'delete':
                return $user->checkPerms($perms . '.delete');
        }
        return false;
    }

    public function canDeleted()
    {
        return true;
    }
    public function getLogTitle()
    {
        return $this::class;
    }

    public function labelStatus($status = null)
    {
        return \Base::getStatus($status ?? $this->status);
    }

    public function labelVersion()
    {
        $colors = [0 => 'primary', 'info', 'success', 'warning', 'danger'];
        $label = $this->version;
        $color = $colors[$this->version] ?? 'dark';
        return \Base::makeLabel($label, $color);
    }

    public function saveLogNotify()
    {
        $title = $this->getLogTitle();
        $routes = request()->get('routes');
        switch (request()->route()->getName()) {
            case $routes . '.store':
                $this->addLog('Membuat Data ' . $title);
                break;
            case $routes . '.update':
                $this->addLog('Mengubah Data ' . $title);
                break;
            case $routes . '.destroy':
                $this->addLog('Menghapus Data ' . $title);
                break;
            case $routes . '.grant':
                $this->addLog('Mengubah Hak Akses Role ' . $title);
                break;
            case $routes . '.importSave':
                auth()->user()->addLog('Import Data ' . $title);
                break;
        }
    }
}
