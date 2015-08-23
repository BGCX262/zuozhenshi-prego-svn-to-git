<?php
class Class_mp_pro extends Class_M_DAO {
	//protected properties begin
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = "mp_pro";
	
	
	public function getProBySpecId($specid){
		$sql = 'select *  from mp_pro where spec_id = '.$specid;
		return  parent::search($where=null ,$page=null ,$sql);
	}
}