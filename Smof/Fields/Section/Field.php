<?php

class Smof_Fields_Section_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => false
		),
		'inheritance' => 'children',
		'category' => ''
	);

	public $view;
	
	function obtainDefaultOptions(){
		return parent :: obtainDefaultOptions() + array(
			'default' => '',
			'depth' => false,
			'icon' => ''
		);
	}

	function __construct( $options , array $args ){
	
		parent :: __construct( $options, $args );

		$this -> view = $args[ 'view' ];

	
	}
	
	function assignData( $data ){
	
	}
	
	function initiateFields(){
	
		$this -> fields = $this -> getCreate() -> createFieldsFromOptions( $this -> options[ 'fields' ] );
	
	}
	
	function validateData(){
		
		$this -> data = $this -> getCreate() -> fieldsValidate( $this -> fields );
	}
	
	function obtainData(){
		return $this -> getCreate() -> fieldsSave( $this -> fields );
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
	
	function view(){
	
		$this -> args[ 'subframework' ] -> menuItem( array( 
			'id' => $this -> options[ 'id' ] ,
			'title' => $this -> options[ 'title' ],
			'icon' => $this -> options[ 'icon' ]
		) );
		?>
		<div class="smof-container-<?php echo $this -> options[ 'type' ] ?>" id="smof-container<?php echo $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ); ?>">
		<?php
		$this -> headingView();
		$this -> getCreate() -> fieldsView( $this -> fields );
		?>
		</div>
		<?php
	}
	

}

?>