<?php

class ffFileSystem extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	const FILE_SYSTEM_METHOD_DIRECT = 'direct';
	/**
	 *
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	private $_WPFileSystem = null;
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffWPLayer $WPLayer, $WPFileSystem ) {
		$this->_setWPLayer($WPLayer);
		$this->_setWPFileSystem($WPFileSystem);
	}
	
	public function fileModifiedTime( $path ) {
		return $this->_getWPFileSystem()->mtime( $path );
	}
	
	public function getAbsPath() {
		return $this->_getWPLayer()->get_absolute_path();
	}
	
	public function fileExists( $path ) {
		return file_exists( $path );
	}
	
	public function makeDir($path, $chmod = false, $chown = false, $chgrp = false) {
		return $this->_getWPFileSystem()->mkdir($path, $chmod, $chown, $chgrp );
	}
	
	public function makeDirRecursive( $path ) {
		$this->_getWPLayer()->wp_mkdir_p($path);
	}
	
	public function putContents( $file, $contents, $mode = false ) {
		return $this->_getWPFileSystem()->put_contents( $file, $contents, $mode );
	}
	
	public function getFileHashBasedOnPathAndTimeChange( $path ) {
		if( !$this->fileExists( $path ) ) {
			return false;
		}
		
		$timeLastChanged = $this->fileModifiedTime( $path );

		$stringToHash = $path . $timeLastChanged;
		
		$hashedString = md5( $stringToHash );
		
		return $hashedString;
	}
	
	public function putContentsGzip( $file, $contents ) {
		$gz = @gzopen( $file, "w9");
		if( $gz ){
			gzwrite($gz, $contents);
			gzclose($gz);
		}
	}
	
	public function canonicalizePath($address)
	{
		$address = explode('/', $address);
		$keys = array_keys($address, '..');
	
		foreach($keys AS $keypos => $key)
			array_splice($address, $key - ($keypos * 2 + 1), 2);
	
		$address = implode('/', $address);
		$address = str_replace('./', '', $address);
	
		return $address;
	}

	public function getRelativePath( $from, $to ){
		$from = $this->canonicalizePath( $from );
		$to   = $this->canonicalizePath( $to );

		$base = $from . 'aaaa';

		for( $i=0; $i<100; $i++ ){
			if( 0 === strpos($from, $base) ){
				if( 0 === strpos($to, $base) ){
					break;
				}
			}
			$base = dirname($base);
		}

		$base_len = strlen( $base );

		if( $base == dirname($to) ){
			$to = str_replace( dirname($to), '', $to);
			return '.'.$to;
		}

		$from = substr($from, $base_len);
		$to   = substr($to,   $base_len);

		$from_dir = dirname($from . 'aaa' );
		$to_dir   = dirname($to   . 'aaa' );

		$from_dir = str_replace('//', '/', $from_dir);
		$to_dir   = str_replace('//', '/', $to_dir);
		
		$dot_dot_count = substr_count( $from_dir, '/');
		
		return str_repeat('../', $dot_dot_count) . substr($to, 1);
	}

	public function isDir( $path ) {
		
		return $this->_getWPFileSystem()->is_dir( $path );
	}
	
	public function putContentsAtEndOfFile( $file, $contents, $mode = false ) {
		if( $this->_getWPFileSystem()->method == ffFileSystem::FILE_SYSTEM_METHOD_DIRECT ) {
			if ( ! ($fp = @fopen($file, 'a')) )
				return false;
			@fwrite($fp, $contents);
			@fclose($fp);
			$this->_getWPFileSystem()->chmod($file, $mode);
			return true;
		} else {
			//TODO made for other types
		}
	}
	
	public function getFileSystemMethod() {
		return $this->_getWPFileSystem()->method;
	}
	
	public function copy($source, $destination, $overwrite = false, $mode = false) {
		
		//function copy_dir($from, $to, $skip_list = array() ) {
		
		return $this->_getWPFileSystem()->copy( $source, $destination, $overwrite, $mode );
	}
	
	
	public function copyDir($from, $to, $skip_list = array() ) {
		return $this->_getWPLayer()->copy_dir( $from, $to, $skip_list );	
	}

	public function move($source, $destination, $overwrite = false) {		
		return $this->_getWPFileSystem()->move( $source, $destination, $overwrite );
	}
	
	public function getContents( $path ) {
		return $this->_getWPFileSystem()->get_contents( $path );
	}
	
	public function file( $path ) {
		return explode("\n", $this->getContents( $path ) );
	}
	
	public function delete( $path, $recursive = false, $type = false ) {
		$this->_getWPFileSystem()->delete( $path, $recursive, $type );
	}
	
	public function findFileFromUrl( $url ) {
		// TODO FOR WORDPRESS MU
		$homeUrl = $this->_getWPLayer()->get_home_url();
		$homePath = $this->_getWPLayer()->get_home_path();
		// TODO HTTPS!!!
		if( strpos($url, 'http://') === false ) {
			$url = $homeUrl . $url;
		}
		
		// http://localhost/wp/wp-content/uploads/something.jpg -> /wp-content/uploads/something.jpg
		$withoutBase = str_replace( $homeUrl,'', $url );
	
		$absolutePath = untrailingslashit( $homePath ) . $withoutBase;
		
		if( file_exists( $absolutePath ) ) {
			return $absolutePath;
		} else {
			return false;
		}
		
	}
	
	public function zipDir( $dir, $to, $basename = null) {
		$zipArchive = new ZipArchive();
		$zipArchive->open( $to, ZipArchive::CREATE );
		
		if( empty( $basename ) ){
			$dirItems = $this->dirlist( $dir );
			if( !empty($dirItems) ){
				foreach ( $dirItems as $oneItem ) {
					if( $oneItem['type'] == 'd' ){
						$this->_addFolderToZip( $dir. '/'.$oneItem['name'], $zipArchive, $oneItem['name'] );
					} else {
						$zipArchive->addFile( $dir . '/'. $oneItem['name'], $oneItem['name']);
					}
				} 
			}
		}else{
			$this->_addFolderToZip($dir, $zipArchive, $basename);
		}
		
		$zipArchive->close();
	}
	
	private function _getRelativeDirPath( $dirPath, $fileName ) {
		if( $dirPath == null ) return $filename;
		else return $dirPath .'/'.$fileName;
	}
	private function _addFolderToZip($baseDir, $zipArchive, $otherDirs = null){
		$baseDirList = $this->dirlist( $baseDir );
		if( empty( $baseDirList ) ) {
			return null;
		}
		foreach ($baseDirList as $oneItem ) {
			//if( $oneItem['name'] == '.git' || $oneItem['name'] == '.settings') continue;
			if( $oneItem['type'] == 'd' ){
				
				$this->_addFolderToZip( $baseDir. '/'.$oneItem['name'], $zipArchive, $otherDirs.'/'.$oneItem['name'] );
			} else {
				
				$zipArchive->addFile( $baseDir . '/'. $oneItem['name'], $this->_getRelativeDirPath($otherDirs, $oneItem['name']));
			}
		} 
	}
	
	
	public function unzipFile( $file, $to ) {
		return unzip_file($file, $to);
	}
	
	public function touch( $path ) {
		return touch( $path );
	}
	
	public function dirlist($path, $includeHidden = true, $recursive = false) {
		return $this->_getWPFileSystem()->dirlist( $path, $includeHidden, $recursive);
	}
	
	public function getDirPlugins() {
		return WP_PLUGIN_DIR;
	}
	
	public function getDirUpgrade() {
		return WP_CONTENT_DIR .'/upgrade';
	}
	
	public function getDirUpgradePluginsInfoDir() {
		return WP_CONTENT_DIR .'/upgrade-plugins-info/';
	}
	
	public function requireOnce( $path ) {
		require_once( $path );
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	
	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	/**
	 * @return unknown_type
	 */
	protected function _getWPFileSystem() {
		return $this->_WPFileSystem;
	}
	
	/**
	 * @param unknown_type $_WPFileSystem
	 */
	protected function _setWPFileSystem($WPFileSystem) {
		$this->_WPFileSystem = $WPFileSystem;
		return $this;
	}
	
	
}