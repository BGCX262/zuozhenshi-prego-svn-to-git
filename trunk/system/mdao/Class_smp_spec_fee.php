<?php
/**
* エラーチェッククラス
**/
if ($smp_floder_flag){
	require_once( '../../system/Class_M_DAO.php' );
} else{
	require_once( '../../system/Class_M_DAO.php' );
}
class Class_smp_spec_fee extends Class_M_DAO {
	//protected properties begin
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = "mp_spec_fee";

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
	 		"spec_id"    	 				=> array(PREGO_VARTYPE_INT),
	 		"service_id"					=> array(PREGO_VARTYPE_INT),
		 	"servers_menu"    	 			=> array(PREGO_VARTYPE_STR),
		 	"spec_fee"    	 				=> array(PREGO_VARTYPE_INT),
		 	"servers_fee"    	 			=> array(PREGO_VARTYPE_INT)
	 );

	 protected $_checks  = array(

	 		"servers_menu"    				=> array( "EXIST"),
	 		"spec_fee"    					=> array( "EXIST" ,"NUM" ),
	 		"servers_fee"    				=> array( "EXIST" ,"NUM" )
	 );

	 //maxlength
	 protected $_maxlens  = array(

			"servers_menu"     				=>  100
// 			"spec_fee"     					=>   ,
// 			"servers_fee"     				=>   ,
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