<?php
/**
 * Examples Controller
 * Multiple examples of how you can use erdiko.  It includes some simple use cases.
 *
 * @category 	app
 * @package   	Example
 * @copyright	Copyright (c) 2014, Arroyo Labs, www.arroyolabs.com
 * @author 		John Arroyo, john@arroyolabs.com
 */
namespace app\controllers;

use Erdiko;
use erdiko\core\Config;

class Example extends \erdiko\core\Controller
{
	

	public function _before()
	{
		$this->setThemeName('bootstrap');
	}

	public function getHello()
	{
		$this->setTitle('Hello World');
		$this->setContent("Hello World");
	}

	public function get($var = null)
	{
		if($var != null)
		{
			// load action
			return $this->autoaction($var);
		}

		$m = new \Mustache_Engine;
		$test = $m->render('Hello, {{ planet }}!', array('planet' => 'world')); // Hello, world!

		// error_log("mustache = {$test}");
		// error_log("var: ".print_r($var, true));

		$data = array("hello", "world");
		$view = new \erdiko\core\View('examples/helloworld', $data);
		
		$this->setContent($view);
	}

	/**
	 * Homepage Action (index)
	 * @params array $arguments
	 */
	public function getIndex()
	{
		// Add page data
		$this->setTitle('Examples');
		$this->setView('examples/index');
	}

	public function getBaseline()
	{
		$this->setContent( "The simplest page possible" );
	}

	public function getFullpage()
	{
		$this->setThemeTemplate('fullpage');
		$this->setContent( "This is a fullpage layout (sans header/footer)" );
	}

	public function getSetview()
	{
		$this->setTitle('Example: Page with a single view');
		$this->setView('examples/setview');
	}

	public function getSetmultipleviews()
	{
		$this->setTitle('Example: Page with multiple views');

		// Include multiple views directly
		$content = $this->getView('examples/one');
		$content .= $this->getView('examples/two');
		$content .= $this->getView('examples/three');

		$this->setContent( $content );
	}

	public function getSetmultipleviewsAlt()
	{
		$this->setTitle('Example: Page with multiple views (alt)');

		// Add multiple views using api
		$this->addView('examples/one');
		$this->addView('examples/two');
		$this->addView('examples/three');
	}

	public function getSetview2()
	{
		// Include multiple views indirectly 
		$page = array(
			'content' => array(
				'view1' => $this->getView('examples/one'),
				'view2' => $this->getView('examples/two'),
				'view3' => $this->getView('examples/three')
				)
			);

		$this->setTitle('Example: Multiple views take 2');		
		$this->setView('examples/setview2', $page);
	}

	/**
	 * Slideshow Action 
	 * @params array $arguments
	 */
	public function getCarousel()
	{
		// Add page data
		$this->setTitle('Example: Carousel');
		$this->setView('examples/carousel');

		// Add Extra js
		$this->addJs('/themes/bootstrap/js/carousel.js');
	}

	public function getPhpinfo()
	{
		phpinfo();
		exit;
	}

	public function getMarkup()
	{
		/*
			This is an alternate way to add page content data
			You can load a view directly into the content.
			This is not the preferred way to add content.
			Use the setView() method when possible.
		*/
		$this->setTitle('Example Mark-Up');
		$this->setContent( $this->getView('examples/markup') );
	}

	public function getTwocolumn()
	{
		$this->setLayoutColumns(2);
		
		$right = $this->getView('examples/one');
		$right .= $this->getView('examples/two');
		$right .= $this->getView('examples/three');

		// Set columns directly using a layout
		$columns = array(
			'one' => array('content' => 'columns/default'),
			'two' => array('content' => $right)
			);
		
		$this->setTitle('Example: 2 Column Layout Page');
		$this->setContent( $this->getLayout('2-column', $columns) );
	}





	public function threecolumnAction()
	{
		$this->setLayoutColumns(3);
		
		$left = $this->getView(null, 'examples/one');
		$left .= $this->getView(null, 'examples/two');
		$left .= $this->getView(null, 'examples/three');

		// Set sidebars directly
		$sidebars = array(
			'left' => array('content' => $left),
			'right' => array(
				'content' => 'right sidebar',
				'view' => 'sidebars/default')
			);
		$this->setSidebars($sidebars);

		$this->setBodyContent( '3 column layout example' );

		$this->setTitle('3 Column Page');
		$this->setPageTitle( 'Example: Complex 3 Column' );
	}

	public function dataAction()
	{
		// Include multiple views indirectly (and page title)
		$page = array(
			'content' => array(
				'view1' => $this->getView(null, 'examples/one'),
				'view2' => $this->getView(null, 'examples/two'),
				'view3' => $this->getView(null, 'examples/three')
				),
			'title' => 'Example: Page with multiple views'
			);

		$this->setData($page);
		$this->setTitle('This is the title in the browser tab');		
		$this->setView('examples/setview2.php');
	}
}