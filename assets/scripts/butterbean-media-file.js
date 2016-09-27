( function( api ) {

	// Image control view.
	api.controls['bb2-video'] = api.controls.default.extend( {
		events : {
			'click .butterbean-add-media'    : 'showmodal',
			'click .butterbean-change-media' : 'showmodal',
			'click .butterbean-remove-media' : 'removemedia'
		},
		showmodal : function() {

			console.log( this.model );

			if ( ! _.isUndefined( this.modal ) ) {

				this.modal.open();
				return;
			}

			this.modal = wp.media( {
				frame    : 'select',
				multiple : false,
				editing  : true,
				title    : 'Choose',
				library  : { type : 'video' },
				button   : { text:  'Set Video' }
			} );

			this.modal.on( 'select', function() {

				var media = this.modal.state().get( 'selection' ).first().toJSON();

				this.model.set( {
					url   : media.url,
					value : media.id
				} );
			}, this );

			this.modal.open();
		},
		removemedia : function() {

			this.model.set( { src : '', alt : '', value : '' } );
		}
	} );

}( butterbean ) );
