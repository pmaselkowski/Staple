<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/staple
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @link http://maslosoft.com/staple/
 */

namespace Maslosoft\Staple\Widgets;

use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Helpers\SiteWalker;
use Maslosoft\Staple\Widgets\Vo\SubNavItem;

/**
 * SubNavRecursive
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SubNavRecursive extends SubNav
{

	public $items = [];

	/**
	 * Root path
	 * @var string
	 */
	public $root = '';

	/**
	 * Scan path
	 * @var string
	 */
	public $path = '';
	public $options = [
		'path' => '',
		'items' => ''
	];

	/**
	 * View
	 * @var MiniView
	 */
	public $mv = null;

	public function __construct($options = [])
	{
		if (!empty($options))
		{
			$this->options = array_merge($this->options, $options);
		}

		// Apply configuration
		EmbeDi::fly()->apply($this->options, $this);

		// Setup view
		$this->mv = new MiniView($this);
	}

	public function getItems()
	{
		$w = new SiteWalker($this->root);
		$w->start($this->path)->scan();

		$items = [];
		foreach ($this->items as $url => $title)
		{
			$items[] = new SubNavItem($url, $title, $this);
		}
		return array_merge($items, $w->get()->items);
	}

	public function __toString()
	{
		return $this->mv->render('sub-nav-recursive/nav', ['mv' => $this->mv], true);
	}

}
