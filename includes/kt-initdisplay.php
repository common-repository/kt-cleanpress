<?php 
if ( 'kt-initdisplay.php' == basename( $_SERVER['PHP_SELF'] ) )
	exit();

/**
 * Create list of tables to optimize
 * 
 * @param array $filterdterms
 * @return array
 */
function kt_croptdb_arr($filterdterms){
	$ktdbqarr = array();
	foreach ($filterdterms as $key => $value) {
		switch ($key){
			case 'clean-emptyt':
			case 'clean-emptyc':
				$ktdbqarr['term_taxonomy'] = 'term_taxonomy';
				break;				
			case 'clean-draft':
			case 'clean-trash':
			case 'clean-pending':	
				$ktdbqarr['posts'] = 'posts';
				$ktdbqarr['postmeta'] = 'postmeta';
				$ktdbqarr['comments'] = 'comments' ;
				$ktdbqarr['commentmeta'] = 'commentmeta';
				$ktdbqarr['term_relationships'] = 'term_relationships';
				return $ktdbqarr;
			case 'cleanp-draft':
			case 'cleanp-trash':
			case 'cleanp-pending':
				$ktdbqarr['posts'] = 'posts';
				$ktdbqarr['postmeta'] = 'postmeta';
				$ktdbqarr['comments'] = 'comments' ;
				$ktdbqarr['commentmeta'] = 'commentmeta';
				return $ktdbqarr;
			case 'clean-spam':
			case 'clean-unaproved':
			case 'clean-trashcomment':
				$ktdbqarr['comments'] = 'comments' ;
				$ktdbqarr['commentmeta'] = 'commentmeta';
				break;	
			case 'clean-navmenulock':
			case 'clean-autodraft':
				$ktdbqarr['posts'] = 'posts';
				$ktdbqarr['postmeta'] = 'postmeta';
				return $ktdbqarr;				
			case 'clean-revision':
				$ktdbqarr['posts'] = 'posts';
				return $ktdbqarr;
			default:
				return $ktdbqarr;
		}
	}
	return $ktdbqarr;
}

/**
 * Simplify the mysql querry by grouping similar queries into One
 * 
 * @param array $filterdterms
 * @return array 
 */
function kt_crquery_arr ($filterdterms) {
	$ktqueryarr = array();
	foreach ($filterdterms as $key => $value) {
		switch ($key){
			case 'clean-draft':
			case 'clean-trash':
			case 'clean-pending':
				if(!isset($ktqueryarr['post']))
					$ktqueryarr['post'] = "('" . $value . "'";
				else
					$ktqueryarr['post'] .= ",'" . $value . "'";
				break;
			case 'cleanp-draft':
			case 'cleanp-trash':
			case 'cleanp-pending':
				if(!isset($ktqueryarr['page']))
					$ktqueryarr['page'] = "('" . $value . "'";
				else
					$ktqueryarr['page'] .= ",'" .$value . "'";
				break;
			case 'clean-spam':
			case 'clean-unaproved':
			case 'clean-trashcomment':
				if(!isset($ktqueryarr['comment_options']))
					$ktqueryarr['comment_options'] = "('" . $value . "'";
				else
					$ktqueryarr['comment_options'] .= ",'" .$value . "'";
				break;
			default:
				$ktqueryarr[$key] = $value;
				break;
		}
	}
	return $ktqueryarr;
}


/**
 * Optimize Mysql Tables
 * 
 * @param array $tablearr
 */
function kt_optimize ($tablearr) {
	global $wpdb;
	foreach ($tablearr as $key => $value){
		$wpdb->query("OPTIMIZE TABLE " . $wpdb->prefix . $value);
	}

}


/**
 * Format The Size into human readable
 * 
 * @param int $size
 * @param int $precision
 * @return string
 */
function kt_format_bytes($size, $precision = 2){
	$base = log($size) / log(1024);
	$suffixes = array('b', 'k', 'M', 'G', 'T');
	$convert = round(pow(1024, $base - floor($base)), $precision);
	if (is_nan($convert)){
		return $size . 'b';
	}
	return  $convert. $suffixes[floor($base)];
}


/**
 * Process The mysql Queries To Clean And Optimize the tables
 * 
 * @return array
 */
