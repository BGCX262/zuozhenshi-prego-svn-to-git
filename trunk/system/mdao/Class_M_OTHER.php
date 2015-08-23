<?php
/**
* エラーチェッククラス
**/
if ($smp_floder_flag){
	require_once( '../../system/Class_M_DAO.php' );
} else{
	require_once( '../system/Class_M_DAO.php' );
}

class Class_M_OTHER {
	
	public static function get_user_info( $login_id =null ){
		$db = new Class_DB;
		if (empty($login_id)) {
			$sql = "SELECT * FROM M_LOGIN ";
			$db->query( $sql);
			while( $row = $db->fetch() ){
				$data[$row["id"]] = $row;
			}
		} else {
			$sql = "SELECT * FROM M_LOGIN WHERE login_id = '{$login_id}'  and login_ng<>'1'";
			$db->query( $sql);
			if ( $row = $db->fetch() ){
				return  $row;
			}else {
				$data = NULL;
			}
		}
		return $data;
	}
	
	public static function get_mails( ){
		$db =  new Class_DB;
		/*
		 * "0 管理者　, 1　AOKI管理者, 2 エリアAJA,3 ゾーンAJA,
			4 折込会社(通常),5 折込会社 (地域広告),
			6 印刷会社(大日本),7 印刷会社(佐川印刷),8 一般店舗"
		 */
		$sql = "select email from M_LOGIN where auth = 1";
		$db->query( $sql);
		while( $row = $db->fetch() ){
			$data[] = $row["email"];
		}
		return $data;
	}
	
	//PASSWORD
	//折込会社
	public static function get_ins_co_array($please_select = NULL){	
		$db = new Class_DB;
		
		$sql = " select * from M_INS_CO order by ins_co_cd";
		$db->query( $sql);
		if ($please_select){
			$data[""] = $please_select;
		}
		
		while( $row = $db->fetch() ){
			$data[$row["ins_co_cd"]] = $row["ins_co_name"];
		}
		
		return $data;
	}

	//店舗
	public static function get_shop_array($please_select = NULL){
		session_name( 'AOKI_ADMIN' );
		session_start();
		$login_auth = $_SESSION['ADMIN_LOGIN']['STAFF_AUTH'];
		$innerjoin = "";
		if ($login_auth['staff_auth'] == 'G-2' || $login_auth['staff_auth']  == 'G-3') {
			$aja_cd = $_SESSION['ADMIN_LOGIN']['STAFF_SEQ'];
			$innerjoin = " INNER JOIN M_AJAREKS b on a.shop_cd = b.shop_cd  AND b.userid = '{$aja_cd}'";
		}
			
		$db = new Class_DB;
		$sql = " select a.* from M_SHOP a ";
		$sql = $sql.$innerjoin ;
		$sql = $sql." order by a.shop_cd ";
		
		$db->query( $sql);
		if ($please_select){
			$data[""] = $please_select;
		}
		
		while( $row = $db->fetch() ){
			$data[$row["shop_cd"]] = $row["shop_name"];
		}
		
		return $data;
	}
	
	//サービス
	public static function get_service_array($please_select = NULL){
		
		$db = new Class_DB;
		$sql =  " SELECT *  FROM M_MAP_SERVICE  ORDER BY  mservice_cd ";
		
		$db->query( $sql );
		if ($please_select){
			$data[""] = $please_select;
		}
		
		while( $row = $db->fetch() ){
			$data[$row["mservice_cd"]] = $row["mservice_name"];
		}
		
		return $data;
	}
	
	//都道府県
	public static function get_local_array($please_select = NULL){	
		$db = new Class_DB;
		$sql = " select * from M_LOCAL order by local_cd";
		$db->query( $sql);
			
		if ($please_select){
			$data[""] = $please_select;
		}
		while( $row = $db->fetch() ){
			$data[$row["local_cd"]] = $row["local_name"];
		}
		
		return $data;
	}
	
	//電波圏
	public static function get_electric_array($please_select = NULL,$userid =NULL){
		if ( empty($userid) ) {
			$sql = " select * from M_ELECTRIC order by id";
			if ($please_select){
				$data[""] = $please_select;
			}
			
		}else {
			$sql = " select a.* from M_ELECTRIC a inner join M_LOGIN b on b.electric_id =a.id where b.id ='{$userid}' ";
		}
		$db = new Class_DB;

		$db->query( $sql);
			
		while( $row = $db->fetch() ){
			$data[$row["id"]] = $row["electric_name"];
		}
		
		return $data;
	}
	
