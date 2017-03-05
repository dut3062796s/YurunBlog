<?php
return array(
	'SYSTEM_NAME'			=> 'YurunBlog',
	'SUB_TITLE'				=> '基于YurunPHP的开源博客系统',
	'HASH_DICT'				=> '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
	'VCODE_CHARSET'			=> 'adefkmprstuvwxyACDEFHKMPRTUVWXY2347',
	'VCODE_WIDTH'			=> 80,
	'VCODE_HEIGHT'			=> 30,
	'VCODE_FONT'			=> 'SF Slapstick Comic Bold Oblique.ttf',
	'SESSION_PREFIX'		=> 'yurunblog_',
	'INDEX_CACHE_TIME'		=> 1,
	'JS_CACHE_TIME'			=> 1,
	'EDITOR_TYPE'			=> 'ueditor',
	'THEME' 				=> 'Default',
	'THEME_ON'				=> true,
	'TITLES'		=>	array(
		'Index/index/first'	=>	'{SYSTEM_NAME} - {SUB_TITLE}',
		'Index/index'		=>	'全部文章 - 第{CurrPage}页 - {SYSTEM_NAME}',
		'Article/view'		=>	'{Article.Title} - {Article.CategoryName} - {SYSTEM_NAME}',
		'Article/list/first'=>	'{Category.Title} - {SYSTEM_NAME}',
		'Article/list'		=>	'{Category.Title} - 第{CurrPage}页 - {SYSTEM_NAME}',
		'Page/view'			=>	'{Page.Title} - {SYSTEM_NAME}',
		'Tag/view/first'	=>	'{Tag.Name} - 标签 - {SYSTEM_NAME}',
		'Tag/view'			=>	'{Tag.Name} - 标签 - 第{CurrPage}页 - {SYSTEM_NAME}',
	),
	'SEO_DESCRIPTION'		=>	array(
		'Index/index'		=>	'首页SEO描述',
		'Article/view'		=>	'{Article.Description}',
		'Article/list'		=>	'{Category.Description}',
		'Tag/view'			=>	'{Tag.Name}',
	),
	'SEO_KEYWORDS'			=>	array(
		'Index/index'		=>	'SEO关键词',
		'Article/view'		=>	'{Article.Keywords}',
		'Article/list'		=>	'{Category.Keywords}',
		'Tag/view'			=>	'{Tag.Name}',
	),
	'SHOW_NUMBER'	=>	array(
		'Home'			=>	10,
		'ArticleList'	=>	10,
	),
	'BLOG_KEY'				=>	'0cb041dbd6f889d6a0f132afc0d3272f',
	'DEFAULT_COMMENT_STATUS'=>	1,
	'CONTENT_SHOW_STATIC_COMMENTS'	=>	true,
	'URL_PROTOCOL'				=>	'//',
	'COMMENTS_SHOW'			=>	5,
);