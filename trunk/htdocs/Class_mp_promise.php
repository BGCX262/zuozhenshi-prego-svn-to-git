<?php
/**
* エラーチェッククラス
**/
if ($smp_floder_flag){
	require_once( '../../system/Class_M_DAO.php' );
} else{
	require_once( '../system/Class_M_DAO.php' );
}
class Class_mp_promise extends Class_M_DAO {
	//protected properties begin
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = "mp_promise";
	
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
	 		
		 	"corporate_id"    	 			=> array(PREGO_VARTYPE_INT),	
		 	"corporate_name"    	 		=> array(PREGO_VARTYPE_STR),	
		 	"promise_name"    				=> array(PREGO_VARTYPE_STR)
	 		
	 );
	
	 protected $_checks  = array(
	 		
	 		"corporate_name"    			=> array( "EXIST" ),
	 		"promise_name"    				=> array( "EXIST" )
	 );
	 
	 //maxlength 
	 protected $_maxlens  = array(
	 		
			"corporate_name"     			=>  100 ,
			"promise_name"     				=>  200 
	 );
	 
	 public function search($where ,&$page = NULL ){	
		$sql = "SELECT a.* from {$this->_table} a ";
// 		$sql = "SELECT a.*,(select  user_name FROM {$this->_table} where  id  = a.u_user) as m_user_name from {$this->_table} a ";
		$order = "id desc ";
		return  parent::search($where ,$page ,$sql, null, $order);
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