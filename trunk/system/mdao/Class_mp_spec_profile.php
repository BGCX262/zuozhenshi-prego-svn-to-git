<?php
/**
* エラーチェッククラス
**/
if ($smp_floder_flag){
	require_once( '../../system/Class_M_DAO.php' );
} else{
	require_once( '../system/Class_M_DAO.php' );
}
class Class_mp_spec_profile extends Class_M_DAO {
	//protected properties begin
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = "mp_spec_profile";
	
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
		 	"profile_name"    	 		=> array(PREGO_VARTYPE_STR),	
		 	"have_profile_url"    	 	=> array(PREGO_VARTYPE_STR),	
		 	"have_no_profile_url"    	=> array(PREGO_VARTYPE_STR),
		 	"title"    	 				=> array(PREGO_VARTYPE_STR),
		 	"image1"    	 			=> array(PREGO_VARTYPE_STR),
			"image2"    	 			=> array(PREGO_VARTYPE_STR),
			"image3"    	 			=> array(PREGO_VARTYPE_STR),
		 	"summary"    	 			=> array(PREGO_VARTYPE_STR),
		 	"address"    	 			=> array(PREGO_VARTYPE_STR),
		 	"experience"    	 		=> array(PREGO_VARTYPE_STR),
		 	"qualifications"    	 	=> array(PREGO_VARTYPE_STR),
		 	"actual_result"    	 		=> array(PREGO_VARTYPE_STR),
		 	"famous"    	 			=> array(PREGO_VARTYPE_STR),
		 	"comprehensive"    	 		=> array(PREGO_VARTYPE_STR),
		 	"fee_message_a"    	 		=> array(PREGO_VARTYPE_STR),
		 	"fee_message_b"    	 		=> array(PREGO_VARTYPE_STR),
		 	"fee_message_c"    	 		=> array(PREGO_VARTYPE_STR),
		 	"cartoon_url"    	 		=> array(PREGO_VARTYPE_STR)
	 );
	
	 protected $_checks  = array(
	 		
	 		"profile_name"    				=> array( "EXIST" ),
	 		"have_profile_url"    			=> array( "" ),
	 		"have_no_profile_url"    		=> array( "" ),
	 		"title"    						=> array( "" ),
	 		"image1"    					=> array( "" ),
			"image2"    					=> array( "" ),
			"image3"    					=> array( "" ),
	 		"summary"    					=> array( "" ),
	 		"address"    					=> array( "" ),
	 		"experience"    				=> array( "" ),
	 		"qualifications"    			=> array( "" ),
	 		"actual_result"    				=> array( "" ),
	 		"famous"    					=> array( "" ),
	 		"comprehensive"    				=> array( "" ),
	 		"fee_message_a"    				=> array( "" ),
	 		"fee_message_b"    				=> array( "" ),
	 		"fee_message_c"    				=> array( "" ),
	 		"cartoon_url"    				=> array( "URL" )
	 );
	 
	 //maxlength 
	 protected $_maxlens  = array(
	 		
			"profile_name"     				=>  100 ,
			"have_profile_url"     			=>  200, 
			"have_no_profile_url"     		=>  200, 
			"title"     					=>  200, 
	 		"image1"     					=>  100,
	 		"image2"     					=>  100,
			"image3"     					=>  100,
			"summary"     					=>  1000, 
			"address"     					=>  200, 
			"experience"     				=>  1000, 
			"qualifications"     			=>  1000, 
			"actual_result"     			=>  1000, 
			"famous"     					=>  200, 
			"comprehensive"     			=>  1000,
			"fee_message_a"     			=>  200,
			"fee_message_b"     			=>  200,
			"fee_message_c"     			=>  200,
			"cartoon_url"     				=>  200
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