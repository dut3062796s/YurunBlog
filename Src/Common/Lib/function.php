<?php
/**
 * 检测后台验证码是否输入正确
 * @param unknown $vcode
 * @param string $clear	是否删除验证码Session
 * @return boolean
 */
function checkAdminVcode($vcode,$clear = true)
{
	$result = strcasecmp(Session::get('@.USER_VCODE',uniqid()),$vcode);
	if($clear)
	{
		Session::delete('@.USER_VCODE');
	}
	return 0 === $result;
}
/**
 * 检查是否为空字符串或为null
 * @param type $var
 * @return type
 */
function isEmpty(&$var)
{
	return !isset($var) || '' === $var || null === $var;
}
/**
 * 获取URL地址根目录
 * @param type $url
 */
function getUrlRoot($url)
{
	if(preg_match_all('/(https?:\/\/.*?)\//i', $url . '/',$matches) > 0)
	{
		return $matches[1][0];
	}
	else
	{
		return '';
	}
}
/**
 * 获取URL地址当前目录
 */
function getUrlCurrPath($url)
{
	if(substr_count($url,'/') > 2)
	{
		return dirname($url . 'a') . '/';
	}
	else
	{
		return $url . '/';
	}
}
/**
 * 获取链接绝对地址
 * @param type $originUrl
 * @param type $link
 */
function parseHtmlLink($originUrl,$link)
{
	if(substr($link,0,7) === 'http://' || substr($link,0,8) === 'https://')
	{
		return $link;
	}
	else if($link[0] === '/')
	{
		return getUrlRoot($originUrl) . $link;
	}
	else
	{
		return getUrlCurrPath($originUrl) . $link;
	}
}
function getImageType($file)
{
	static $imageTypeArray = array(
		0 => 'UNKNOWN',
		1 => 'GIF',
		2 => 'JPG',
		3 => 'PNG',
		4 => 'SWF',
		5 => 'PSD',
		6 => 'BMP',
		7 => 'TIFF_II',
		8 => 'TIFF_MM',
		9 => 'JPC',
		10 => 'JP2',
		11 => 'JPX',
		12 => 'JB2',
		13 => 'SWC',
		14 => 'IFF',
		15 => 'WBMP',
		16 => 'XBM',
		17 => 'ICO',
		18 => 'COUNT'
	);
	$size = getimagesize($file);
    return $imageTypeArray[$size[2]];
}
/**
 * 根据键名从另一个数组获取数据
 * @param type $data
 * @param type $keys
 * @return type
 */
function getDataByKeys($data,$keys)
{
	$result = array();
	foreach($keys as $key)
	{
		$result[$key] = $data[$key];
	}
	return $result;
}
function getYearMonthDays($year = null)
{
	if(null === $year)
	{
		$year = date('Y');
	}
	return array(
		1 => 31,
		2 => 28 + date('L',strtotime("{$year}-1-1")),
		3 => 31,
		4 => 30,
		5 => 31,
		6 => 30,
		7 => 31,
		8 => 31,
		9 => 30,
		10 => 31,
		11 => 30,
		12 => 31
	);
}
/**
 * 获取某年日历
 */
function getYearCalendar($year = null)
{
	if(null === $year)
	{
		$year = date('Y');
	}
	$week = date('N',strtotime("{$year}-1-1"));
	$days = getYearMonthDays($year);
	$calendar = array();
	for($month=1;$month<=12;++$month)
	{
		$calendar[$month] = array(array());
		$rowIndex = 0;
		for($colIndex = 1;$colIndex < $week;++$colIndex)
		{
			$calendar[$month][$rowIndex][] = '';
		}
		for($day=1;$day<=$days[$month];++$day)
		{
			$calendar[$month][$rowIndex][] = $day;
			++$week;
			if($week > 7)
			{
				$week = 1;
				++$rowIndex;
			}
		}
		if(count($calendar[$month]) < 6)
		{
			$calendar[$month][] = array(0,0,0,0,0,0,0);
		}
	}
	return $calendar;
}
/**
 * 根据长度生成hash
 * @param string $length
 * @return Ambigous <string, mixed>
 */
