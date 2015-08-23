<?php
/**
* エラーチェッククラス
**/
if ($smp_floder_flag){
	require_once( '../../system/Class_M_DAO.php' );
} else{
	require_once( '../system/Class_M_DAO.php' );
}
class Class_mp_promise_spec extends Class_M_DAO {
	//protected properties begin
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = "mp_promise_spec";
	
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
	 		
		 	"spec_name"    	 				=> array(PREGO_VARTYPE_STR),	
		 	"spec_id"    	 				=> array(PREGO_VARTYPE_INT),	
		 	"service_name"    				=> array(PREGO_VARTYPE_STR),
		 	"service_id"    				=> array(PREGO_VARTYPE_INT),
	 		"promise_id"    	 			=> array(PREGO_VARTYPE_INT),
	 		"profile_id"    	 			=> array(PREGO_VARTYPE_INT),
	 		"doing_time"    	 			=> array(PREGO_VARTYPE_STR),
	 		"before_mail"    	 			=> array(PREGO_VARTYPE_STR),
	 		"overtime_have"    	 			=> array(PREGO_VARTYPE_STR),
	 		"overtime_fee"    	 			=> array(PREGO_VARTYPE_INT),
	 		"traffic_fee_have"    	 		=> array(PREGO_VARTYPE_STR),
	 		"traffic_fee"    	 			=> array(PREGO_VARTYPE_INT),
	 		"traffic_fee_detail"    	 	=> array(PREGO_VARTYPE_STR),
	 		"live_fee_have"    	 			=> array(PREGO_VARTYPE_STR),
	 		"live_fee"    	 				=> array(PREGO_VARTYPE_INT),
	 		"live_fee_detail"    	 		=> array(PREGO_VARTYPE_STR),
	 		"other_fee_have"    	 		=> array(PREGO_VARTYPE_STR),
	 		"other_fee"    	 				=> array(PREGO_VARTYPE_INT),
	 		"other_fee_name"    	 		=> array(PREGO_VARTYPE_STR),
	 		"other_fee_detail"    	 		=> array(PREGO_VARTYPE_STR),
	 		"status"    	 				=> array(PREGO_VARTYPE_STR),
	 		"satisfy_status"    	 		=> array(PREGO_VARTYPE_STR),
	 		"request_status"    	 		=> array(PREGO_VARTYPE_STR),
	 		"pay_status"    	 			=> array(PREGO_VARTYPE_STR)
	 		
	 		
	 );
	
	 protected $_checks  = array(
	 		
	 		"spec_name"    					=> array( "EXIST" ),
	 		"profile_id"    				=> array( "EXIST", "NUM" ),
	 		"service_name"    				=> array( "EXIST" ),
	 		"day"    						=> array( "YMD" ),
	 		"hour"    						=> array( "NUM" ),
	 		"minute"    					=> array( "NUM" ),
	 		"before_mail"    				=> array( "" ),
	 		"overtime_have"    				=> array( "" ),
	 		"overtime_fee"    				=> array( "NUM" ),
	 		"traffic_fee_have"    			=> array( "" ),
	 		"traffic_fee"    				=> array( "NUM" ),
	 		"traffic_fee_detail"   			=> array( "" ),
	 		"live_fee_have"    				=> array( "" ),
	 		"live_fee"    					=> array( "NUM" ),
	 		"live_fee_detail"    			=> array( "" ),
	 		"other_fee_have"    			=> array( "" ),
	 		"other_fee"    					=> array( "NUM" ),
	 		"other_fee_name"    			=> array( "" ),
	 		"other_fee_detail"    			=> array( "" )
	 );
	 
	 //maxlength 
	 protected $_maxlens  = array(
	 		
			"spec_name"     				=>  100 ,
			"service_name"     				=>  100 ,
			"overtime_fee"     				=>  10 ,
			"traffic_fee_detail"    		=>  1000 ,
			"live_fee_detail"     			=>  1000 ,
			"other_fee_name"     			=>  100 ,
			"other_fee_detail"     			=>  200 
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