function ktclean_process() {
	global $wpdb;
	$ktextime = microtime(true);
	$ktterms = 	array('clean-emptyc' => 'category' ,'clean-emptyt' => 'post_tag',
			'clean-draft' => 'draft' , 'clean-trash' => 'trash' , 'clean-pending' => 'pending',
			'cleanp-draft' => 'draft' , 'cleanp-trash' => 'trash' , 'cleanp-pending' => 'pending',
			'clean-spam' => 'spam', 'clean-unaproved' => '0' , 'clean-trashcomment' => 'trash' ,
			'clean-navmenulock' => 'nav_menu_item' ,
			 'clean-autodraft' => 'auto-draft','clean-revision' => 'revision' ,
			'clean-optimize' => 'optimize');
	
	$kttables = array('posts' => 'posts', 'postmeta' => 'postmeta', 'comments' => 'comments' ,
			'commentmeta' => 'commentmeta' , 'terms' => 'terms' , 'term_taxonomy' => 'term_taxonomy',
			'term_relationships' => 'term_relationships' , 'users' => 'users' , 'usermeta' => 'usermeta',
			'links' => 'links' , 'options' => 'options' );
	
	foreach ($ktterms as $key => $value) {
		if (!isset($_POST[$key])) {
			unset($ktterms[$key]);
		}
	}
	if (!empty($ktterms)){
	$ktsize['originalsize'] = (int) $wpdb->get_var("SELECT SUM(DATA_LENGTH) + SUM(INDEX_LENGTH) FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . constant("DB_NAME") . "' GROUP BY TABLE_SCHEMA;");
	$ktqueryarr = kt_crquery_arr($ktterms);
	foreach ($ktqueryarr as $key => $value) {
		switch ($key){
			case 'page':
			case 'post':
				$wpdb->query("DELETE t1 FROM $wpdb->posts AS t1, $wpdb->posts AS t2 WHERE t1.post_parent = t2.id AND t2.post_type = '$key' AND t2.post_status IN $value ) AND t1.post_type='revision';");
				$wpdb->query("UPDATE $wpdb->posts As t1, $wpdb->posts AS t2 set t1.post_parent = 0 WHERE t1.post_parent = t2.id AND t2.post_type = '$key' AND t2.post_status IN $value );");
				$wpdb->query("DELETE t1 FROM $wpdb->commentmeta AS t1 , $wpdb->comments AS t2 WHERE t1.comment_id = t2.comment_id AND t2.comment_post_id IN (SELECT id FROM $wpdb->posts where post_status IN $value ) AND post_type = '$key');");
				$wpdb->query("DELETE FROM t1 USING $wpdb->comments AS t1 , $wpdb->posts AS t2 WHERE t1.comment_post_id = t2.id AND t2.post_type = '$key' AND t2.post_status IN $value );");
				$wpdb->query("DELETE FROM t1 USING $wpdb->postmeta AS t1 , $wpdb->posts AS t2 WHERE t1.post_id = t2.id AND t2.post_type = '$key' AND t2.post_status IN $value );");
				if($key == 'post')
					$wpdb->query("DELETE t1 FROM $wpdb->term_relationships AS t1 , $wpdb->term_taxonomy AS t2 WHERE t1.term_taxonomy_id = t2.term_taxonomy_id AND t2.taxonomy IN ('category','post_tag') AND t1.object_id IN (SELECT id FROM $wpdb->posts where post_status IN $value ) AND post_type = '$key');");
				$wpdb->query("DELETE FROM $wpdb->posts WHERE post_type = '$key' AND post_status IN $value ) ;");
				break;
				
				
			case 'comment_options':
				$wpdb->query("UPDATE $wpdb->comments As t1,$wpdb->comments AS t2 SET t1.comment_parent = t2.comment_parent WHERE t1.comment_parent = t2.comment_id AND t2.comment_approved IN $value );");
				$wpdb->query("DELETE FROM t1 USING $wpdb->commentmeta AS t1, $wpdb->comments AS t2 WHERE t1.comment_id = t2.comment_id AND t2.comment_approved IN $value );");
				$wpdb->query("DELETE from $wpdb->comments WHERE  comment_approved IN $value );");
				break;
				
			case 'clean-revision':
				$wpdb->query("DELETE FROM $wpdb->posts WHERE post_type='$value';");
				break;
				
			case 'clean-autodraft':
				$wpdb->query("UPDATE $wpdb->posts As t1, $wpdb->posts AS t2 set t1.post_parent = 0 WHERE t1.post_parent = t2.id AND t2.post_type IN ('post','page') AND t2.post_status ='$value';");
				$wpdb->query("DELETE FROM t1 USING $wpdb->postmeta AS t1 , $wpdb->posts AS t2 WHERE t1.post_id = t2.id AND t2.post_type IN ('post','page') AND t2.post_status ='$value';");
				$wpdb->query("DELETE FROM $wpdb->posts WHERE post_status='$value';");
				break;
				
			case 'clean-navmenulock':
				$wpdb->query("DELETE FROM $wpdb->posts WHERE post_status='draft' AND post_type='$value';");
				$wpdb->query("DELETE FROM t1 USING $wpdb->postmeta AS t1, $wpdb->postmeta AS t2 WHERE t1.post_id = t2.post_id AND t2.meta_key = '_menu_item_orphaned';");
				$wpdb->query("DELETE from $wpdb->postmeta WHERE  meta_key='_edit_last' OR meta_key='_edit_lock';");
				break;
				
			case 'clean-emptyc':
				$wpdb->query("DELETE FROM t1,t2 USING $wpdb->term_taxonomy AS t1, $wpdb->terms AS t2 WHERE 	t1.term_id = t2.term_id AND t1.count = 0 AND t1.taxonomy = '$value' AND t2.slug NOT IN ('uncategorized','blogroll');");
				break;
			
			case 'clean-emptyt':
				$wpdb->query("DELETE FROM t1,t2 USING $wpdb->term_taxonomy AS t1, $wpdb->terms AS t2 WHERE 	t1.term_id = t2.term_id AND t1.count = 0 AND t1.taxonomy = '$value';");
				break;

			default:
				break;
		}
	}
	if (isset($ktterms['clean-optimize']))
		kt_optimize($kttables);
	else
		kt_optimize(kt_croptdb_arr($ktterms));
	$ktsize['finalsize'] = (int) $wpdb->get_var("SELECT SUM(DATA_LENGTH) + SUM(INDEX_LENGTH) FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . constant("DB_NAME") . "' GROUP BY TABLE_SCHEMA;");
	$ktsize['difference'] = $ktsize['originalsize'] - $ktsize['finalsize'];
	foreach ($ktsize as $key => $value)
			$ktsize[$key] = kt_format_bytes($value);
	}
	
	else 
		$ktsize['empty']='empty';

$ktextime -= microtime(true);
$ktsize['extime'] = number_format(abs($ktextime),3) . 's';
return $ktsize;
}

include ( plugin_dir_path(__FILE__) . 'kt-left-display-options.php' );	

?>