function createHash($length = null)
{
	// 确定生成长度
	if(null === $length)
	{
		$length = mt_rand(Config::get('@.HASH_MIN'),Config::get('@.HASH_MAX'));
	}
	// hash字典
	$dict = Config::get('@.HASH_DICT');
	$dictLen = strlen($dict) - 1;
	// 生成hash
	$hash = '';
	for($i = 0; $i < $length; ++$i)
	{
		$hash .= $dict[mt_rand(0,$dictLen)];
	}
	return $hash;
}
function isMobile()
{
	return preg_match('/android|os x/i',$_SERVER['HTTP_USER_AGENT']) > 0;
}

/**
 * 分类模版
 */
function &getCategoryTemplates()
{
	$result = array();
	enumFiles(APP_TEMPLATE . Config::get('@.THEME') . '/Home/Article/list'
		,function($file) use(&$result){
			$arr = explode('.',basename($file));
			array_pop($arr);
			$result[] = implode('.',$arr);
		}
	);
	return $result;
}
/**
 * 文章模版
 */
function &getArticleTemplates()
{
	$result = array();
	enumFiles(APP_TEMPLATE . Config::get('@.THEME') . '/Home/Article/view'
		,function($file) use(&$result){
			$arr = explode('.',basename($file));
			array_pop($arr);
			$result[] = implode('.',$arr);
		}
	);
	return $result;
}
/**
 * 页面模版
 */
function &getPageTemplates()
{
	$result = array();
	enumFiles(APP_TEMPLATE . Config::get('@.THEME') . '/Home/Page/view'
		,function($file) use(&$result){
			$arr = explode('.',basename($file));
			array_pop($arr);
			$result[] = implode('.',$arr);
		}
	);
	return $result;
}
/**
 * 获取YurunBlog自定义规则的文本结果
 * @param string $rule 
 * @param array $params 
 * @return string 
 */
function getRuleResult($rule,$params = array())
{
	return preg_replace_callback(
					'/{([^}]+)}/',
					function($matches)use($params){
						$names = explode('.',$matches[1]);
						$data = &$params;
						foreach($names as $item)
						{
							if(!isset($data[$item]))
							{
								$data = null;
								break;
							}
							else
							{
								$data = &$data[$item];
							}
						}
						if(null === $data)
						{
							return Config::get('@.' . $matches[1],'');
						}
						else
						{
							return $data;
						}
					},
					$rule);
}
/**
 * 获取评论哈希值
 * @param id $contentID 
 * @return string 
 */
function getCommentHash($contentID)
{
	$key = Session::get('@.COMMENT_KEY');
	if(false === $key)
	{
		$key = uniqid('',true);
		Session::set('@.COMMENT_KEY',$key);
	}
	return sha1(md5($contentID) . $key . md5(Config::get('@.BLOG_KEY',mt_rand())));
}
// 兼容PHP < 5.5
if(!function_exists('array_column'))
{
    function array_column($array,$column_name)
    {
        return array_map(function($element) use($column_name){return $element[$column_name];}, $array);
    }
}
/**
 * 处理html换行，把\r\n替换为<br/>
 * @param mixed $str 
 * @return mixed 
 */
function parseHtmlLine($str)
{
	return str_replace("\r\n",'<br/>',$str);
}
/**
 * 处理标签的Code，替换关键符号
 * @param string $code 
 * @return string 
 */
function parseTagCode($code)
{
	return str_replace(
		array(
			'=',
			'%',
			'&',
			'?',
			'/',
			'#'
		),
		array(
			'Equal',
			'Percent',
			'And',
			'QuestionMark',
			'Slash',
			'Sharp'
		),
		$code
	);
}