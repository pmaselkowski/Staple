<?php

namespace Maslosoft\Staple\Helpers;

use Maslosoft\Staple\Interfaces\ProcessorAwareInterface;
use Maslosoft\Staple\Interfaces\RendererAwareInterface;
use Maslosoft\Staple\Models\RequestItem;
use Maslosoft\Staple\Staple;
use UnexpectedValueException;

/**
 * AbstractWalker
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class AbstractWalker implements RendererAwareInterface,
		ProcessorAwareInterface
{

	/**
	 * Staple instance
	 * @var Staple
	 */
	protected $staple = null;

	/**
	 * Scanning path
	 * @var string
	 */
	protected $path = '';

	/**
	 * Base path, as set in constructor
	 * @var string
	 */
	protected $basePath = '';

	/**
	 * Path relative to base path
	 * @var string
	 */
	protected $relativePath = '';

	/**
	 * Root item instance
	 * @var RequestItem
	 */
	protected $item = null;

	public function __construct($path = '', Staple $staple = null)
	{
		if ($staple)
		{
			$this->staple = $staple;
		}
		else
		{
			$this->staple = Staple::fly();
		}
		if (empty($path))
		{
			$path = $this->staple->getContentPath(true);
		}
		$this->path = realpath(rtrim($path, '/\\'));
		if (empty($this->path))
		{
			throw new UnexpectedValueException("Path `$path` does not exists");
		}
		$this->basePath = $this->path;
		$this->item = new RequestItem;
	}

	public function getContentPath()
	{
		return $this->staple->getContentPath();
	}

	public function getLayoutPath()
	{
		return $this->staple->getLayoutPath();
	}

	public function getPostProcessors()
	{
		return $this->staple->getPostProcessors();
	}

	public function getPreProcessors()
	{
		return $this->staple->getPreProcessors();
	}

	public function getRenderer($filename)
	{
		return $this->staple->getRenderer($filename);
	}

	public function getRootPath()
	{
		return $this->staple->getRootPath();
	}

	public function setLayoutPath($layoutPath)
	{
		$this->staple->setLayoutPath($layoutPath);
	}

}