	//素材
	public static function get_mater_array($electricid, $year4, $please_select = NULL){
		if ($please_select){
			$data[""] = $please_select;
		}
		if (!empty($electricid)) {
			$db = new Class_DB;
			$sql = " select a.* from M_COST_TVSP_MATER a inner join M_COST_TVSP_MELEC b on a.id = b.materid where a.year4 ={$year4} and  b.electricid = '{$electricid}'  order by a.id";
			$db->query( $sql);
			
			while( $row = $db->fetch() ){
				$data[$row["id"]] = $row["mater_name"];
			}
		}
		return $data;
	}
	
	//素材
	public static function get_all_mater_array($electricid=NULL){
		$db = new Class_DB;
		$sql = " select a.* from M_COST_TVSP_MATER a ";
		if (!empty($electricid)) {
			$sql = $sql." where a.electricid = '{$electricid}' ";
		}
		
		$db->query( $sql);
		
		while( $row = $db->fetch() ){
			$data[$row["id"]] = $row["mater_name"];
		}
	
		return $data;
	}
	
	//媒体
	public static function get_media_array($please_select = NULL){	
		$db = new Class_DB;
		
		$sql = " select * from M_MEDIA";
		$db->query( $sql);
		$data = array();	
		if ($please_select){
			$data[""] = $please_select;
		}
		
		while( $row = $db->fetch() ){
			$data[$row["media_cd"]] = $row["media_name"];
		}
		
		return $data;
	}
	/*
	//ゾーン
	public static function get_zone_array($please_select = NULL){	
		$db = new Class_DB;
		
		$sql = " select * from M_ZONE";
		$db->query( $sql);
		$data = array();	
		if ($please_select){
			$data[""] = $please_select;
		}
		
		while( $row = $db->fetch() ){
			$data[$row["zone_cd"]] = $row["zone_name"];
		}
		
		return $data;
	}
	*/
	//ゾーンと担当者
	public static function get_zone_users(){	
		$db = new Class_DB;
		
		$sql = " select  u.user_name,u.login_id, b.*   from M_AJAREKS b " .
				" inner join M_LOGIN u on b.userid = u.id  where u.auth = '3' ";
		$db->query( $sql);
		$data = array();
		
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		
		return $data;
	}
	
	//ゾーンとエリア担当者
	public static function get_ajaeks_array($please_select = NULL, $auth = NULL, $bylogin = NULL){
		$db = new Class_DB;
		$sql = " select *  FROM M_LOGIN  ";
		
		if ($auth) {
			$sql =$sql ." WHERE ( auth = '{$auth}' )";
		} else {
			$sql =$sql ." WHERE ( auth = '2' OR auth = '3' )";
		}
		$sql =$sql." ORDER BY login_id ";
		$db->query( $sql);
		$data = array();	
		if ($please_select){
			$data[""] = $please_select;
		}
		if ($bylogin){
			while( $row = $db->fetch() ){
				$data[$row["login_id"]] = $row;
			}
		} else {
			while( $row = $db->fetch() ){
				$data[$row["id"]] = $row["login_id"]." ".$row["user_name"];
			}
		}
		return $data;
	}
	
	//ANP エリア
	public static function get_area_array($please_select = NULL){	
		$db = new Class_DB;
		
		$sql = " select * from M_AREA";
		$db->query( $sql);
			
		if ($please_select){
			$data[""] = $please_select;
		}
		while( $row = $db->fetch() ){
			$data[$row["area_cd"]] = $row["area_name"];
		}
		
		return $data;
	}
	
	//パターン
	//$sort 0 : 全部, 23 : 2通常地域 3地域広告
	
	public static function get_pattern_array($please_select = NULL, $sort = 0, $sortret = FALSE){
		$sql = "SELECT pattern_cd,pattern_name,media_flg  FROM M_PATTERN  WHERE   disp_ng = '0'   ";
		if ( $sort == 23) {
			$sql =  $sql ." and media_flg ='2' or  media_flg ='3' ";
		}elseif ($sort > 0) {
			$sql =  $sql ." and media_flg ='{$sort}'  ";
		} 
		$db = new Class_DB;
		
		$db->query( $sql);
			
		if ($please_select){
			if ($sortret) {
				$data["pattern"][""] = $please_select;
			}else {
				$data[""] = $please_select;
			}
		}
	
		if ($sortret) {
			
			while( $row = $db->fetch() ){
				$data["pattern"][$row["pattern_cd"]] = $row["pattern_name"];
				$data["sort"][$row["pattern_cd"]] = $row["media_flg"];
			}
		}else {
			while( $row = $db->fetch() ){
				$data[$row["pattern_cd"]] = $row["pattern_name"];
			}
		}
		
		return $data;
	}
	
