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
use App\Region;
use Hashids;

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
        return $this->belongsTo('App\User','sales_manager','id');
    }

    public function modifiedUser(){
        return $this->belongsTo('App\User','modified_uid','id');
    }

    public static function getSalesManagers($format = false,$company = 0){
        if( $company ){
            $salesManagers = self::where('type',self::TYPE_EMPLOYEE)->whereIn('state',[self::STATE_VALID,self::STATE_SYS_CREATED])->where('company_id',$company)->get();
        }else{
            $salesManagers = self::where('type',self::TYPE_EMPLOYEE)->whereIn('state',[self::STATE_VALID,self::STATE_SYS_CREATED])->get();
        }
        if( ! $salesManagers->isEmpty() ){
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
        }else{
            return [];
        }
    }

    public function dealOrders(){
        return $this->hasMany('App\DealOrder');
    }

    public function company(){
        return $this->belongsTo('App\Company');
    }

    public function formatRegion(){
        return Region::formatRegion($this->province_id,$this->city_id,$this->county_id);
    }
    
    protected static function createdCallback($user){
        $hash_id = Hashids::encode($user->id);
        return $user->update(['hash_id'=>$hash_id]);
    }

    protected static function deletedCallback($user){
        return false;
    }

    public static function getMembersOption($format = false){
        $members = self::where('type','<>',self::TYPE_ADMIN)->whereIn('state',[self::STATE_VALID,self::STATE_SYS_CREATED])->where('is_deleted',0)->get();
        // dd($members);
        if( ! $members->isEmpty() ){
            foreach( $members as $member){
                $tmp[] = [
                    'label' => $member->name . ' - ' . preg_replace('/([0-9]{5})[0-9]{9}([0-9]{4})/i','$1****$2',$member->idno) . ' - ' . preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',$member->phone),
                    'value' => $member->getKey()
                ];
            }
            return $tmp;
        }else{
            return [];
        }

    }

    public function formatInfo(){
        return $this->name . ' - ' . preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',$this->phone);
    }

    public static function getSex($sex){
        $sexs = [
            0 => '女',
            1 => '男'
        ];
        if( isset($sexs[$sex]) ){
            return $sexs[$sex];
        }else{
            return "未知";
        }
    }


    // 来源 referer
    
    protected static function referer(){
        return [
            self::REFERER_SYSTEM => '系统后台创建',
            self::REFERER_SALES_CREATED => '销售创建',
            self::REFERER_NORMAL => '网页注册',
            self::REFERER_WX => '微信',
            self::REFERER_OTHER => '其他'
        ];
    }

    public static function getRefererTitle($referer){
        $titles = self::referer();
        if( isset($titles[$referer]) ){
            return $titles[$referer];
        }else{
            return '未知来源!';
        }
    }

    public static function getRefererOption($format = false){
        $referer = self::referer();
        if( $format ){
            foreach($referer as $k=>$v){
                $tmp[] = [
                    'label' => $v,
                    'value' => $k
                ];
            }
            return $tmp;
        }else{
            return $referer;
        }
    }
    
}