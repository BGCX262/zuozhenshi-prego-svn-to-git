<?php
/**
* エラーチェッククラス
**/
if ($smp_floder_flag){
	require_once( '../../system/Class_M_DAO.php' );
} else{
	require_once( '../system/Class_M_DAO.php' );
}
class Class_mp_spec_traffic_fee extends Class_M_DAO {
	//protected properties begin
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = "mp_spec_traffic_fee";
	
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
	 		"spec_id"    	 			=> array(PREGO_VARTYPE_INT),
		 	"traffic_name"    	 			=> array(PREGO_VARTYPE_STR),	
		 	"traffic_fee"    	 			=> array(PREGO_VARTYPE_STR),	
		 	"traffic_memo"    	 			=> array(PREGO_VARTYPE_STR)	
	 );
	
	 protected $_checks  = array(
	 		
	 		"traffic_name"    				=> array( "EXIST" ),
	 		"traffic_fee"    				=> array( "EXIST","NUM" ),
	 		"traffic_memo"    				=> array( "EXIST" )
	 );
	 
	 //maxlength 
	 protected $_maxlens  = array(
	 		
			"traffic_name"     				=>  100 ,
// 			"traffic_fee"     				=>  200 ,
			"traffic_memo"     				=>  1000 
	 );
	 
	 public function search($where ,&$page = NULL ){	
		$sql = "SELECT a.* from {$this->_table} a ";
// 		$sql = "SELECT a.*,(select  user_name FROM {$this->_table} where  id  = a.u_user) as m_user_name from {$this->_table} a ";
		return  parent::search($where ,$page ,$sql);
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