	//ブロック
	public static function get_block_array($please_select = NULL){	
		$db = new Class_DB;
		$sql = " select * from M_BLOCK order by block_cd";
		$db->query( $sql);
			
		if ($please_select){
			$data[""] = $please_select;
		}
		while( $row = $db->fetch() ){
			$data[$row["block_cd"]] = $row["block_name"];
		}
		
		return $data;
	}
	
	//業者マスタ
	public static function get_hand_array($please_select = NULL){	
		$db = new Class_DB;
		$sql = " select * from M_HAND order by hand_cd";
		$db->query( $sql);
			
		if ($please_select){
			$data[""] = $please_select;
		}
		while( $row = $db->fetch() ){
			$data[$row["hand_cd"]] = $row["hand_name"];
		}
		
		return $data;
	}
	//地域マスタ
	public static function get_dist_array($please_select = NULL){	
		$db = new Class_DB;
		$sql = " select * from M_DIST_AREA order by dist_id";
		$db->query( $sql);
			
		if ($please_select){
			$data[""] = $please_select;
		}
		while( $row = $db->fetch() ){
			$data[$row["dist_id"]] = $row["dist_name"];
		}
		
		return $data;
	}
	
	//M_MATRIX_MST制作印刷業者エリア
	public static function  get_matrix_mst_array($sort, $please_select = NULL){	
		$db = new Class_DB;
		
		if ($sort) {
			if ( $sort == "ALL") {
				$sql = " select *  from  M_MATRIX_MST  order by sort,cd ";
			}else {
				$sql = " select *  from  M_MATRIX_MST  where sort ='{$sort}' order by cd ";
			}
				
		}else {
			$sql = " select *  from  M_MATRIX_MST  order by sort, cd ";
		}
		
		$db->query( $sql );
		
		if ($please_select){
			$data[""] = $please_select;
		}
	
		if ( $sort == "ALL") {
			
			while( $row = $db->fetch() ){
				$data[$row["sort"]][$row["cd"]] = $row["name"];
			}
		}else {
			while( $row = $db->fetch() ){
				$data[$row["cd"]] = $row["name"];
			}
		}
		return $data;
	}
	
	//
	public static function get_week_array($year, $please_select = NULL, $date_flg = FALSE, $cell =FALSE){	
		$db = new Class_DB;
		
		$sql = " select a.week_cd,a.matrix_cd,a.week_seq,a.flier_date from M_MATRIX_TERM  a ";
		if ($cell){
			$sql = $sql. " INNER JOIN T_MON_CELL_WEEK b on a.matrix_cd = b.matrix_cd ";
		}
		
		$sql = $sql. " where a.year4 = '{$year}' ";
	
		$sql = $sql." order by a.week_cd";
		$db->query( $sql);
		
		if ($please_select){
			$data[""] = $please_select;
		}
		
		while( $row = $db->fetch() ){
			$v = "第".$row["week_cd"]."週";
			if ($row["week_seq"] != 0) {
				$v = $v.$row["week_seq"]."回";
			}
			if ($date_flg) {
				$v = $v." (".Class_PWD::int8_to_date( $row["flier_date"] ).")";
				
			}
			$data[$row["matrix_cd"]] = $v;
		}
		
		return $data;
	}
	public static function get_by_matrix_cd($matrix_cd){	
		$db = new Class_DB;
			$sql = " select * from M_MATRIX_TERM  a where matrix_cd = {$matrix_cd}";
			$db->query( $sql);
		
		if ( $row = $db->fetch() ){
			return $row ;
		}
	}
	
	public static function get_pre_matrix_cd(){	
		$db = new Class_DB;
		$sql = " select max(a.matrix_cd)   as matrix_cd from M_MATRIX_TERM  a where a.week_date_end < CURDATE() +0  ";
		
		$db->query( $sql);
		
		if ( $row = $db->fetch() ){
			return $row["matrix_cd"] ;
		}
		
		return 0;
	}
	
	public static function get_years_array( $cell =TRUE ,$please_select = NULL){	
		$db = new Class_DB;
		
		$sql = " select a.year4 from M_MATRIX_TERM  a ";
		if ($cell){
			$sql = $sql. " INNER JOIN T_MON_CELL_WEEK b on a.matrix_cd = b.matrix_cd ";
		}
		 $sql = $sql. " group by a.year4 order by a.week_cd";
		$db->query( $sql);
		
		if ($please_select){
			$data[""] = $please_select;
		}
		
		while( $row = $db->fetch() ){
			$data[$row["year4"]] = $row["year4"];
		}
		
		return $data;
	}
	public static function get_week_flier_date($matrix_cd){	
		$db = new Class_DB;
		
		$sql = " select flier_date from M_MATRIX_TERM where matrix_cd = '{$matrix_cd}' ";
		$db->query( $sql);
		if ( $row = $db->fetch() ){
		return  $row["flier_date"];
			
		}
		return "0";
	}
	
