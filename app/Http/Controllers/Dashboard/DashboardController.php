<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Master\Asset;
use App\Models\Master\AssetType;
use App\Models\Master\Org\Struct;
use App\Models\Problem\Problem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $module =  'dashboard';
    protected $routes =  'dashboard';
    protected $views =  'dashboard';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'title' => 'Dashboard',
            ]
        );
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->status != 'active') {
            return $this->render($this->views . '.nonactive');
        }
        if (!$user->checkPerms('dashboard.view') || !$user->roles()->exists()) {
            return abort(403);
        }

        $progress = [
            // [
            //     'name'      => 'incident',
            //     'title'     => 'Insiden',
            //     'color'     => 'primary',
            //     'icon'      => 'fas fa-paper-plane',
            //     'closed'    => Incident::where('status', 'closed')->count(),
            //     'total'     => Incident::count(),
            // ],
            // [
            //     'name'      => 'problem',
            //     'title'     => 'Problem',
            //     'color'     => 'success',
            //     'icon'      => 'fas fa-bookmark',
            //     'closed'    => Problem::where('status', 'closed')->count(),
            //     'total'     => Problem::count(),
            // ],
            // [
            //     'name'      => 'change',
            //     'title'     => 'Change',
            //     'color'     => 'warning',
            //     'icon'      => 'fas fa-id-card',
            //     'closed'    => Change::where('status', 'closed')->count(),
            //     'total'     => Change::count(),
            // ],
            // [
            //     'name'      => 'knowledge',
            //     'title'     => 'Knowledge',
            //     'color'     => 'info',
            //     'icon'      => 'fas fa-id-card',
            //     'closed'    => Knowledge::count(),
            //     'total'     => Knowledge::count(),
            // ],
        ];

        return $this->render(
            $this->views . '.index',
            ['progress' => $progress]
        );
    }

    public function setLang($lang)
    {
        if (\Cache::has('userLocale')) {
            \Cache::forget('userLocale');
        }
        \Cache::forever('userLocale', $lang);
        return redirect()->back();
    }
}
