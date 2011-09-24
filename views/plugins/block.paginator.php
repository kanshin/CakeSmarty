<?php

class PaginatorBlock {
	protected $paginator;
	protected $model;
	
	const saved_vars = 'paginatorSaved';
	
	public function __construct($template) {
		$smarty = $template->smarty;
		
		$this->template = $template;
		$this->paginator = $smarty->viewHelper('paginator', 'paginator');
		$this->model = $smarty->fetchVar($params, 'model');
	}
	
	public function url($url = array()) {
		$url = array_merge(
			array('page' => $this->current(), 'model' => $this->model), 
			$url
		);
		
		$url = array_merge(
			Set::filter($url, true), 
			array_intersect_key($url, array('plugin' => true))
		);
		
		$model = $this->model;
		
		$options = $this->paginator->options;
		if (isset($options['url'])) {
			$url = array_merge((array)$options['url'], (array)$url);
		}
		
		return $this->paginator->url($url, false, $this->model);
	}
	
	public function current() {
		return $this->paginator->current($this->model);
	}
	
	public function varNames() {
		return array(
			'has_prev', 
			'has_next', 
			'page_count', 
			'count', 
			'limit', 
			'current', 
			'first_url',
			'prev_url',
			'next_url',
			'last_url',
		);
	}
	
	public function vars() {
		$paging = $this->paginator->params($this->model);
		
		$current = $this->current();
		
		$vars = array(
			'has_prev' => $paging['prevPage'], 
			'has_next' => $paging['nextPage'], 
			'page_count' => $paging['pageCount'], 
			'count' => $paging['count'], 
			'limit' => $paging['options']['limit'], 
			'current' => $current, 
			'first_url' => null,
			'prev_url' => null,
			'next_url' => null,
			'last_url' => null,
		);
		
		if ($vars['page_count'] == 0) {
			$vars['page_count'] = 1;
		}
		$vars['start'] = 0;
		if ($vars['count'] >= 1) {
			$vars['start'] = (($vars['current'] - 1) * $vars['limit']) + 1;
		}
		$vars['end'] = $vars['start'] + $vars['limit'] - 1;
		if ($vars['count'] < $vars['end']) {
			$vars['end'] = $vars['count'];
		}
		
		if ($vars['has_prev']) {
			$vars['first_url'] = $this->url(array('page' => 1));
			$vars['prev_url'] = $this->url(array('page' => $current - 1));
		}
		
		if ($vars['has_next']) {
			$vars['next_url'] = $this->url(array('page' => $current + 1));
			$vars['last_url'] = $this->url(array('page' => $vars['page_count']));
		}
		
		return $vars;
	}
	
	public function saveVars() {
		$t = $this->template;
		$vars = array();
		foreach ($this->varNames() as $key) {
			$vars[$key] = $t->getTemplateVars($key);
		}
		return $vars;
	}
	
	public function before() {
		$t = $this->template;
		
		$saved = $t->getTemplateVars(self::saved_vars);
		if (!$saved) {
			$saved = array();
		}
		$saved[] = $this->saveVars();
		
		$t->assign(self::saved_vars, $saved);
		$t->assign($this->vars());
	}
	
	public function after() {
		$t = $this->template;
		
		$saved = $t->getTemplateVars(self::saved_vars);
		
		if ($saved) {
			$t->assign(array_pop($saved));
		}
		
		$t->assign(self::saved_vars, $saved);
	}
}

function smarty_block_paginator($params, $content, $template, &$repeat) {
	$smarty = $template->smarty;
	
	$block = new PaginatorBlock($template);
	
	if (is_null($content)) {
		//変数を定義
		$block->before();
	} else {
		$block->after();
		
		$html = $smarty->viewHelper('paginator', 'html');
		
		$tag = $smarty->fetchVar($params, 'tag');
		if (empty($tag)) {
			$tag = 'div';
		}
		
		$smarty->fixHtmlAttributes($params);
		
		return $html->tag($tag, $content, $params);
	}
}

