<?php

namespace Bootstrap;

/**
 * @extends BootstrapModule
 */
class Html_Dropdown extends BootstrapModule {
	
	protected $items = array();
	
	protected $data = array('wrap' => array('tag' => 'div', 'attrs' => array()), 'text' => '');
	
	/**
	 * @access public
	 * @param string $text (default: '')
	 * @return void
	 */
	public function make($text = false)
	{
		if ($text !== false)
		{
			$this->data['text'] = $text;
		}
		return $this;
	}
	
	/**
	 * Register new items.
	 * 
	 * @access public
	 * @param mixed $href
	 * @param mixed $text
	 * @param array $attrs (default: array())
	 * @param bool $secure (default: false)
	 * @return void
	 */
	public function item($href, $text, $attrs = array(), $secure = false, $children = null)
	{
		$item = Html_Dropdown_Item::forge($attrs)->make($href, $text, $secure);
		
		$this->items[] = $item;

		if ( $children && $children instanceof Html_Dropdown_Item) {
			$item->nest( $children );
		}

		return $this;
		//return $item;
	}
	
	/**
	 * Set multiple items at same time.
	 * 
	 * @access public
	 * @return void
	 */
	public function items()
	{
		foreach (func_get_args() as $args)
		{
			call_user_func_array(array($this, 'item'), $args);
		}
		return $this;
	}

	/**
	 * set a divider.
	 * 
	 * @access public
	 * @return void
	 */
	public function divider($attrs = array())
	{
		$this->manager->classesToAttr($attrs, array('divider'));
		
		$this->items[] = html_tag('li', $attrs, '');
		
		return $this;
	}
	
	/**
	 * Create an header separator.
	 * 
	 * @access public
	 * @return void
	 */
	public function header($text, $attrs = array())
	{
		$this->manager->classesToAttr($attrs, array('nav-header'));
		
		$this->items[] = html_tag('li', $attrs, $text);
		
		return $this;
	}
	
	/**
	 * @access public
	 * @return void
	 */
	public function render()
	{
		$this->manager->addClass('dropdown-menu');
		
		foreach ($this->manager->attrs() as $key => $attr)
		{
			switch ($key)
			{
				case 'align':
				$this->manager->addClass('pull-'.$attr);
				break;
				
				case 'type':
				$this->data['wrap']['attrs']['class'] = 'drop'.$attr;
				break;
				
				case 'container':
				$this->data['wrap']['tag'] = $attr;
				break;
			}
		}
		
		$this->html('ul', implode($this->items));
		
		if ($this->data['text'])
		{
			$this->wrap();
		}
		
		return parent::render();
	}
	
	/**
	 * @access protected
	 * @param string $tag (default: 'span')
	 * @return void
	 */
	protected function caret()
	{
		return html_tag('span', array('class' => 'caret'), '');
	}
	
	/**
	 * generates javascript toggle attribues
	 * 
	 * @access protected
	 * @return void
	 */
	protected function toggle_attrs()
	{
		return array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown');
	}

	/**
	 * Wrap dropdown into specific tag.
	 * 
	 * @access public
	 * @return void
	 */
	protected function wrap()
	{
		extract($this->data);

		$html = \Html::anchor('#', $text.$this->caret(), $this->toggle_attrs()).$this->html;
		
		$this->manager->classesToAttr($wrap['attrs'], array('dropdown'));
		
		$this->html = html_tag($wrap['tag'], $wrap['attrs'], $html);
	}
	
}