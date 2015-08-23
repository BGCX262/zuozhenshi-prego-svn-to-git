<?php
/**
* エラーチェッククラス
**/
if ($smp_floder_flag){
	require_once( '../../system/Class_M_DAO.php' );
} else{
	require_once( '../system/Class_M_DAO.php' );
}
class Class_mp_account extends Class_M_DAO {
	//protected properties begin
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = "mp_account";
	
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
	 	"login_id"    => array(PREGO_VARTYPE_STR),
		"user_name"   => array(PREGO_VARTYPE_STR),
		"sorts"       => array(PREGO_VARTYPE_INT),
		"other_id"    => array(PREGO_VARTYPE_STR),
	    "login_flgs"  => array(PREGO_VARTYPE_STR),
		"login_pwd"   => array(PREGO_VARTYPE_STR)
	 );
	
	 protected $_checks  = array(
		"login_id"   => array( "EXIST" ),
		"login_pwd"  => array( "EXIST" ),
		"user_name"  => array( "EXIST" ),
		"sorts"      => array( "EXIST" ,"NUM" ),
		"login_flgs" => array( "NUM" )
		
	 );
	 
	 //maxlength 
	 protected $_maxlens  = array(
		"login_id"     =>  20 ,
		"user_name"    =>  100 ,
		"login_pwd"    =>  50 
	 );
	 
	 public function search($where ,&$page = NULL ){	
		$sql = "SELECT a.*,(select  user_name FROM {$this->_table} where  id  = a.u_user) as m_user_name from {$this->_table} a ";
		return  parent::search($where ,$page ,$sql);
	}
	 public function getByOtherid($otherid, $sort ){	
		$sql = "SELECT a.* from {$this->_table} a  where other_id ={$otherid} and sorts= {$sort}";
		$this->_db->query( $sql );
		if( $this->_db->num_rows() ){
			$retrow  =  $this->_db->fetch();
			return $retrow;
		}else{
			return  FALSE;
		}
	}
	/*
	 public function search_csv($where  ){	
		$sql = "SELECT a.*,b.ins_co_name,c.electric_name,(select  user_name FROM {$this->_table} where  id  = a.u_user) as m_user_name from {$this->_table} a ";
		$sql = $sql." LEFT JOIN  M_INS_CO b ON a.ins_co_cd = b.ins_co_cd ";
		$sql = $sql." LEFT JOIN  M_ELECTRIC c ON a.electric_id = c.id ";
		$page = null;
		return  parent::search($where ,$page ,$sql);
	}
	*/
	
}

?>