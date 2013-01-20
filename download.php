<?php
 $wp_root = dirname(dirname(dirname(dirname(__FILE__))));
if(file_exists($wp_root . '/wp-load.php')) {
	require_once($wp_root . "/wp-load.php");
} else if(file_exists($wp_root . '/wp-config.php')) {
	require_once($wp_root . "/wp-config.php");
} else {
	exit;
}

@error_reporting(0);

if (headers_sent()) :
	@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
	wp_die(__('Headers Sent',"wp-download_monitor"), __('The headers have been sent by another plugin - there may be a plugin conflict.',"wp-download_monitor"));
endif;


switch( $file_extension )
{
						case "m4r": 	$ctype="audio/Ringtone"; 				break;
						case "gz": 		$ctype="application/x-gzip"; 			break;
						case "rar": 	$ctype="application/zip"; 				break;
						case "xls": 	$ctype="application/vnd.ms-excel";		break;
						case "djvu":	$ctype="image/x.djvu";					break;
						case "ez":		$ctype="application/andrew-inset";		break;
						case "hqx":		$ctype="application/mac-binhex40";		break;
						case "cpt":		$ctype="application/mac-compactpro";	break;
						case "doc":		$ctype="application/msword";			break;
						case "oda":		$ctype="application/oda";				break;
						case "pdf":		$ctype="application/pdf";				break;
						case "ai":		$ctype="application/postscript";		break;
						case "eps":		$ctype="application/postscript";		break;
						case "ps":		$ctype="application/postscript";		break;
						case "smi":		$ctype="application/smil";				break;
						case "smil":	$ctype="application/smil";				break;
						case "wbxml":	$ctype="application/vnd.wap.wbxml";		break;
						case "wmlc":	$ctype="application/vnd.wap.wmlc";		break;
						case "wmlsc":	$ctype="application/vnd.wap.wmlscriptc";break;
						case "bcpio":	$ctype="application/x-bcpio";			break;
						case "vcd":		$ctype="application/x-cdlink";			break;
						case "pgn":		$ctype="application/x-chess-pgn";		break;
						case "cpio":	$ctype="application/x-cpio";			break;
						case "csh":		$ctype="application/x-csh";				break;
						case "dcr":		$ctype="application/x-director";		break;
						case "dir":		$ctype="application/x-director";		break;
						case "dxr":		$ctype="application/x-director";		break;
						case "dvi":		$ctype="application/x-dvi";				break;
						case "spl":		$ctype="application/x-futuresplash";	break;
						case "gtar":	$ctype="application/x-gtar";			break;
						case "hdf":		$ctype="application/x-hdf";				break;
						case "js":		$ctype="application/x-javascript";		break;
						case "skp":		$ctype="application/x-koan";			break;
						case "skd":		$ctype="application/x-koan";			break;
						case "skt":		$ctype="application/x-koan";			break;
						case "skm":		$ctype="application/x-koan";			break;
						case "latex":	$ctype="application/x-latex";			break;
						case "nc":		$ctype="application/x-netcdf";			break;
						case "cdf":		$ctype="application/x-netcdf";			break;
						case "sh":		$ctype="application/x-sh";				break;
						case "shar":	$ctype="application/x-shar";			break;
						case "swf":		$ctype="application/x-shockwave-flash";	break;
						case "sit":		$ctype="application/x-stuffit";			break;
						case "sv4cpio":	$ctype="application/x-sv4cpio";			break;
						case "sv4crc":	$ctype="application/x-sv4crc";			break;
						case "tar":		$ctype="application/x-tar";				break;
						case "tcl":		$ctype="application/x-tcl";				break;
						case "tex":		$ctype="application/x-tex";				break;
						case "texinfo":	$ctype="application/x-texinfo";			break;
						case "texi":	$ctype="application/x-texinfo";			break;
						case "t":		$ctype="application/x-troff";			break;
						case "tr":		$ctype="application/x-troff";			break;
						case "roff":	$ctype="application/x-troff";			break;
						case "man":		$ctype="application/x-troff-man";		break;
						case "me":		$ctype="application/x-troff-me";		break;
						case "ms":		$ctype="application/x-troff-ms";		break;
						case "ustar":	$ctype="application/x-ustar";			break;
						case "src":		$ctype="application/x-wais-source";		break;
						case "au":		$ctype="audio/basic";					break;
						case "snd":		$ctype="audio/basic";					break;
						case "mid":		$ctype="audio/midi";					break;
						case "midi":	$ctype="audio/midi";					break;
						case "kar":		$ctype="audio/midi";					break;
						case "mpga":	$ctype="audio/mpeg";					break;
						case "mp2":		$ctype="audio/mpeg";					break;
						case "mp3":		$ctype="audio/mpeg";					break;
						case "aif":		$ctype="audio/x-aiff";					break;
						case "aiff":	$ctype="audio/x-aiff";					break;
						case "aifc":	$ctype="audio/x-aiff";					break;
						case "m3u":		$ctype="audio/x-mpegurl";				break;
						case "ram":		$ctype="audio/x-pn-realaudio";			break;
						case "rm":		$ctype="audio/x-pn-realaudio";			break;
						case "rpm":		$ctype="audio/x-pn-realaudio-plugin";	break;
						case "ra":		$ctype="audio/x-realaudio";				break;
						case "wav":		$ctype="audio/x-wav";					break;
						case "pdb":		$ctype="chemical/x-pdb";				break;
						case "xyz":		$ctype="chemical/x-xyz";				break;
						case "bmp":		$ctype="image/bmp";						break;
						case "gif":		$ctype="image/gif";						break;
						case "ief":		$ctype="image/ief";						break;
						case "jpeg":	$ctype="image/jpeg";					break;
						case "jpg":		$ctype="image/jpeg";					break;
						case "jpe":		$ctype="image/jpeg";					break;
						case "png":		$ctype="image/png";						break;
						case "tiff":	$ctype="image/tiff";					break;
						case "tif":		$ctype="image/tif";						break;
						case "djv":		$ctype="image/vnd.djvu";				break;
						case "wbmp":	$ctype="image/vnd.wap.wbmp";			break;
						case "ras":		$ctype="image/x-cmu-raster";			break;
						case "pnm":		$ctype="image/x-portable-anymap";		break;
						case "pbm":		$ctype="image/x-portable-bitmap";		break;
						case "pgm":		$ctype="image/x-portable-graymap";		break;
						case "ppm":		$ctype="image/x-portable-pixmap";		break;
						case "rgb":		$ctype="image/x-rgb";					break;
						case "xbm":		$ctype="image/x-xbitmap";				break;
						case "xpm":		$ctype="image/x-xpixmap";				break;
						case "xwd":		$ctype="image/x-windowdump";			break;
						case "igs":		$ctype="model/iges";					break;
						case "iges":	$ctype="model/iges";					break;
						case "msh":		$ctype="model/mesh";					break;
						case "mesh":	$ctype="model/mesh";					break;
						case "silo":	$ctype="model/mesh";					break;
						case "wrl":		$ctype="model/vrml";					break;
						case "vrml":	$ctype="model/vrml";					break;
						case "as":		$ctype="text/x-actionscript";			break;
						case "css":		$ctype="text/css";						break;
						case "asc":		$ctype="text/plain";					break;
						case "txt":		$ctype="text/plain";					break;
						case "rtx":		$ctype="text/richtext";					break;
						case "rtf":		$ctype="text/rtf";						break;
						case "sgml":	$ctype="text/sgml";						break;
						case "sgm":		$ctype="text/sgml";						break;
						case "tsv":		$ctype="text/tab-seperated-values";		break;
						case "wml":		$ctype="text/vnd.wap.wml";				break;
						case "wmls":	$ctype="text/vnd.wap.wmlscript";		break;
						case "etx":		$ctype="text/x-setext";					break;
						case "xml":		$ctype="text/xml";						break;
						case "xsl":		$ctype="text/xml";						break;
						case "mpeg":	$ctype="video/mpeg";					break;
						case "mpg":		$ctype="video/mpeg";					break;
						case "mpe":		$ctype="video/mpeg";					break;
						case "qt":		$ctype="video/quicktime";				break;
						case "mov":		$ctype="video/quicktime";				break;
						case "mxu":		$ctype="video/vnd.mpegurl";				break;
						case "avi":		$ctype="video/x-msvideo";				break;
						case "movie":	$ctype="video/x-sgi-movie";				break;
						case "ice":		$ctype="x-conference-xcooltalk" ;		break;
						case "jad":		$ctype="text/vnd.sun.j2me.app-descriptor" ;		break;
						case "cod":		$ctype="application/vnd.rim.cod" ;		break;
						case "mp4":		$ctype="video/mp4" ;					break;
						//The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files) - if you want to serve these types of files just zip then or give them another extension! This is mainly to protect users who don't know what they are doing :)
						case "php":
						case "htm":
						case "htaccess":
						case "sql":
						case "html":
							$thefile = str_replace(ABSPATH, get_bloginfo('wpurl'));
							$thefile = str_replace($_SERVER['DOCUMENT_ROOT'], get_bloginfo('url'));

							$location= 'Location: '.$thefile;
							header($location);
							exit;
						break;
						default: 		$ctype="application/octet-stream";
					}
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Robots: none");
header("Content-Type: ".$ctype."");
header("Content-Disposition: attachment; filename=name.type");
header("Content-Description: File Transfer");

@ini_set('zlib.output_compression', 'Off');
					@set_time_limit(0);
					@session_start();
					@session_cache_limiter('none');
					@set_magic_quotes_runtime(0);
