(function (api) {
	// Image control view.
	api.views.register_control('document', {
		events: {
			'click .butterbean-add-media': 'showmodal',
			'click .butterbean-change-media': 'showmodal',
			'click .butterbean-remove-media': 'removemedia'
		},
		showmodal: function () {
			console.log(this.model);

			if (!_.isUndefined(this.modal)) {
				this.modal.open();
				return;
			}

			this.modal = wp.media({
				frame: 'select',
				multiple: false,
				editing: true,
				title: 'Choose',
				library: {
					type: 'application'
				},
				button: {
					text: 'Use this document'
				}
			});

			this.modal.on(
				'select',
				function () {
					var media = this.modal
						.state()
						.get('selection')
						.first()
						.toJSON();

					this.model.set({
						doc_icon: media.icon,
						doc_name: media.filename,
						doc_mime: media.mime,
						value: media.id
					});
				},
				this
			);

			this.modal.open();
		},
		removemedia: function () {
			this.model.set({
				src: '',
				value: ''
			});
		}
	});
})(butterbean);