	public static function get_weeks( $year4 = NULL ){	
		$db = new Class_DB;
		$sql = " select * from M_MATRIX_TERM ";
		if ($year4) {
			$sql = " select * from M_MATRIX_TERM where year4 = '{$year4}' ";
		}
		
		$db->query( $sql);
		while ( $row = $db->fetch() ){
			 $data[]  = $row;
		}
		return $data;
	}
	
	public static function get_local_news_array($please_select = NULL){
		$sql = "SELECT pattern_cd,pattern_name  FROM M_PATTERN  WHERE media_flg = 2 and  disp_ng = '0'   ";
		$db = new Class_DB;
		
		$db->query( $sql);
			
		if ($please_select){
			$data[""] = $please_select;
		}
		while( $row = $db->fetch() ){
			$data[$row["pattern_cd"]] = $row["pattern_name"];
		}
		
		return $data;
	}

	//媒体名
	public static function do_media($media, $dbb= NULL){
		$o_db = NULL;	
		
		if ( !empty($dbb)) {
			$o_db = $dbb;
		}else {
			$o_db = new Class_DB;
		}
	
		$sql =  sprintf(" SELECT * FROM M_MEDIA WHERE media_name =  '%s' ", $media);
		$o_db->query( $sql);
		
		if  ( $row = $o_db->fetch() ){
			return $row["media_cd"];
		}else {
			$loginuser = $_SESSION['ADMIN_LOGIN']['STAFF_SEQ'];
			$sql = sprintf(" INSERT INTO  M_MEDIA(media_name, c_time, c_user) values('%s', CURRENT_TIMESTAMP, '%s') ", $media, $loginuser);
					
			$o_db->query( $sql);
			return $o_db->last_id();
		}

	}
	
	//エリア名
	public static function do_area($area, $dbb= NULL){	
		$db = NULL;		
		if ( !empty($dbb)) {
			$db = $dbb;
		}else {
			$db = new Class_DB;
		}
		$sql =  sprintf(" SELECT * FROM M_AREA WHERE area_name =  '%s' ", $area);
		$db->query( $sql);
		
		if  ( $row = $db->fetch() ){
			return $row["area_cd"];
		}else {
			$loginuser = $_SESSION['ADMIN_LOGIN']['STAFF_SEQ'];
			$sql = sprintf(" INSERT INTO  M_AREA(area_name, c_time, c_user) values('%s', CURRENT_TIMESTAMP, '%s') ", $area, $loginuser);
					
			$db->query( $sql);
			return $db->last_id();
		}

	}
	//	配布エリア名
	public static function do_publish_area($publish_area, $dbb= NULL){	
		$db = NULL;		
		if ( !empty($dbb)) {
			$db = $dbb;
		}else {
			$db = new Class_DB;
		}
		
		$sql =  sprintf(" SELECT * FROM M_PUBLISH_AREA WHERE publish_area_name =  '%s' ", $publish_area);
		$db->query( $sql);
		
		if  ( $row = $db->fetch() ){
			return $row["publish_area_cd"];
		}else {
			$loginuser = $_SESSION['ADMIN_LOGIN']['STAFF_SEQ'];
			$sql = sprintf(" INSERT INTO  M_PUBLISH_AREA(publish_area_name, c_time, c_user) values('%s', CURRENT_TIMESTAMP, '%s') ", $publish_area, $loginuser);
					
			$db->query( $sql);
			return $db->last_id();
		}

	}	
	//取扱業者
	public static function do_hand($hand, $dbb= NULL){	
		$db = NULL;		
		if ( !empty($dbb)) {
			$db = $dbb;
		}else {
			$db = new Class_DB;
		}
		
		$sql =  sprintf(" SELECT * FROM M_HAND WHERE hand_name =  '%s' ", $hand);
		$db->query( $sql);
		
		if  ( $row = $db->fetch() ){
			return $row["hand_cd"];
		}else {
			$loginuser = $_SESSION['ADMIN_LOGIN']['STAFF_SEQ'];
			$sql = sprintf(" INSERT INTO  M_HAND(hand_name, c_time, c_user) values('%s', CURRENT_TIMESTAMP, '%s') ", $hand, $loginuser);
					
			$db->query( $sql);
			return $db->last_id();
		}

	}

