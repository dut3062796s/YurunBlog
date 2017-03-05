<?php
class ArticleControl extends HomeBaseControl
{
	/**
	 * 浏览文章
	 * @param string $Alias 
	 */
	public function view($Alias)
	{
		$articleModel = new ArticleModel;
		$articleInfo = $articleModel->getByAlias($Alias);
		if(!isset($articleInfo['ID']))
		{
			Response::msg('文章不存在',null,404);
		}
		// 文章浏览量+1
		$articleModel->incView($articleInfo['ID']);
		++$articleInfo['View'];
		$this->parseHeadInfo(array(
			'Article'	=>	$articleInfo
		));
		$this->view->articleInfo = $articleInfo;
		$this->view->display('@theme/@module/@control/view/' . $articleInfo['Template']);
		Event::trigger('YB_ARTICLE_VIEW',array('article'=>$articleInfo));
	}
	/**
	 * 文章列表
	 * @param string $Alias 
	 */
	public function _R_list($Alias,$page = 1)
	{
		$categoryModel = new CategoryModel;
		$categoryInfo = $categoryModel->getByAlias($Alias);
		if(!isset($categoryInfo['ID']))
		{
			Response::msg('分类不存在',null,404);
		}
		$this->parseHeadInfo(array(
			'Category'	=>	$categoryInfo,
			'CurrPage'	=>	$page
		));
		$this->view->categoryInfo = $categoryInfo;
		$articleModel = new ArticleModel;
		$this->view->articleList = $articleModel->homeSelect()
												->orderByNew()
												->where(array($articleModel->tableName() . '.CategoryID'=>$categoryInfo['ID']))
												->selectList(array(),$page,Config::get('@.SHOW_NUMBER.ArticleList'),$totalPages);
		$this->view->totalPages = $totalPages;
		$this->view->currPage = $page;
		$this->view->display('@theme/@module/@control/list/' . $categoryInfo['CategoryTemplate']);
		Event::trigger('YB_ARTICLE_LIST_VIEW',array('category'=>$categoryInfo));
	}
}