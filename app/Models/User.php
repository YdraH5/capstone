<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function search($keyword)
    {
        // show all data when search box is null
        $query = DB::table('users')
            ->select(
                'name',
                'email',
                'role',
                (DB::raw('DATE_FORMAT(created_at, "%b-%d-%Y") as date'))
            );
        // this statement will show the data that is %like% the search input
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('email', 'like', '%' . $keyword . '%')
            ->orWhere( 'role', 'like', '%' . $keyword . '%')
            ->orWhere( 'created_at', 'like', '%' . $keyword . '%');
        }
        return $query->get();
    }
}
