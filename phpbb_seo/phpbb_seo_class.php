<?php
/** 
*
* @package Mixed phpBB SEO mod Rewrite
* @version $Id: phpbb_seo_class.php,v 1.0 2006/12/09 13:48:48 dcz Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://www.opensource.org/licenses/rpl.php RPL Public License 
*
*/

/**
* phpBB_SEO Class
* www.phpBB-SEO.com
* @package Mixed phpBB SEO mod Rewrite
*/
 
/***************************************************************************
 *
 * phpBB2 v2.0.23 Reload Version
 * @author KinG-InFeT
 * @project site http://salviamophpbb2.webnet32.com/
 *
 ***************************************************************************/
 
class phpbb_seo {
	var	$modrtype       = 0;
	var	$seo_url        = array();
	var	$seo_path       = array();
	var	$seo_delim      = array();
	var	$seo_ext        = array();
	var	$seo_static     = array();
	var	$seo_url_filter = array();
	var	$seo_stats      = array();
	var	$get_var        = array();
	var	$path           = "";
	var	$start          = "";
	var	$filename       = "";
	var	$file           = "";
	var	$url_in         = "";
	var	$url            = "";
	var	$page_url       = "";
	var	$seo_opt        = array();
	var	$encoding       = "iso-8859-1";
	
	/**
	* constuctor
	*/
	function phpbb_seo() {
		global $phpEx, $board_config;
		// config
		$this->encoding = "iso-8859-1";
		$this->modrtype =  1; // 1 = Simple
		$this->start = '';
		// --> DOMAIN SETTING <-- //
		// NOTE : If you add already declared a PHPBB_URL constant in common.php,
		// you should get rid of it and let this part do it instead.
		// You can hard-code the data to save process.
		$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
		$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
		$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
		// $this->seo_path['phpbb_script'] should be = '' if phpbb is installed in the domain's root
		// 'phpbb/' in case it's installed in the phpbb/ folder.
		$this->seo_path['phpbb_script'] = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
		$this->seo_path['phpbb_script'] = ($this->seo_path['phpbb_script'] == '') ? '' : $this->seo_path['phpbb_script'] . '/';
		// Domain URL 
		$this->seo_path['root_url'] = $server_protocol . $server_name . $server_port . '/';
		$this->seo_path['phpbb_url'] = $this->seo_path['root_url'] . $this->seo_path['phpbb_script'];
		// Populate the $seo_path['PathToUrl'] array for multifolder setups handling.
		// Pattern is $this->seo_path['PathToUrl']['phpbb/'] = "http://www.example.com/phpbb/";
		$this->seo_path['PathToUrl'][$this->seo_path['phpbb_script']] = $this->seo_path['phpbb_url'];
		// URL Settings
		$this->seo_url = array( 'cat' =>  array(), 
			'forum' =>  array(), 
			'topic' =>  array(), 
			'user'  => array(),
		);
		$this->seo_delim = array('cat' => '-c', 
			'forum' => '-f', 
			'topic' => '-t', 
			'user'  => '-u',
			// Rss
			'rss_forum' => '-rf',
			// Google
			'google_forum' => '-gf'
		);
		$this->seo_ext = array('cat' => '.html', 
			'forum'  => '.html', 
			'topic'  => '.html', 
			'user'   => '.html',
			'gz_ext' => '',
		);
		$this->seo_static = array('cat' => 'cat', 
			'forum'  => 'forum', 
			'topic'  => 'topic', 
			'post'   => 'post', 
			'user'   => 'member',
			'start'  => '-', 
			'gz_ext' => '.gz',
			//'index'  => ''
			'index'  => 'index.html'
		);
		
		if ($board_config['default_lang'] === 'french') {
			$this->seo_static['user'] = 'membre';
		}
		
		// URL Filters
		$this->phpbb_filter = array('postdays' => 0, 'topicdays' => 0, 'postorder' => 'asc', 'highlight' => '');
		
		// Stop files
		$this->seo_stop_files = array("posting", "privmsg", "faq", "groupcp", "memberlist", "login", "search");
		
		// Stop vars
		$this->seo_stop_vars = array("view=", "mark=");

		return;
	}

