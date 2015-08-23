<?php
/**
* エラーチェッククラス

**/
if ($smp_floder_flag){
	require_once( '../../system/Class_M_DAO.php' );
} else{
	require_once( '../../system/Class_M_DAO.php' );
}

class Class_smp_specialist extends Class_M_DAO {
	//protected properties begin
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = "mp_spec";

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
		 	"interlingua"    				=> array(PREGO_VARTYPE_STR),
		 	"mail_address1"    				=> array(PREGO_VARTYPE_STR),
		 	"mail_address2"    				=> array(PREGO_VARTYPE_STR),
		 	"spec_area_a"    				=> array(PREGO_VARTYPE_STR),
	 		"spec_area_b"    				=> array(PREGO_VARTYPE_STR),
	 		"spec_area_c"    				=> array(PREGO_VARTYPE_STR),
	 		"spec_area_d"    				=> array(PREGO_VARTYPE_STR),
	 		"spec_area_else"    			=> array(PREGO_VARTYPE_STR),
		 	"corporate_name"    			=> array(PREGO_VARTYPE_STR),
// 		 	"post_code"    					=> array(PREGO_VARTYPE_STR),
		 	"address"    					=> array(PREGO_VARTYPE_STR),
// 		 	"tel"    						=> array(PREGO_VARTYPE_STR),
// 		 	"phone"    						=> array(PREGO_VARTYPE_STR),
// 		 	"fax"    						=> array(PREGO_VARTYPE_STR),
// 		 	"birthday"    					=> array(PREGO_VARTYPE_STR),
		 	"introducer"    				=> array(PREGO_VARTYPE_STR),
		 	"introducer_fee"    			=> array(PREGO_VARTYPE_STR),
		 	"introducer_fee_status"    		=> array(PREGO_VARTYPE_STR),
		 	"introducer_fee_status_time"    => array(PREGO_VARTYPE_STR),
		 	"agreement_day"    				=> array(PREGO_VARTYPE_STR),
		 	"agreement_condition"    		=> array(PREGO_VARTYPE_STR),
		 	"login_fee"    			 		=> array(PREGO_VARTYPE_STR),
		 	"update_fee"    		 		=> array(PREGO_VARTYPE_STR),
		 	"update_fee_start_time"    		=> array(PREGO_VARTYPE_STR),
		 	"agreement_end_day"    			=> array(PREGO_VARTYPE_STR),
	 		"hp"    						=> array(PREGO_VARTYPE_STR),
		 	"bank_name"    					=> array(PREGO_VARTYPE_STR),
		 	"shop_name"    					=> array(PREGO_VARTYPE_STR),
		 	"account_kinds"    				=> array(PREGO_VARTYPE_STR),
		 	"account_code"    				=> array(PREGO_VARTYPE_STR),
		 	"account_titular"    			=> array(PREGO_VARTYPE_STR),
		 	"account_titular_name"    		=> array(PREGO_VARTYPE_STR),
		 	"person_choose"    				=> array(PREGO_VARTYPE_STR)
	 );

	 protected $_checks  = array(

	 		"spec_name"    					=> array( "EXIST" ),
	 		"interlingua"    				=> array( "EXIST","ALPHASPACE" ),
	 		"mail_address1"    				=> array( "EXIST","EMAIL" ),
	 		"mail_address2"    				=> array( "EMAIL" ),
	 		"spec_area_a"    				=> array( "" ),
	 		"spec_area_b"    				=> array( "" ),
	 		"spec_area_c"    				=> array( "" ),
	 		"spec_area_d"    				=> array( "" ),
	 		"spec_area_else"    			=> array( "" ),
	 		"corporate_name"    			=> array( "" ),
// 	 		"region"    					=> array( "NUM" ),
// 	 		"branch"    					=> array( "NUM" ),
// 	 		"post_code"    					=> array( "NUM" ),
	 		"address"    					=> array( "" ),
// 	 		"area_code"    					=> array( "NUM" ),
// 	 		"office_number"    				=> array( "NUM" ),
// 	 		"called_number"    				=> array( "NUM" ),
// 	 		"cell1"    						=> array( "NUM" ),
// 	 		"cell2"    						=> array( "NUM" ),
// 	 		"cell3"    						=> array( "NUM" ),
// 	 		"fax1"    						=> array( "NUM" ),
// 	 		"fax2"    						=> array( "NUM" ),
// 	 		"fax3"    						=> array( "NUM" ),
// 	 		"birthday_year"    				=> array( "NUM" ),
// 	 		"birthday_month"    			=> array( "NUM" ),
// 	 		"birthday_day"    				=> array( "NUM" ),
	 		"introducer"    				=> array( "" ),
	 		"introducer_fee"    			=> array( "" ),
	 		"introducer_fee_status"    		=> array( "" ),
	 		"introducer_fee_status_time"    => array( "" ),
	 		"agreement_day"    				=> array( "" ),
	 		"agreement_condition"    		=> array( "" ),
	 		"login_fee"    					=> array( "" ),
	 		"update_fee"    				=> array( "" ),
	 		"update_fee_start_time"    		=> array( "" ),
	 		"agreement_end_day"    			=> array( "" ),
	 		"hp"							=> array( "" ),
	 		"bank_name"    					=> array( "" ),
	 		"shop_name"    					=> array( "" ),
	 		"account_kinds"    				=> array( "" ),
	 		"account_code"    				=> array( "" ),
	 		"account_titular"    			=> array( "" ),
	 		"account_titular_name"    		=> array( "KATAKANA" ),
	 		"person_choose"    				=> array( "" ),
	 );

	 //maxlength
	 protected $_maxlens  = array(

			"spec_name"     				=>  100 ,
			"interlingua"     				=>  200 ,
			"mail_address1"     			=>  200 ,
			"mail_address2"     			=>  200 ,
		 	"spec_area_else" 				=>  50,
			"corporate_name"     			=>  100 ,
// 			"region"     					=>  3 ,
// 			"branch"     					=>  4 ,
			"address"     					=>  200 ,
// 			"area_code"     				=>  2 ,
// 			"office_number"     			=>  4 ,
// 			"called_number"     			=>  4 ,
// 			"cell1"     					=>  2 ,
// 			"cell2"     					=>  4 ,
// 			"cell3"     					=>  4 ,
// 			"fax1"     						=>  2 ,
// 			"fax2"     						=>  4 ,
// 			"fax3"     						=>  4 ,
			"introducer"     				=>  50 ,
	// 		"introducer_fee"    			=> ,
	// 	 	"introducer_fee_status"    		=> ,
	// 	 	"introducer_fee_status_time"	=> ,
	// 		"agreement_day" 				=> ,
			"agreement_condition"    		=>  200 ,
	// 		"login_fee"    					=> ,
	// 	 	"update_fee"    				=> ,
	// 	 	"update_fee_start_time"    		=> ,
	// 	 	"agreement_end_day"    			=> ,
			"bank_name"     				=>  100 ,
			"shop_name"     				=>  100 ,
	// 		"account_kinds"      			=> ,
			"account_code"     				=>  10 ,
			"account_titular"     			=>  200 ,
			"account_titular_name"     		=>  200
	// 		"person_choose"     			=> ,
	 );

	 public function search($where ,&$page = NULL ){
		$sql    = "SELECT a.*,b.user_name from {$this->_table} a inner join  mp_account b on a.id = b.other_id and sorts = 3 ";
		$sqlCnt = "SELECT COUNT(*) AS cnt FROM {$this->_table} a inner join  mp_account b on a.id = b.other_id and sorts = 3  ";
// 		$sql = "SELECT a.*,(select  user_name FROM {$this->_table} where  id  = a.u_user) as m_user_name from {$this->_table} a ";
		return  parent::search($where ,$page ,$sql, $sqlCnt);
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