	//取扱業者
	public static function do_dist($dist, $dbb= NULL){	
		$db = NULL;		
		if ( !empty($dbb)) {
			$db = $dbb;
		}else {
			$db = new Class_DB;
		}
		$sql =  sprintf(" SELECT * FROM M_DIST_AREA  WHERE dist_name =  '%s' ", $dist);
		$db->query( $sql);
		
		if  ( $row = $db->fetch() ){
			return $row["dist_id"];
		}else {
			$loginuser = $_SESSION['ADMIN_LOGIN']['STAFF_SEQ'];
			$sql = sprintf(" INSERT INTO  M_DIST_AREA(dist_name, c_time, c_user) values('%s', CURRENT_TIMESTAMP, '%s') ", $dist, $loginuser);
					
			$db->query( $sql);
			return $db->last_id();
		}
	}
	public static function get_dist_id($dist){
		$db = new Class_DB;
		$sql =  sprintf(" SELECT * FROM M_DIST_AREA  WHERE dist_name =  '%s' ", $dist);
		$db->query( $sql);
		if  ( $row = $db->fetch() ){
			return $row["dist_id"];
		}else {
			return false;
		}
			
	}
	
	//納品先
	public static function do_delive($delive, $dbb= NULL){	
	$db = NULL;		
		if ( !empty($dbb)) {
			$db = $dbb;
		}else {
			$db = new Class_DB;
		}
		
		$sql =  sprintf(" SELECT * FROM M_DELIVE WHERE delive_name =  '%s' ", $delive);
		$db->query( $sql);
		
		if  ( $row = $db->fetch() ){
			return $row["delive_cd"];
		}else {
			$loginuser = $_SESSION['ADMIN_LOGIN']['STAFF_SEQ'];
			$sql = sprintf(" INSERT INTO  M_DELIVE(delive_name, c_time, c_user) values('%s', CURRENT_TIMESTAMP, '%s') ", $delive, $loginuser);
					
			$db->query( $sql);
			return $db->last_id();
		}
	}
	/*
	//ゾーン
	public static function do_zone($zone, $dbb= NULL){	
	$db = NULL;		
		if ( !empty($dbb)) {
			$db = $dbb;
		}else {
			$db = new Class_DB;
		}
		
		$sql =  sprintf(" SELECT * FROM M_ZONE WHERE zone_name =  '%s' ", $zone);
		$db->query( $sql);
		
		if  ( $row = $db->fetch() ){
			return $row["zone_cd"];
		}else {
			$loginuser = $_SESSION['ADMIN_LOGIN']['STAFF_SEQ'];
			$sql = sprintf(" INSERT INTO  M_zone(zone_name, c_time, c_user) values('%s', CURRENT_TIMESTAMP, '%s') ", $zone, $loginuser);
					
			$db->query( $sql);
			return $db->last_id();
		}
	}
	*/
	//店舗検索
	public static function get_shop( $val, &$page = NULL ){	
		$db = new Class_DB;
		$where = "";
		$innerjoin = "";
		//$login['staff_auth'] 
		session_name( 'AOKI_ADMIN' );
		session_start();
		$login_auth = $_SESSION['ADMIN_LOGIN']['STAFF_AUTH'];
		if ($login_auth['staff_auth'] == 'G-2' || $login_auth['staff_auth']  == 'G-3') {
			$aja_cd = $_SESSION['ADMIN_LOGIN']['STAFF_SEQ'];
			$innerjoin = " INNER JOIN M_AJAREKS b on a.shop_cd = b.shop_cd  AND b.userid = '{$aja_cd}'";
		}
		
		$sql =  " SELECT *  FROM M_SHOP a ";
		if ($val) {
			$where = "WHERE (a.shop_cd LIKE '%{$val}%' OR a.shop_name LIKE  '%{$val}%' OR a.block_name LIKE  '%{$val}%' OR a.local_name LIKE  '%{$val}%') ";
		}
		
		
		
		$sql =  $sql.$innerjoin.$where;
		$sql =  $sql." ORDER BY  a.shop_cd ";
		$limit = "";
		if ($page) {
			$cnt_sql =  " SELECT count(*) as cnt FROM M_SHOP a ".$innerjoin.$where ;
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
		}
		
		$db->query( $sql );		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return $data;
	}
	
//ゾーン
	public static function do_zone($zone, $dbb= NULL){	
	$db = NULL;		
		if ( !empty($dbb)) {
			$db = $dbb;
		}else {
			$db = new Class_DB;
		}
		
		$sql =  sprintf(" SELECT * FROM M_ZONE WHERE zone_name =  '%s' ", $zone);
		$db->query( $sql);
		
		if  ( $row = $db->fetch() ){
			return $row["zone_cd"];
		}else {
			$loginuser = $_SESSION['ADMIN_LOGIN']['STAFF_SEQ'];
			$sql = sprintf(" INSERT INTO  M_zone(zone_name, c_time, c_user) values('%s', CURRENT_TIMESTAMP, '%s') ", $zone, $loginuser);
					
			$db->query( $sql);
			return $db->last_id();
		}
	}

