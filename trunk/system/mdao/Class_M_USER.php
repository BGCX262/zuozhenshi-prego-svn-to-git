<?php
/**
* エラーチェッククラス
**/
if ($smp_floder_flag){
	require_once( '../../system/Class_M_DAO.php' );
} else{
	require_once( '../system/Class_M_DAO.php' );
}
class Class_M_USER extends Class_M_DAO {
	//protected properties begin
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = "M_LOGIN";
	
	/**
	 *
	 * 主キー名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_pkey = "id";
	
	/**
	 *
	 * ソート順
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	 protected $_order = "id";
	 
	 protected $_cols  = array(
	 	"login_id"    => array(AOKI_VARTYPE_STR),
		"user_name"   => array(AOKI_VARTYPE_STR),
		"auth"        => array(AOKI_VARTYPE_STR),
	    "email"       => array(AOKI_VARTYPE_STR),
		"login_pwd"   => array(AOKI_VARTYPE_STR),
	 );
	
	 protected $_checks  = array(
		"login_id"   => array( "EXIST" ,"ALNUM" ),
		"login_pwd"  => array( "EXIST" ,"ALNUM" ),
		"user_name"  => array( "EXIST" ),
		"auth"       => array( "EXIST" ,"NUM" ),
		"email"      => array( "EXIST" ,"EMAIL" ),
		"login_ng"   => array("NUM" ),
		
	 );
	 
	 //maxlength 
	 protected $_maxlens  = array(
		"login_id"   =>  20 ,
		"user_name"  =>  20 ,
		"auth"       =>  1 ,
		"email"      =>  100 ,
		"login_pwd"  =>  200,
		"login_ng"   =>  1
	 );
	
	 public function search($where ,&$page = NULL ){	
		$sql = "SELECT a.*,(select  user_name FROM {$this->_table} where  id  = a.u_user) as m_user_name from {$this->_table} a ";
		return  parent::search($where ,$page ,$sql);
	}
	 public function search_csv($where  ){	
		$sql = "SELECT a.*,b.ins_co_name,c.electric_name,(select  user_name FROM {$this->_table} where  id  = a.u_user) as m_user_name from {$this->_table} a ";
		$sql = $sql." LEFT JOIN  M_INS_CO b ON a.ins_co_cd = b.ins_co_cd ";
		$sql = $sql." LEFT JOIN  M_ELECTRIC c ON a.electric_id = c.id ";
		$page = null;
		return  parent::search($where ,$page ,$sql);
	}
	
}

?>