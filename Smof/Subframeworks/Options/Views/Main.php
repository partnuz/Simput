<?php
namespace Smof\Subframeworks\Options\Views;
class Main{
	
	public $data = array();
	
	public function setData( $key , $value ){
		$this -> data[ $key ] = $value;
	}
	
	public function menuItemView( $item ){
	
	}
	
	public function saveButtonView(){
		?>
		<button id ="of_save" type="submit" name="smof[action]" value="save" class="button-primary"><?php _e('Save All Changes');?></button>
		<?php
	}
	
	public function view(){
	
	?>
	
	<div class="wrap" id="of_container">
		<?php
		if( !empty( $this -> data[ 'save' ] ) ){
		?>
			<div id="of-popup-save" class="of-save-popup">
				<div class="of-save-save">Options Updated</div>
			</div>
		<?php
		}
		?>
		
		<div id="of-popup-reset" class="of-save-popup">
			<div class="of-save-reset">Options Reset</div>
		</div>
		
		<?php
		if( !empty( $this -> data[ 'error' ] ) ){
		?>
			<div id="of-popup-fail" class="of-save-popup">
				<div class="of-save-fail">Error!</div>
			</div>
		<?php
		}
		?>
		
		

		<form id="of_form" method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data" >
		
			<div id="header">
			
				<div class="logo">
					<h2><?php echo esc_html( $this -> data[ 'name' ]); ?></h2>
					<span><?php echo esc_html( $this -> data[ 'version' ]); ?></span>
				</div>
			
				<div id="js-warning"><?php _e( 'Warning- This options panel will not work properly without javascript!' ,  'smof' ); ?></div>
				<div class="icon-option"></div>
				<div class="clear"></div>
			
			</div>

			<div id="info_bar">
			
				<a>
					<div id="expand_options" class="expand"><?php _e( 'Expand' , 'smof' ); ?></div>
				</a>
							
				<img style="display:none" src="<?php /* echo ADMIN_DIR; */ ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />

				<?php $this -> saveButtonView(); ?>
				
			</div><!--.info_bar--> 	
			
			<div id="main">

					<div id="of-nav">
						<ul>
							<?php 
							
							if( isset( $this -> data[ 'menu' ] ) ){

								foreach( $this -> data[ 'menu' ] as $menu_item){
								    	?>
									<li id="<?php echo esc_attr( $menu_item[ 'id' ] ); ?>"><a href="#smof-container-<?php echo $menu_item[ 'id' ]; ?>"><?php if( !empty( $menu_item[ 'icon' ]) ){ ?><span class="<?php echo $menu_item[ 'icon' ]; ?>"></span><?php } ?><?php echo $menu_item[ 'title' ]; ?></a></li>
									<?php
								}
							
							}
							?>
						</ul>
					</div>

					<div id="content">
						<?php echo $this -> data[ 'content' ]; ?>
					</div>

				
				<div class="clear"></div>
				
			</div>
			
			<div class="save_bar"> 
			
				<?php $this -> saveButtonView(); ?>			
				<button id ="of_reset" type="submit" name="smof[action]" value="reset" class="button submit-button reset-button" ><?php _e('Options Reset');?></button>
				
			</div><!--.save_bar--> 
			
			<input type="hidden" id="nonce" name="smof[nonce]" value="<?php echo esc_attr( $this -> data[ 'nonce' ] ); ?>" />
	 
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