<?php
/**
* エラーチェッククラス
**/
if ($smp_floder_flag){
	require_once( '../../system/Class_M_DAO.php' );
} else{
	require_once( '../system/Class_M_DAO.php' );
}
class Class_mp_corporate_tantou extends Class_M_DAO {
	//protected properties begin
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = "mp_corporate_tantou";
	
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
	 	"corporate_id"    	=> array(PREGO_VARTYPE_INT),	
	 	"tantou_name"    		=> array(PREGO_VARTYPE_STR),	
	 	"mail_address"    	=> array(PREGO_VARTYPE_STR)
	 );
	
	 protected $_checks  = array(
	 	"tantou_name"    	=> array( "EXIST" ),
	 	"mail_address"    		=> array( "EXIST","EMAIL" )
	 );
	 
	 //maxlength 
	 protected $_maxlens  = array(
		"corporate_id"     =>  11 ,
		"tantou_name"     =>  100 ,
		"mail_address"     =>  100 
	 );
	 
	 public function search($where ,&$page = NULL ){	
		$sql = "SELECT a.* from {$this->_table} a ";
		return  parent::search($where ,$page ,$sql);
// 		$sql = "SELECT a.*,(select  user_name FROM {$this->_table} where  id  = a.u_user) as m_user_name from {$this->_table} a ";
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