	//店舗検索
	public static function get_shopdnpwp( $w,$p, $val, $area=NULL , $zone = NULL, &$page = NULL ){	
		$db = new Class_DB;
		$where = "";
		$innerjoin = "";
		//$login['staff_auth'] 
		session_name( 'AOKI_ADMIN' );
		session_start();
		$login_auth = $_SESSION['ADMIN_LOGIN']['STAFF_AUTH'];
		if ($login_auth['staff_auth'] == 'G-2' || $login_auth['staff_auth']  == 'G-3') {
			$aja_cd = $_SESSION['ADMIN_LOGIN']['STAFF_SEQ'];
			$innerjoin = " INNER JOIN M_AJAREKS b on a.shop_cd = b.shop_cd  AND b.userid = '{$aja_cd}'";
		} 
		
		$sql =  " SELECT a.*,b.area,b.zone,c.shop_nums,c.ins_count  FROM M_SHOP a  " .
			" INNER JOIN  (select b.shop_cd, max(case u.auth when '2' then u.user_name else null end) as area ,  
			max(case u.auth when '3' then u.user_name else null end) as zone from M_AJAREKS b 
			inner join M_LOGIN u on b.userid = u.id group by b.shop_cd order by b.shop_cd) b  on a.shop_cd = b.shop_cd   " .
			" inner join  (select shop_cd, count(*) as ins_count,sum(area_adnums)  as shop_nums from  M_INS_SHOP_SHOP{$w} " .
			"where  area_pattern_cd = {$p} and area_disp_ng ='0'  group by shop_cd )  " .
			" c on a.shop_cd = c.shop_cd  ";
		if ($val) {
			$where = "WHERE (a.shop_cd LIKE '%{$val}%' OR a.shop_name LIKE  '%{$val}%' OR a.block_name LIKE  '%{$val}%' OR a.local_name LIKE  '%{$val}%') ";
		}
		
		$sql =  $sql.$innerjoin.$where;
		$sql =  $sql." ORDER BY  a.shop_cd ";
		$limit = "";
		if ($page) {
			$cnt_sql =  " SELECT count(*) as cnt FROM M_SHOP a ".$innerjoin.$where ;
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
		}
		
