<?php
/**
* Address control class for ButterBean.
*/
if ( ! class_exists( 'ButterBean_Control' ) ) {
	return; }

class ButterBean_Control_Address extends ButterBean_Control {

	public $type = 'address';

	public function to_json() {
		parent::to_json();

		$this->json['street'] = array(
			'label'      => 'Street',
			'value'      => $this->get_value( 'street' ),
			'field_name' => $this->get_field_name( 'street' ),
		);

		$this->json['city'] = array(
			'label'      => 'City',
			'value'      => $this->get_value( 'city' ),
			'field_name' => $this->get_field_name( 'city' ),
		);

		$this->json['state'] = array(
			'label'      => 'State',
			'value'      => $this->get_value( 'state' ),
			'field_name' => $this->get_field_name( 'state' ),
		);

		$this->json['zip'] = array(
			'label'      => 'ZIP Code',
			'value'      => $this->get_value( 'zip_code' ),
			'field_name' => $this->get_field_name( 'zip_code' ),
		);

		$this->json['addresss'] = array(
			'label'      => 'Address',
			'value'      => $this->get_value( 'address' ),
			'field_name' => $this->get_field_name( 'address' ),
		);

		$this->json['lat_lon'] = array(
			'label'      => 'Coordinates',
			'value'      => $this->get_value( 'lat_lon' ),
			'field_name' => $this->get_field_name( 'lat_lon' ),
		);
	}

	public function get_template() {
		?>

		<div class="u-1of1 u-p1 u-1of2-md">
			<input id="geocomplete" type="text" placeholder="Type in an address" value="" />
			<input id="find" class="button" type="button" value="find" />
		</div>
		<div class="row">
			<div class="u-1of1 u-p1">
				<label>
					<span class="butterbean-label">{{ data.street.label }}</span>
					<input type="text" placeholder="1123 South Church Street" autocomplete="shipping street-address" class="u-1of1" value="{{ data.street.value }}" name="{{ data.street.field_name }}" />
				</label>
			</div>
		</div>

		<div class="row u-flex u-flex-wrap u-flex-jb">
			<div class="u-1of1 u-p1 u-1of2-md">
				<label>
					<span class="butterbean-label">{{ data.city.label }}</span>
					<input type="text" class="u-1of1" placeholder="Charlotte" autocomplete="shipping address-level2" value="{{ data.city.value }}" name="{{ data.city.field_name }}" />
				</label>
			</div>
			<div class="u-1of1 u-p1 u-1of4-md">
				<label>
					<span class="butterbean-label">{{ data.state.label }}</span>
					<input type="text" class="u-1of1 u-caps" placeholder="NC" maxlength="2" autocomplete="shipping address-level1" value="{{ data.state.value }}" name="{{ data.state.field_name }}" />
				</label>
			</div>
			<div class="u-1of1 u-p1 u-1of4-md">
				<label>
					<span class="butterbean-label">{{ data.zip.label }}</span>
					<input type="text" pattern="[0-9]*" class="u-1of1" maxlength="5" placeholder="28203" autocomplete="shipping postal-code" value="{{ data.zip.value }}" name="{{ data.zip.field_name }}" />
				</label>
			</div>
		</div>

		<div class="row u-flex u-flex-wrap u-flex-jb">

			<div class="map_canvas u-1of1 u-p1"></div>

			<div class="u-1of1 u-p1">
				<label>
					<span class="butterbean-label">{{ data.lat_lon.label }}</span>
					<input data-geo="location" name="{{ data.lat_lon.field_name }}" type="text" placeholder="geo-coordinates" class="u-1of1" value="{{ data.lat_lon.value }}">
				</label>
			</div>
		</div>
		<?php }
}
