<?php
/**
* エラーチェッククラス
**/
if ($smp_floder_flag){
	require_once( '../../system/Class_M_DAO.php' );
} else{
	require_once( '../system/Class_M_DAO.php' );
}
class Class_mp_service extends Class_M_DAO {
	//protected properties begin
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = "mp_service";
	
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
	 		
		 	"sku"    	 					=> array(PREGO_VARTYPE_STR),	
		 	"category_id"    				=> array(PREGO_VARTYPE_INT),	
		 	"service_menu"    				=> array(PREGO_VARTYPE_STR),	
		 	"service_fee"    				=> array(PREGO_VARTYPE_INT),	
		 	"spec_fee"    					=> array(PREGO_VARTYPE_INT),	
		 	"caption"    					=> array(PREGO_VARTYPE_STR),	
		 	"memo"    						=> array(PREGO_VARTYPE_STR),	
		 	"kinds"    						=> array(PREGO_VARTYPE_STR)
	 );
	
	 protected $_checks  = array(
	 		
	 		"sku"    						=> array( "EXIST" ,"NUM"),
// 	 		"service_menu"    				=> array( "" ),
	 		"service_fee"    				=> array( "NUM" ),
	 		"spec_fee"    					=> array( "NUM" )
// 	 		"caption"    					=> array( "" ),
// 	 		"memo"    						=> array( "" ),
// 	 		"kinds"    						=> array( "" )
	 );
	 
	 //maxlength 
	 protected $_maxlens  = array(
	 		
			"sku"     						=>  100 ,
			"service_menu"     				=>  100 ,
			"service_fee"     				=>  10 ,
			"spec_fee"     					=>  10 ,
			"caption"     					=>  1000 ,
			"memo"     						=>  1000 ,
			"kinds"     					=>  100
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