		$db->query( $sql );		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return $data;
	}
	//サービス検索
	public static function get_service( $val, &$page = NULL ){	
		$db = new Class_DB;

			
		$where = "";
		if ($val) {
			$where = "WHERE mservice_name LIKE  '%{$val}%' or mservice_cd LIKE  '%{$val}%'  ";
			$sql =  " SELECT *  FROM M_MAP_SERVICE  {$where} ORDER BY  mservice_cd ";
		} else {
			$sql =  " SELECT *  FROM M_MAP_SERVICE  ORDER BY  mservice_cd ";
		}
		
		$limit = "";
		if ($page) {
			$cnt_sql =  " SELECT count(*) as cnt FROM M_MAP_SERVICE ".$where ;
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
		}
		
		$db->query( $sql );		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return $data;
	}
	//媒体名検索
	public static function get_media( $media, &$page = NULL ){	
		$db = new Class_DB;
		$where = "";
		if ($media) {
			$where = "WHERE media_name LIKE  '%{$media}%'";
			$sql =  " SELECT media_name as name , media_cd as cd  FROM M_MEDIA {$where} ORDER BY  media_name ";
		} else {
			$sql =  " SELECT media_name as name, media_cd as cd FROM M_MEDIA ORDER BY  media_name  ";
		}
		$limit = "";
		if ($page) {
			$cnt_sql =  " SELECT count(*) as cnt FROM M_MEDIA ".$where ;
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
		}
		$db->query( $sql );
		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return $data;
	}
		//エリア名検索
	public static function get_area( $area, &$page = NULL ){	
		$db = new Class_DB;
		$where = "";
		if ($area) {
			$where = "WHERE area_name LIKE  '%{$area}%'";
			$sql =  " SELECT area_name as name , area_cd as cd  FROM M_AREA {$where} ORDER BY  area_name ";
		} else {
			$sql =  " SELECT area_name as name, area_cd as cd FROM M_AREA ORDER BY  area_name  ";
		}
		$limit = "";
		if ($page) {
			$cnt_sql =  " SELECT count(*) as cnt FROM M_AREA ".$where ;
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
		}
		$db->query( $sql );
		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return $data;
	}
	
	//配布エリア名検索
	public static function get_publish_area( $publish_area, &$page = NULL ){	
		$db = new Class_DB;
		$where = "";
		if ($publish_area) {
			$where = "WHERE publish_area_name LIKE  '%{$publish_area}%'";
			$sql =  " SELECT publish_area_name as name , publish_area_cd as cd  FROM M_PUBLISH_AREA {$where} ORDER BY  publish_area_name ";
		} else {
			$sql =  " SELECT publish_area_name as name, publish_area_cd as cd FROM M_PUBLISH_AREA ORDER BY  publish_area_name  ";
		}
		$limit = "";
		if ($page) {
			$cnt_sql =  " SELECT count(*) as cnt FROM M_PUBLISH_AREA ".$where ;
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
		}
		$db->query( $sql );
		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return $data;
	}
	
	//取扱業者検索
	public static function get_hand( $hand, &$page = NULL ){	
		$db = new Class_DB;
		$where = "";
		if ($hand) {
			$where = "WHERE hand_name LIKE  '%{$hand}%'";
			$sql =  " SELECT hand_name as name , hand_cd as cd  FROM M_HAND {$where} ORDER BY  hand_name ";
		} else {
			$sql =  " SELECT hand_name as name, hand_cd as cd FROM M_HAND ORDER BY  hand_name  ";
		}
		$limit = "";
		if ($page) {
			$cnt_sql =  " SELECT count(*) as cnt FROM M_HAND ".$where ;
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
		}
		$db->query( $sql );
		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return $data;
	}
	//納品先検索
	public static function get_delive( $delive, &$page = NULL ){	
		$db = new Class_DB;
		$where = "";
		if ($delive) {
			$where = "WHERE delive_name LIKE  '%{$delive}%'";
			$sql = " SELECT delive_name as name , delive_cd as cd   FROM M_DELIVE {$where} ORDER BY  delive_name ";
		} else {
			$sql =  " SELECT delive_name as name, delive_cd as cd FROM M_DELIVE ORDER BY  delive_name ";
		}
		
		$limit = "";
		if ($page) {
			$cnt_sql =  " SELECT count(*) as cnt FROM M_DELIVE ".$where ;
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
		}
		
		$db->query( $sql );
		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return $data;
	}
	
	//パターン検索
	public static function get_pattern( $pattern, &$page = NULL ){	
		$db = new Class_DB;
		$where = "";
		if ($pattern) {
			$where = "WHERE pattern_name LIKE  '%{$pattern}%' and  disp_ng = '0'  ";
		} else {
			$where =  " WHERE disp_ng = '0' ";
		}
		$sql = " SELECT pattern_cd as cd ,pattern_name  as name  FROM M_PATTERN    {$where} ORDER BY  pattern_name ";
		$limit = "";
		if ($page) {
			
			$cnt_sql =  " SELECT count(*) as cnt FROM M_PATTERN ".$where ;
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
			
		}
		
		$db->query( $sql );
		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return $data;
	}
	//パターン検索
	public static function get_dist( $like, &$page = NULL ){	
		$db = new Class_DB;
		$where = "";
		if ($like) {
			$where = "WHERE dist_name LIKE  '%{$like}%'   ";
		}
		$sql = " SELECT dist_id as cd ,dist_name  as name  FROM M_DIST_AREA     {$where} ORDER BY  dist_name ";
		$limit = "";
		if ($page) {
			
			$cnt_sql =  " SELECT count(*) as cnt FROM M_DIST_AREA ".$where ;
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
			
		}
		
		$db->query( $sql );
		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return $data;
	}
	
	
	/*
	//ゾーン
	public static function get_zone( $zone, &$page = NULL ){	
		$db = new Class_DB;
		$where = "";
		if ($zone) {
			$where = "WHERE zone_name LIKE  '%{$zone}%'";
			$sql = " SELECT zone_name as name , zone_cd as cd   FROM M_ZONE {$where} ORDER BY  zone_name ";
		} else {
			$sql =  " SELECT zone_name as name, zone_cd as cd FROM M_ZONE ORDER BY  zone_name ";
		}
		
		$limit = "";
		if ($page) {
			$cnt_sql =  " SELECT count(*) as cnt FROM M_ZONE ".$where ;
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
		}
		
		$db->query( $sql );
		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return $data;
	}
	*/

	//販売店検索
	public static function get_ins_shop( $val, &$page = NULL ){	
		$db = new Class_DB;
		$selectfrom = "SELECT *,(select count(*) from M_INS_SHOP_SHOP where ins_shop_cd = a.ins_shop_cd ) as cnt  FROM M_INS_SHOP a ";
		$where = "";
		if ($val) {
			$where = "WHERE a.ins_shop_cd LIKE  '%{$val}%' OR a.ins_shop_name LIKE  '%{$val}%' OR a.media_name LIKE  '%{$val}%' OR a.local_name LIKE  '%{$val}%'";
			$sql   = $selectfrom."  {$where} ORDER BY  ins_shop_cd ";
		} else {
			$sql   =  $selectfrom." ORDER BY  ins_shop_cd ";
		}
		
		$limit = "";
		if ($page) {
			$cnt_sql =  " SELECT count(*) as cnt FROM M_INS_SHOP a ".$where ;
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
		}
		
		$db->query( $sql );
		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return  $data;
	}
	
