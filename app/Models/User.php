<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'phone_number',
        'is_employee',
        'picture',
        'name',
        'furigana',
        'dob',
        'gender',
        'address',
        'pos',
        'pos_date',
        'driver_license',
        'working_place',
        'working_plan',
        'introduce',
        'nationality',
        'visa_type',
        'work_restrictions',
        'advancement',
        'japanese_level',
        'urgent_contact',
        'custom_id',
        'nick_name',
        'resisdence_card_number',
        'my_number',
        'dependent',
        'start_date',
        'manager',
        'registred_day',
        'emergency_contact_name',
        'prefecture_id',
        'work_place_id',
        'black_list',
        'black_list_description',
        'real_name',
        'admin_type'
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




    protected $enumMappings = [
        'working_place' => [
            '1' => "事務",
            '2' => "中沢乳業社",
            '3' => "相模原",
            '4' => "浦和美園センター",
            '5' => "太田市場",
            '6' => "運転者",
            '7' => "公徳",
            '8' => "その他"
        ],
        'driver_license' => [
            '1' => '普通免許(AT、MT、第一種、第二種)',
            '2' => '準中型免許',
            '3' => '中型免許(第一種、第二種)',
            '4' => '大型免許(第一種、第二種)',
            '5' => '小型特殊免許',
            '6' => '大型特殊免許(第一種、第二種)',
            '7' => '牽引免許(第一種、第二種)',
            '8' => '普通二輪免許(AT、MT)',
            '9' => '大型二輪免許',
            '10' => '原付免許',
            '11' => '運転免許証なし'
        ],
        'working_plan' => [
            '1' => '1年',
            '2' => '2年',
            '3' => '3年',
            '4' => '3年以上'
        ],
        'visa_type' => [
            '1' => "外交 ",
            '2' => "公用",
            '3' => "教授",
            '4' => "芸術",
            '5' => "宗教",
            '6' => "報道",
            '7' => "高度専門職",
            '8' => "経営・管理",
            '9' => "法律・会計業務",
            '10' => "医療",
            '11' => "研究",
            '12' => "教育",
            '13' => "技術・人文知識・国際業務",
            '14' => "企業内転勤",
            '15' => "介護（※１）",
            '16' => "興行",
            '17' => "技能",
            '18' => "技能実習",
            '19' => "文化活動",
            '20' => "短期滞在",
            '21' => "留学",
            '22' => "研修",
            '23' => "家族滞在",
            '24' => "特定活動",
            '25' => "永住者",
            '26' => "日本人の配偶者等",
            '27' => "永住者の配偶者等",
            '28' => "定住者"
        ],
        'advancement' => [
            '1' => '就職',
            '2' => '進学',
            '3' => '帰国',
            '4' => '休職',
            '5'=> '在籍中'
        ],
        'japanese_level' => [
            '1' => 'N1',
            '2' => 'N2',
            '3' => 'N3',
            '4' => 'N4',
            '5' => 'N5',
            '6' => 'NO'
        ],
        'pos' => [
            "1" => "1年3ヶ月",
            "2" => "3年",
            "3" => "5年",
            "4" => "5年以降"
        ],
        'gender' => [
            "0" => "女",
            "1" => "男"
        ],
        'manager' => [
            "1" => 'モンスタースレン',
            "2" => '前村潤奎',
            "3" => '海老原美寿々',
            "4" => '野中梢絵',
            "5" => '鈴木孝之',
            "6" => '土屋佑太'
        ]
    ];

    public function scopeNonAdmin($query)
    {
        return $query->where('is_employee', '!=', 'admin');
    }

    public function scopeEmployee($query)
    {
        return $query->where('is_employee', 'employee');
    }

    public function scopeWorker($query)
    {
        return $query->where('is_employee', 'worker');
    }

    public function scopeFilterByWorkingPlace($query, $workingPlaceValue)
    {
        return $query->where(function ($query) use ($workingPlaceValue) {
            $query->where('working_place', array_search($workingPlaceValue, $this->enumMappings['working_place']));
        });
    }
    public function scopeFilterByDriverLicense($query, $value)
    {
        return $query->where(function ($query) use ($value) {
            $query->where('driver_license', array_search($value, $this->enumMappings['driver_license']));
        });
    }
    public function scopeFilterByWorkingPlan($query, $value)
    {
        return $query->where(function ($query) use ($value) {
            $query->where('working_plan', array_search($value, $this->enumMappings['working_plan']));
        });
    }
    public function scopeFilterByVisaType($query, $value)
    {
        return $query->where(function ($query) use ($value) {
            $query->where('visa_type', array_search($value, $this->enumMappings['visa_type']));
        });
    }
    public function scopeFilterByAdvancement($query, $value)
    {
        return $query->where(function ($query) use ($value) {
            $query->where('advancement', array_search($value, $this->enumMappings['advancement']));
        });
    }
    public function scopeFilterByJapaneseLevel($query, $value)
    {
        return $query->where(function ($query) use ($value) {
            $query->where('japanese_level', array_search($value, $this->enumMappings['japanese_level']));
        });
    }

    public function scopeFilterByPos($query, $value)
    {
        return $query->where(function ($query) use ($value) {
            $query->where('pos', array_search($value, $this->enumMappings['pos']));
        });
    }

    public function scopeFilterByGender($query, $value)
    {
        return $query->where(function ($query) use ($value) {
            $query->where('gender', array_search($value, $this->enumMappings['gender']));
        });
    }
    public function getWorkingPlaceValueAttribute()
    {
        if ($this->attributes['working_place']) {
            return $this->enumMappings['working_place'][$this->attributes['working_place']];
        }
    }

    public function getWorkingPlanValueAttribute()
    {
        if ($this->attributes['working_plan']) {
            return $this->enumMappings['working_plan'][$this->attributes['working_plan']];
        }
    }

    public function getDriverLicenseValueAttribute()
    {
        if ($this->attributes['driver_license']) {
            return $this->enumMappings['driver_license'][$this->attributes['driver_license']];
        }
    }

    public function getVisaTypeValueAttribute()
    {
        if ($this->attributes['visa_type']) {
            return $this->enumMappings['visa_type'][$this->attributes['visa_type']];
        }
    }

    public function getAdvancementValueAttribute()
    {
        if ($this->attributes['advancement']) {
            return $this->enumMappings['advancement'][$this->attributes['advancement']];
        }
    }

    public function getJapaneseLevelValueAttribute()
    {
        if ($this->attributes['japanese_level']) {
            return $this->enumMappings['japanese_level'][$this->attributes['japanese_level']];
        }
    }

    public function getPosValueAttribute()
    {
        if ($this->attributes['pos']) {
            return $this->enumMappings['pos'][$this->attributes['pos']];
        }
    }

    public function getManagerValueAttribute()
    {
        if ($this->attributes['manager']) {
            return $this->enumMappings['manager'][$this->attributes['manager']];
        }
    }

    public function national()
    {
        return $this->hasOne(National::class, 'id', 'nationality');
    }
    public function relation()
    {
        return $this->hasMany(Relation::class, 'user_id');
    }
    public function prefecture()
    {
        return $this->hasOne(Prefecture::class, 'id', 'prefecture_id');
    }
}
