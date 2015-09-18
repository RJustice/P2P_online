<?php
namespace App;

use Artesaos\Defender\Traits\HasDefender;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\UserMeta;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword, EntrustUserTrait;
    
    protected $table = 'users';
    
    // protected $fillable = ['name','phone','username', 'password','state','email'];
    protected $guarded = ['id'];
    
    protected $hidden = ['password','paypassword'];
    
    protected $primaryKey = 'id';
    
    const TYPE_ADMIN = 'admin';
    const TYPE_MEMBER = 'member';
    const TYPE_EMPLOYEE = 'employee';

    const STATE_SYS_CREATED = 4; // 后台系统创建 , 需强制更改密码
    const STATE_DELETED = 5;  // 删除 , 不可登陆
    const STATE_INVAILD = 0;  // 禁用 , 不可登陆
    const STATE_VALID = 1;  // 可用
    const STATE_FREEZE = 3;  // 冻结 , 可登陆, 但不能操作

    const REFERER_SYSTEM = 'system';
    const REFERER_SALES_CREATED = 'sales_created';
    const REFERER_NORMAL = 'web_register';
    const REFERER_WX = 'weixin';
    const REFERER_OTHER = 'other';

    public function getAuthIdentifier()
    {
        // TODO: Implement getAuthIdentifier() method.
        return $this->getKey();
    }
    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        // TODO: Implement getAuthPassword() method.
        return $this->password;
    }
    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
        return $this->{$this->getRememberTokenName()};
    }
    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
        $this->{$this->getRememberTokenName()} = $value;
    }
    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
        return 'remember_token';
    }
    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        // TODO: Implement getEmailForPasswordReset() method.
        return $this->email;
    }

    // public function metas(){
    //     return $this->belongsTo('App\UserMeta','uid','id');
    // }

    public function recUser(){
        return $this->hasOne('App\User','id','pid');
    }

    public function salesManager(){
        return $this->hasOne('App\User','id','sales_manager');
    }

    public function modifiedUser(){
        return $this->hasOne('App\User','id','modified_uid');
    }

    public static function getSalesManagers($format = false){
        $salesManagers = self::where('type',self::TYPE_EMPLOYEE)->whereIn('state',[self::STATE_VALID,self::STATE_SYS_CREATED])->get();
        // if( $salesManagers )
        if( $format ){
            foreach( $salesManagers as $salesManager ){
                $tmp[] = [
                    'label' => $salesManager->name,
                    'value' => $salesManager->id,
                ];
            }
            return $tmp;
        }else{
            return $salesManagers;
        }
    }

    public function dealOrders(){
        return $this->hasMany('App\DealOrder');
    }

    public function company(){
        return $this->belongsTo('App\Company');
    }
}