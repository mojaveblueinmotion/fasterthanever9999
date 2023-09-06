<?php

namespace App\Models\Auth;

use Illuminate\Support\Carbon;
use App\Models\Master\RoleGroup;
use App\Models\Traits\RaidModel;
use App\Models\Traits\Utilities;
use Laravel\Sanctum\HasApiTokens;
use App\Imports\Setting\UserImport;
use App\Models\Master\Org\Position;
use App\Models\Traits\ResponseTrait;
use App\Models\Master\RoleGroupMember;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Setting\Globals\Activity;
use App\Models\Setting\Globals\Approval;
use Illuminate\Notifications\Notifiable;
use App\Models\Setting\Globals\TempFiles;
use App\Models\Setting\Globals\Notification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;
    use HasApiTokens;
    use RaidModel, Utilities, ResponseTrait;

    protected $table = 'sys_users';

    protected $appends = [
        'roles_imploded',
    ];
    protected $fillable = [
        'warga_id',
        'name',
        'jenis_kelamin',
        'tgl_lahir',
        'alamat',
        'email',
        'username',
        'password',
        'position_id',
        'status',
        'nik',
        'image',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'tgl_lahir'
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $with = [
        'roles',
    ];

    /** MUTATOR **/
    public function setTglLahirAttribute($value)
    {
        $this->attributes['tgl_lahir'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    /** ACCESSOR **/
    public function getImagePathAttribute()
    {
        if ($this->image) {
            if (\Storage::disk('public')->exists($this->image)) {
                return 'storage/' . $this->image;
            }
            $this->update(['image' => null]);
        }
        return 'assets/media/users/default.jpg';
    }

    public function getRolesImplodedAttribute()
    {
        return implode(', ', $this->roles->pluck('name')->toArray());
    }

    /** RELATION **/
    public function notifications()
    {
        return $this->belongsToMany(
            Notification::class,
            'sys_notifications_users',
            'user_id',
            'notification_id'
        )
            ->withPivot('readed_at');
    }
    public function groups()
    {
        return $this->belongsToMany(
            RoleGroup::class,
            RoleGroupMember::class,
            'user_id',
            'role_group_id',
        );
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'user_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    /** SCOPE **/

    public function scopeFilters($query)
    {
        return $query->filterBy(['name', 'email'])
            ->filterBy('status', '=')
            ->when(
                $location_id = request()->post('location_id'),
                function ($q) use ($location_id) {
                    $q->whereHas(
                        'position',
                        function ($q) use ($location_id) {
                            $q->where('location_id', $location_id);
                        }
                    );
                }
            )
            ->when(
                $role_id = request()->post('role_id'),
                function ($q) use ($role_id) {
                    $q->whereHas(
                        'roles',
                        function ($q) use ($role_id) {
                            $q->where('id', $role_id);
                        }
                    );
                }
            );
    }

    public function scopeWhereHasLocationId($query, $location_id = [])
    {
        return $query->whereHas(
            'position',
            function ($q) use ($location_id) {
                $q->where('location_id', $location_id);
            }
        );
    }

    /** SAVE DATA */
    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $this->fill($request->only($this->fillable));
            if ($request->password) {
                $this->password = bcrypt($request->password);
            }
            $this->save();
            if ($this->id != 1) {
                $this->roles()->sync(array_filter($request->roles ?? []));
            }
            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleDestroy()
    {
        $this->beginTransaction();
        try {
            if (!$this->canDeleted()) {
                return $this->rollback(__('base.error.related'));
            }
            $this->saveLogNotify();
            $this->delete();

            return $this->commitDeleted();
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }

    public function handleUpdateProfile($request)
    {
        $this->beginTransaction();
        try {
            if ($request->image) {
                $oldImage = $this->image;
                $this->image = $request->image->store('users', 'public');
            }
            $this->phone  = $request->phone;
            $this->email  = $request->email;
            $this->save();
            $this->saveLogNotify();

            // Hapus file image yg lama
            if (!empty($oldImage) && \Storage::disk('public')->exists($oldImage)) {
                \Storage::disk('public')->delete($oldImage);
            }
            return $this->commitSaved(['redirectTo' => route($request->routes . '.index')]);
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleUpdatePassword($request)
    {
        $this->beginTransaction();
        try {
            $this->password  = bcrypt($request->new_password);
            $this->save();
            $this->saveLogNotify();
            return $this->commitSaved(['redirectTo' => route($request->routes . '.index')]);
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleImport($request)
    {
        $this->beginTransaction();
        try {
            $file = TempFiles::find($request->uploads['temp_files_ids'][0]);
            if (!$file || !\Storage::disk('public')->exists($file->file_path)) {
                $this->rollback('File tidak tersedia!');
            }

            \Excel::import(new UserImport, \Storage::disk('public')->path($file->file_path));

            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function saveLogNotify()
    {
        $data = $this->name;
        $routes = request()->get('routes');
        switch (request()->route()->getName()) {
            case $routes . '.store':
                $this->addLog('Membuat Data ' . $data);
                break;
            case $routes . '.update':
                $this->addLog('Mengubah Data ' . $data);
                break;
            case $routes . '.destroy':
                $this->addLog('Menghapus Data ' . $data);
                break;
            case $routes . '.update-profile':
                $this->addLog('Mengubah Profil ' . $data);
                break;
            case $routes . '.update-password':
                $this->addLog('Mengubah Password ' . $data);
                break;
            case $routes . '.importSave':
                auth()->user()->addLog('Import Data User');
                break;
        }
    }

    /** OTHER FUNCTION **/
    public function canDeleted()
    {
        if (in_array($this->id, [1])) return false;
        if ($this->id == auth()->id()) return false;

        return true;
    }

    public function checkPerms($permission)
    {
        return $this->hasPermissionTo($permission);
    }

    public function getLastNotificationId()
    {
        $last = $this->notifications()->latest()->first();
        return $last->id ?? 0;
    }

    public function getRoleIds()
    {
        return $this->roles()->pluck('id')->toArray();
    }
}
