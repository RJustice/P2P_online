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
                    'label' => $member->name . ' - ' . preg_replace('/([0-9]{5})[0-9]{9}([0-9]{4}|[0-9]{3}X)/i','$1****$2',$member->idno) . ' - ' . preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',$member->phone),
                    'value' => $member->getKey()
                ];
            }
            return $tmp;
        }else{
            return [];
        }

    }

    public function formatInfo($idno = false ,$name = true ){
        if( $idno ){
            if( $this->idcardpassed ){
                return $name ? $this->name . ' - ' . preg_replace('/([0-9]{5})[0-9]{9}([0-9]{4}|[0-9]{3}X)/i','$1****$2',$this->idno) : preg_replace('/([0-9]{5})[0-9]{9}([0-9]{4}|[0-9]{3}X)/i','$1****$2',$this->idno);
            }else{
                return "尚未认证";
            }
        }else{
            return $name ? $this->name . ' - ' . preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',$this->phone) : preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',$this->phone);
        }
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

    public static function getAge($user){
        $byear = substr($user->idno,6,4);
        return $user->idcardpassed ? ( ( date('Y')-$byear + 1 ) > 100 ? '高龄' : ( date('Y')-$byear + 1 ).'岁') : '身份证未认证';
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
    

    public static function hiddenXin($name){
        $fuxin = ['欧阳','太史','端木','上官','司马','东方','独孤','南宫','万俟','闻人','夏侯','诸葛','尉迟','公羊','赫连','澹台','皇甫','宗政','濮阳','公冶','太叔','申屠','公孙','慕容','仲孙','钟离','长孙','宇文','司徒','鲜于','司空','闾丘','子车','亓官','司寇','巫马','公西','颛孙','壤驷','公良','漆雕','乐正','宰父','谷梁','拓跋','夹谷','轩辕','令狐','段干','百里','呼延','东郭','南门','羊舌','微生','公户','公玉','公仪','梁丘','公仲','公上','公门','公山','公坚','左丘','公伯','西门','公祖','第五','公乘','贯丘','公皙','南荣','东里','东宫','仲长','子书','子桑','即墨','达奚','褚师','吴铭'];
        if( preg_match("/^(欧阳|太史|端木|上官|司马|东方|独孤|南宫|万俟|闻人|夏侯|诸葛|尉迟|公羊|赫连|澹台|皇甫|宗政|濮阳|公冶|太叔|申屠|公孙|慕容|仲孙|钟离|长孙|宇文|司徒|鲜于|司空|闾丘|子车|亓官|司寇|巫马|公西|颛孙|壤驷|公良|漆雕|乐正|宰父|谷梁|拓跋|夹谷|轩辕|令狐|段干|百里|呼延|东郭|南门|羊舌|微生|公户|公玉|公仪|梁丘|公仲|公上|公门|公山|公坚|左丘|公伯|西门|公祖|第五|公乘|贯丘|公皙|南荣|东里|东宫|仲长|子书|子桑|即墨|达奚|褚师|吴铭)/", $name) ){
            return "*".mb_substr($name,2,mb_strlen($name),'UTF-8');
        }else{
            return "*".mb_substr($name, 1,mb_strlen($name),'UTF-8');
        }
    }

    public function bank(){
        return $this->hasOne('App\UserBank');
    }

    public function getTotalDealMoney(){
        $sum = $this->dealOrders()
            ->whereIn('type',[DealOrder::TYPE_OFFLINE_ORDER,DealOrder::TYPE_ONLINE_ORDER,DealOrder::TYPE_POS_INVEST])
            ->where('status','<>',DealOrder::STATUS_NOT_PASSED)
            ->sum('total_price');
        return $sum;
    }

}