//販売店検索
	public static function get_ins_shop_patt( $val, &$page = NULL ){	
		$db = new Class_DB;
		$selectfrom = "SELECT a.*,(select count(*) from M_INS_SHOP_SHOP where ins_shop_cd = a.ins_shop_cd ) as cnt FROM M_INS_SHOP a ";
		$where = "";
		if ($val) {
			$where = "WHERE a.ins_shop_cd LIKE  '%{$val}%' OR a.ins_shop_name LIKE  '%{$val}%' OR a.media_name LIKE  '%{$val}%' OR a.local_name LIKE  '%{$val}%'";
			$sql   = $selectfrom."  {$where} ORDER BY  ins_shop_cd ";
		} else {
			$sql   =  $selectfrom." ORDER BY  ins_shop_cd ";
		}
		
		
		$limit = "";
		if ($page) {
			$cnt_sql =  " SELECT count(*) as cnt FROM M_INS_SHOP a ".$where ;
			
			$db->query( $cnt_sql );
			$row   = $db->fetch();
			$page  = Class_M_OTHER::getSerachPages($page, $row['cnt']);
			$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			$sql   = $sql.$limit ;
		}
		
		$sql = "select a.*,b.pattern_name from ({$sql}) a " .
				" left join M_PATTERN b on b.pattern_cd = a.area_pattern_cd ";
		
		$db->query( $sql );
		//shop_cd
		
		$data = array();
		while( $row = $db->fetch() ){
			$data[] = $row;
		}
		return  $data;
	}
	//
	public static function get_delive_count( $week_cd ){
		$cnt_sql =  " SELECT count(*) as cnt FROM M_DELIVE where matrix_cd = {$week_cd} ";
		$db = new Class_DB;
		$db->query( $cnt_sql );
		$row   = $db->fetch();
		return  $row['cnt'];
	}	

	
	//	マトリック版スマスタ タイトル
	public static function get_titles( $matrix_cd,$pattern_cd  = NULL ){	
		

		$db  = new Class_DB;
		$sql = "SELECT id,groupid, verno, title, titlecell, color, sale_name, size, contractor, print, area_id, area, mano_out, mano_in, map" .
			" FROM M_MATRIX_VER a  WHERE   matrix_cd = {$matrix_cd} ";
			
		if (!empty($pattern_cd)) {
			$sql = $sql." AND pattern_cd = {$pattern_cd}";
			
		}
	
		$db->query( $sql );
		$data = array();
		while( $row = $db->fetch() ){
			$data[$row["id"]] = $row;
		}
		return  $data;
		
	}
	
	//$textflg TRUE テキストを返す、FALSE 配列を返す
	public static function get_shops( $ins_shop_cd ){	
		$db = new Class_DB;
		$sql  = "SELECT  a.shop_cd, a.shop_name  FROM M_SHOP a inner JOIN M_INS_SHOP_SHOP b on  a.shop_cd = b.shop_cd  where b.ins_shop_cd  = '{$ins_shop_cd}'";
		//echo $sql;
		$db->query( $sql );
		$data = array();
		
		while( $row = $db->fetch() ){
			$data[] = $row["shop_name"];
		}
		return implode(",",$data);
	}
	
	public static function getSerachPages( $page , $cnt ){
			$newpage = $page;
			$newpage['cnt'] = $cnt;
			$newpage['item'] = PAGE_MAX_SEARH;

			$newpage['end'] = floor( $newpage['cnt'] / $newpage['item'] );
			if( $newpage['cnt'] % $newpage['item'] ) $newpage['end']++;
			
			if ( ($newpage['end'] - $newpage['current'])  >= PAGEING_MAX_SEARH ) {
				for( $i = $newpage['current']; $i <=  $newpage['current']+ PAGEING_MAX_SEARH; $i++ ){
					$newpage['paging'][] = $i;
				}
			} else {
				$begin = $newpage['end'] - PAGEING_MAX_SEARH > 0 ? $newpage['end'] - PAGEING_MAX_SEARH : 1;
				
				for( $i = $begin; $i <= $newpage['end']; $i++ ){
					$newpage['paging'][] = $i;
				}
			}
			return $newpage;
		}
}

?>