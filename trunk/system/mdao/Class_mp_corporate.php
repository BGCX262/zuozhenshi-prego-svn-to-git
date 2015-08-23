<?php
/**
* エラーチェッククラス
**/
if ($smp_floder_flag){
	require_once( '../../system/Class_M_DAO.php' );
} else{
	require_once( '../system/Class_M_DAO.php' );
}
class Class_mp_corporate extends Class_M_DAO {
	//protected properties begin
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = "mp_corporate";
	
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
	 	"corporate_name"    => array(PREGO_VARTYPE_STR),	
	 	"another_name"    	=> array(PREGO_VARTYPE_STR),	
	 	"post_name"    		=> array(PREGO_VARTYPE_STR),	
	 	"post_code"    		=> array(PREGO_VARTYPE_STR),	
	 	"address"    		=> array(PREGO_VARTYPE_STR),	
	 	"tel"    			=> array(PREGO_VARTYPE_STR),	
	 	"present"    		=> array(PREGO_VARTYPE_STR),	
	 	"url"    			=> array(PREGO_VARTYPE_STR),	
	 	"memo"    			=> array(PREGO_VARTYPE_STR)
	 );
	
	 protected $_checks  = array(
	 	"corporate_name"    => array( "EXIST" ),
	 	"another_name"    	=> array( "KATAKANA" ),
	 	"post_name"    		=> array( "" ),
// 	 	"post_code"    		=> array( "NUM" ),
	 	"address"    		=> array( "" ),
// 	 	"tel"    			=> array( "" ),
	 	"region"    		=> array( "NUM" ),
	 	"branch"    		=> array( "NUM" ),
	 	"area_code"    		=> array( "NUM" ),
	 	"office_number"    	=> array( "NUM" ),
	 	"called_number"    	=> array( "NUM" ),
	 	"present"    		=> array( "" ),
	 	"url"    			=> array( "URL" ),
	 	"memo"    			=> array( "" )
	 );
	 
	 //maxlength 
	 protected $_maxlens  = array(
		"corporate_name"     =>  100 ,
		"another_name"     	 =>  100 ,
		"post_name"     	 =>  100 ,
		"post_code"     	 =>  7 ,
		"address"     		 =>  200 ,
		"tel"     		 	 =>  20 ,
		"present"     		 =>  50 ,
		"url"     			 =>  200 ,
		"memo"     			 =>  1000 
	 );
	 
	 public function search($where ,&$page = NULL ){	
		$sql    = "SELECT a.*,b.user_name from {$this->_table} a inner join  mp_account b on a.id = b.other_id and sorts = 2 ";
		$sqlCnt = "SELECT COUNT(*) AS cnt FROM mp_corporate a inner join  mp_account b on a.id = b.other_id and sorts = 2  ";
		
// 		$sql = "SELECT a.*,(select  user_name FROM {$this->_table} where  id  = a.u_user) as m_user_name from {$this->_table} a ";
		return  parent::search($where ,$page ,$sql,$sqlCnt);
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