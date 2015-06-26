<?php

namespace Smof\Fields\Section;
class Field extends \Smof\Fields\ParentContainer\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => false
		),
		'inheritance' => 'children',
		'category' => '',
		'custom' => false
	);

	public $view;
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => '',
			'depth' => false,
			'icon' => ''
		) );
	}

	function __construct( $options , array $args ){
	
		parent :: __construct( $options, $args );

		$this -> view = $args[ 'view' ];

	
	}
	
	protected function headingView(){
		?>
		<div class="smof-field-header">
			<?php
			if( !empty( $this -> options[ 'title' ] ) ){
				?>
				<h2><?php echo $this -> options[ 'title' ]; ?></h2>
				<?php
			}
			?>
		</div>
		<?php
	}
	
	public function controller(){
		
	$view = new Views\Main( $this -> obtainDefaultViewData() );
	
		$this -> args[ 'subframework' ] -> menuItem( array( 
			'id' => $this -> options[ 'id' ] ,
			'title' => $this -> options[ 'title' ],
			'icon' => $this -> options[ 'icon' ]
		) );
		
		$fields_views = array();
		
		foreach( $this -> fields as $field ){
			
			$fields_views[] = $this -> obtainOutput( array( $field , 'controller' ) ) ;
				
		}
		
		$view -> setData( 'fields' , $fields_views );
		
		$view -> view();
		

	}
	

}

?>