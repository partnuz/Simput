<?php

class Smof_Subframeworks_Options_Views_Main{

	public $subframework;
	public $framework;
	public $content;
	public $menu;

	function __construct( $framework , $subframework ){
	
		$this -> subframework = $subframework;
		$this -> framework = $framework;
		
	}
	
	function menuItemView( $item ){
	
		ob_start();
		?>
		<li id="<?php echo $item[ 'id' ]; ?>"><?php echo $item[ 'title' ]; ?></li>
		<?php
		
		$menu_item_ob = ob_get_contents();
		ob_end_clean();
		
		$this -> menu .= $menu_item_ob;
	}
	
	public function saveButtonView(){
		?>
		<button id ="of_save" type="submit" name="smof[action]" value="save" class="button-primary"><?php _e('Save All Changes');?></button>
		<?php
	}
	
	function view(){
	
	?>
	
	<div class="wrap" id="of_container">

		<div id="of-popup-save" class="of-save-popup">
			<div class="of-save-save">Options Updated</div>
		</div>
		
		<div id="of-popup-reset" class="of-save-popup">
			<div class="of-save-reset">Options Reset</div>
		</div>
		
		<div id="of-popup-fail" class="of-save-popup">
			<div class="of-save-fail">Error!</div>
		</div>
		
		<span style="display: none;" id="hooks"><?php /* echo json_encode(of_get_header_classes_array()); */ ?></span>
		<input type="hidden" id="reset" value="<?php if(isset($_REQUEST['reset'])) echo $_REQUEST['reset']; ?>" />
		<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('of_ajax_nonce'); ?>" />

		<form id="of_form" method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data" >
		
			<div id="header">
			
				<div class="logo">
					<h2><?php echo $this -> subframework -> args[ 'framework' ] -> getThemeData( 'name' ); ?></h2>
					<span><?php echo ('v'. $this -> subframework -> args[ 'framework' ] -> getThemeData( 'version' ) ); ?></span>
				</div>
			
				<div id="js-warning">Warning- This options panel will not work properly without javascript!</div>
				<div class="icon-option"></div>
				<div class="clear"></div>
			
			</div>

			<div id="info_bar">
			
				<a>
					<div id="expand_options" class="expand">Expand</div>
				</a>
							
				<img style="display:none" src="<?php /* echo ADMIN_DIR; */ ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />

				<?php $this -> saveButtonView(); ?>
				
			</div><!--.info_bar--> 	
			
			<div id="main">
			
				<div id="of-nav">
					<ul>
						<?php 
						foreach( $this -> menu as $menu_item){
							?>
							<li id="<?php echo $menu_item[ 'id' ]; ?>"><a href="#smof-container-<?php echo $menu_item[ 'id' ]; ?>"><?php if( !empty( $menu_item[ 'icon' ]) ){ ?><span class="<?php echo $menu_item[ 'icon' ]; ?>"></span><?php } ?><?php echo $menu_item[ 'title' ]; ?></a></li>
							<?php
						}
						?>
					</ul>
				</div>

				<div id="content">
					<?php echo $this -> content; /* Settings */ ?>
				</div>
				
				<div class="clear"></div>
				
			</div>
			
			<div class="save_bar"> 
			
				<?php $this -> saveButtonView(); ?>			
				<button id ="of_reset" type="submit" name="smof[action]" value="reset" class="button submit-button reset-button" ><?php _e('Options Reset');?></button>
				
			</div><!--.save_bar--> 
	 
		</form>
		
		<div style="clear:both;"></div>

	</div><!--wrap-->
	<div class="smof_footer_info">
	Slightly Modified Options Framework <strong><?php /* echo SMOF_VERSION; */ ?></strong>
	</div>
	
	<?php
	
	}

}

?>