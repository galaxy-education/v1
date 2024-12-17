<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

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
        'phone_number',
        'type',
        'provider_id',
        'provider_name',
        'device_token',
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
    public function profile(){
        return $this->hasOne(Profile::class);
    }
    public function invitation()
    {
        return $this->hasOne(Invitation::class);
    }

    protected static function boot()
    {
        parent::boot();

        // توليد كود دعوة تلقائي عند إنشاء المستخدم
        static::created(function ($user) {
            $user->invitation()->create([
                'invitation_code' => self::generateUniqueCode(),
            ]);
        });
    }

    private static function generateUniqueCode()
    {
        $code = Str::random(10);

        // التحقق من أن الكود فريد في جدول الدعوات
        while (Invitation::where('invitation_code', $code)->exists()) {
            $code = Str::random(10);
        }

        return $code;
    }

    public function walt(){
        return $this->hasOne(Walt::class);
    }
    public function changeRequests()
    {
        return $this->hasMany(ChangeRequest::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'teacher_id');
    }

    // إذا كان المستخدم طالبًا
    public function bookings()
    {
        return $this->hasMany(Appointment::class, 'student_id');
    }

    public function conversations()
{
    return $this->belongsToMany(Conversation::class);
}

// In User (Teacher) Model


// In Appointment Model


}