	// --> URL rewriting functions <--
	/**
	* Prepare Titles for URL injection
	*/
	function format_url( $url, $type = 'topic' ) {
		$url = preg_replace("`\[.*\]`U","",$url);
		$url = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$url);
		$url = htmlentities($url, ENT_COMPAT, $this->encoding);
		$url = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i","\\1", $url );
		$url = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $url);
		$url = ( $url == "" ) ? $type : strtolower(trim($url, '-'));
		
		return $url;
	}
	/**
	* Rewrite URLs.
	* Allow adding of many more cases than just the
	* regular phpBB URL rewritting without slowing up the process.
	*/
	function url_rewrite($url, $non_html_amp = FALSE) {
		global $phpEx;
		
		$this->url = $this->url_in = $url;
		
		if ( strpos($this->url, ".$phpEx") === FALSE || defined('IN_ADMIN') || defined('IN_LOGIN') ) {
			return $url;
		}
		
		// Grabb params
		$this->url = str_replace('&amp;', '&', $this->url);
		$parsed_url = @parse_url($this->url);
		parse_str($parsed_url['query'], $this->get_vars);
		$this->file = basename($parsed_url['path']);
		$this->path = trim(trim(dirname($parsed_url['path']), "."),  "/");
		$this->path = (!empty($this->path)) ? ( isset( $this->seo_path['PathToUrl'][$this->path . '/'] ) ? $this->seo_path['PathToUrl'][$this->path . '/'] : $this->path . '/' ) : '';
		$this->filename = trim(str_replace(".$phpEx", "", $this->file));
		
		if ( in_array($this->filename, $this->seo_stop_files) ) {
			return $url;
		}
		
		// Reset $url
		$this->url = $this->file;
		
		if ( @method_exists($this, $this->filename) ) {
			$this->{$this->filename}();
			// Assamble URL
			$this->url .= $this->query_string($this->get_vars);
			//$this->url = (!$non_html_amp) ? str_replace('&', '&amp;', $this->url) : $this->url;
			
			return $this->path . $this->url . ((!empty($parsed_url['fragment'])) ? "#" . $parsed_url['fragment'] : '');
		} else {
			return $url;
		}
	}
	/**
	* Set the $start var proper
	* @access private
	*/
	function seo_pagination() {
		$this->start = intval($this->get_vars['start']);
		$this->start = ( $this->start > 0  ) ? $this->seo_static['start'] . $this->get_vars['start'] : '';
		unset($this->get_vars['start']);
	}
	/**
	* URL rewritting for viewtopic.php
	* @access private
	*/
	/**
	* URL rewritting for viewtopic.php
	* @access private
	*/
	function viewtopic() {
		$this->filter_url($this->seo_stop_vars);
		
		if ( !empty($this->get_vars[POST_TOPIC_URL]) ) {
		
			// Filter default params
			$this->filter_get_var($this->phpbb_filter);
			$this->seo_pagination();
			$this->url = $this->seo_static['topic'] . $this->get_vars[POST_TOPIC_URL] . $this->start . $this->seo_ext['topic'];
			unset($this->get_vars[POST_TOPIC_URL]);
			
		} elseif ( !empty($this->get_vars[POST_POST_URL]) ) {
		
			$this->url =  $this->seo_static['post'] . $this->get_vars[POST_POST_URL] . $this->seo_ext['topic'];
			unset($this->get_vars[POST_POST_URL]);
			
		}
		
		return;
	}
	/**
	* URL rewritting for viewforum.php
	* @access private
	*/
	function viewforum() {
		$this->filter_url($this->seo_stop_vars);
		
		if ( !empty($this->get_vars[POST_FORUM_URL]) ) {
		
			// Filter default params
			$this->filter_get_var($this->phpbb_filter);
			$this->seo_pagination();
			$this->url = $this->seo_static['forum'] . $this->get_vars[POST_FORUM_URL] . $this->start . $this->seo_ext['forum'];
			unset($this->get_vars[POST_FORUM_URL]);
			
		}
		return;
	}
	/**
	* URL rewritting for profile.php
	* @access private
	*/
	function profile() {
		if ( !empty($this->get_vars[POST_USERS_URL]) && $this->get_vars['mode'] === 'viewprofile') {
		
			$this->url =  $this->seo_static['user'] . $this->get_vars[POST_USERS_URL] . $this->seo_ext['user'];
			unset($this->get_vars[POST_USERS_URL]);
			unset($this->get_vars['mode']);
			
		}
		
		return;
	}
	/**
	* URL rewritting for index.php
	* @access private
	*/
	function index() {
		if ( !empty($this->get_vars[POST_CAT_URL]) ) {
		
			$this->url = $this->seo_static['cat'] . $this->get_vars[POST_CAT_URL] . $this->seo_ext['cat'];
			unset($this->get_vars[POST_CAT_URL]);
		} else {
		
			$this->url = $this->seo_path['phpbb_url'] . $this->seo_static['index'];
		}
		return;
	}
	// --> Extra rewriting

	// <-- Extra rewriting
	/**
	* Will break if a $filter pattern is foundin $url.
	* Example $filter = array("view=", "mark=");
	* @access private
	*/
	function filter_url($filter = array()) {
		foreach ($filter as $patern ) {
		
			if ( strpos($this->url_in, $patern) !== FALSE ) {
			
				unset($this->get_vars);
				$this->url = $this->url_in;
				break;
			}
		}
		return;
	}
	/**
	* Will unset all default var stored in $filter array.
	* Example $filter = array('postdays' => 0, 'topicdays' => 0, 'postorder' => 'asc');
	* @access private
	*/
	function filter_get_var($filter = array()) {
		if ( !empty($this->get_vars) ) {
		
			foreach ($this->get_vars as $paramkey => $paramval) {
			
				if ( array_key_exists($paramkey, $filter) ) {
				
					if ( $filter[$paramkey] ==  $this->get_vars[$paramkey] ) {
					
						unset($this->get_vars[$paramkey]);
					}
				}
			}	
		}
		return;
	}
	/**
	* Will return the remaining GET vars to take care of
	* @access private
	*/
	function query_string() {
	
		if(empty($this->get_vars)) {
		
			return '';
		}
		$params = array();
		foreach($this->get_vars as $key => $value) {
		
			$params[] = $key . '=' . $value;
		}
		return '?' . implode('&', $params);
	}
	// --> Add on Functions <--
	// --> Gen stats
	/**
	* Returns usable microtime
	* Borrowed from php.net
	* Required for the phpBB SEO Google sitemaps module
	*/
	function microtime_float() {
		return array_sum(explode(' ',microtime()));
	}
}
?>
