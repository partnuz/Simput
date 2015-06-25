/*
var SmofData = function( parent , args ){
	console.log( parent );
	this.$parent = jQuery( parent );
	console.log( this.$parent );
	this.fieldType = '';
	this.fieldObject = null;
	this.args = args;
	
	this.getFieldType();
	this.setFieldObject();
	
	this.run();
	
}

SmofData.prototype.getFieldType = function(){
	
	console.log( this.$parent.attr('class') );
	var classNames = this.$parent.attr('class');
	var find = /smof-container-[a-zA-Z]+/;
	console.log( classNames.match( find ) );
	var className = classNames.match( find )[0];
	
	this.fieldType = className.replace( 'smof-container-' , '' );
	this.fieldType = this.fieldType.charAt(0).toUpperCase() + this.fieldType.slice(1);
	
}

SmofData.prototype.setFieldObject = function(){
	var constructorName = 'SmofData' + this.fieldType;
	if (typeof constructorName == 'function'){
		this.fieldObject = new window[ constructorName ]( this.$parent , this.args );
	}
}

SmofData.prototype.run = function(){
	
	if( this.fieldObject ){
		this.fieldObject.runActions();
	}
}



var SmofDataCombobox = function( $parent , args ){
	
	var obj = this;
	
	this.$parent = $parent;
	this.args = args;
	this.actions = this.args[ 'actions' ];
	
	this.runActions = function(){
		
		var length = this.actions.length;
		
		for( var i = 0; i < length ; i++ ){
			
			var actionName = this.actions[ i ];
			this[ actionName ]();
			
		}
		
		
	};
	
	this.append = function(){
		
		jQuery(function(){
			
			obj.$parent.find( ".smof-field-helper-combobox" ).append(jQuery("#smof-data-source-" + this.args[ 'data_source_name' ] + " option"));
			
		});
		
	}
	
	this.select = function(){
		
		jQuery( function(){
			
			obj.$parent.find( '.smof-field-combobox option[value=\'' + this.args[ 'value' ] +'\']' ).attr( 'selected' , 'selected');
		});
		
	}
	
}
*/
