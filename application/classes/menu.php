<?php

class Menu {

	public $items = array(); // Associative array of list items
	public $attrs = array(); // Associative array of attributes for list
	public $access = array(); // Array of access levels the user holds

	protected $current; // Current URI

	/**
	 * Creates and returns a new menu object
	 *
	 * @chainable
	 * @param   array   Array of list items (instead of using add() method)
	 * @return  Menu
	 */
	public static function forge( array $items = null ) {
		return new Menu($items);
	}

	/**
	 * Constructor, globally sets $items array
	 *
	 * @param   array   Array of list items (instead of using add() method)
	 * @return  void
	 */
	public function __construct( array $items = null ) {
		$this->items = $items;
		$this->current = trim( Uri::current() , '/' );
		//$this->current = trim( URL::site( Request::current()->uri() ), '/' );
	}

	public function attr( array $attrs = null ) {
		$this->attrs = Arr::merge( $this->attrs, $attrs );
	}

	/**
	 * Add's a new list item to the menu
	 *
	 * @chainable
	 * @param   string   Title of link
	 * @param   string   URL (address) of link
	 * @param   Menu     Instance of class that contain children
	 * @return  Menu
	 */
	public function add( $title, $url, $access = null, Menu $children = null, $ajax = true ) {
		$this->items[] = array
		(
			'title' => $title,
			'url' => $url,
			'access' => (is_array( $access )) ? $access : ($access ? array($access) : array()),
			'children' => ($children instanceof Menu) ? $children->items : null,
			'ajax' => $ajax,
			'raw' => true,
		);

		return $this;
	}

	public function roles( $roles ) {
		$this->access = (is_array( $roles ) ? $roles : array($roles));

		return $this;
	}

	/**
	 * Renders the HTML output for the menu
	 *
	 * @param   array   Associative array of html attributes
	 * @param   array   The parent item's array, only used internally
	 * @return  string  HTML unordered list
	 */
	public function render( array $attrs = null, array $items = null ) {
		static $i;

		$items = empty($items) ? $this->items : $items;
		$attrs = empty($attrs) ? $this->attrs : $attrs;
		var_dump( $items );

		$i++;

		/*if ( $i !== 1 ) {
			$attrs = array();
		}*/

		//$attrs['class'] = empty($attrs['class']) ? 'level-'.$i : $attrs['class'].' level-'.$i;
		$menu = '<ul' . Html::attributes( $attrs ) . '>';
		foreach ( $items as $key => $item ) {
			$access = false;
			// Are there access levels required for this Menu Item
			if ( !empty($item['access']) && is_array( $item['access'] )) {
				if ( !empty( $this->access )) {
					foreach ( $this->access as $role ) {
						if ( in_array( $role, $item['access'], true )) {
							$access = true;
						}
					}
				}
			}
			else {
				$access = true;
			}

			if ( $access ) {
				$has_children = isset($item['children']);
				$classes = null;
				$ajax = (isset($item['ajax']) && $item['ajax']) ? array('rel' => 'address:' . $item['url']) : null;

				if ( $has_children ) {
					$classes[] = 'parent';
				}

				if ( $active = $this->active( $item ) ) {
					$classes[] = $active;
				}

				if ( !empty($classes) ) {
					$classes = Html::attributes( array('class' => implode( ' ', $classes )) );
				}

				$menu .= '<li' . $classes . '>' . Html::anchor( $item['url'], $item['title'], $ajax );
				if ( $has_children ) {
					$menu .= $this->render( null, $item['children'] );
				}
				$menu .= '</li>';
			}
		}

		$menu .= '</ul>';
		$i--;

		return $menu;
	}

	/**
	 * Determines if the menu item is part of the current URI
	 *
	 * @param   array   The item to check against
	 * @return  mixed   Returns active class or null
	 */
	private function active( array $item ) {
		//$link = trim( URL::site( $item['url'] ), '/' );
		$link = trim( Uri::create( $item['url'] ), '/' );

		// Exact match (removes default 'index' action)
		if ( $this->current === $link OR preg_replace( '~/?index/?$~', '', $this->current ) === $link ) {
			return 'active current';
		}
		// Checks if it is part of the active path
		else {
			$current_pieces = explode( '/', $this->current );
			array_shift( $current_pieces );
			$link_pieces = explode( '/', $link );
			array_shift( $link_pieces );

			for ( $i = 0, $l = count( $link_pieces ); $i < $l; $i++ ) {
				if ( (isset($current_pieces[$i]) AND $current_pieces[$i] !== $link_pieces[$i]) OR empty($current_pieces[$i]) ) {
					return;
				}
			}

			return 'active';
		}
	}

	/**
	 * Renders the HTML output for menu without any attributes or active item
	 *
	 * @return   string
	 */
	public function __toString() {
		return $this->render();
	}

	/**
	 * Easily set list attributes
	 *
	 * @param   mixed   Value to set to
	 * @return  void
	 */
	public function __set( $key, $value ) {
		$this->attrs[$key] = $value;
	}

	/**
	 * Get a list attribute
	 *
	 * @return   mixed   Value of key
	 */
	public function __get( $key ) {
		if ( isset($this->attrs[$key]) ) {
			return $this->attrs[$key];
		}
	}
}