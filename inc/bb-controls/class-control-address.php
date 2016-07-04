<?php
/**
 * Address control class for ButterBean.
 */
if ( ! class_exists( 'ButterBean_Control' ) )
	return;

class ButterBean_Control_Address extends ButterBean_Control {

    public $type = 'address';

    public function to_json() {
        parent::to_json();

        $this->json['street'] = array(
            'label'      => 'Street',
            'value'      => $this->get_value( 'street' ),
            'field_name' => $this->get_field_name( 'street' )
        );

		$this->json['city'] = array(
            'label'      => 'City',
            'value'      => $this->get_value( 'city' ),
            'field_name' => $this->get_field_name( 'city' )
        );

        $this->json['state'] = array(
            'label'      => 'State',
            'value'      => $this->get_value( 'state' ),
            'field_name' => $this->get_field_name( 'state' )
        );

        $this->json['zip'] = array(
            'label'      => 'ZIP Code',
            'value'      => $this->get_value( 'zip_code' ),
            'field_name' => $this->get_field_name( 'zip_code' )
        );

		$this->json['lat'] = array(
            'label'      => 'Latitude',
            'value'      => $this->get_value( 'lat' ),
            'field_name' => $this->get_field_name( 'lat' )
        );

		$this->json['lng'] = array(
            'label'      => 'Longitude',
            'value'      => $this->get_value( 'lng' ),
            'field_name' => $this->get_field_name( 'lng' )
        );
    }

    public function get_template() { ?>

		<div class="row">
			<p class="u-1of1">
		        <label>
		            <span class="butterbean-label">{{ data.street.label }}</span>
		            <input type="text" placeholder="1123 South Church Street" autocomplete="shipping street-address" class="u-1of1" value="{{ data.street.value }}" name="{{ data.street.field_name }}" />
		        </label>
			</p>
		</div>

		<div class="row u-flex u-flex-wrap u-flex-jb">
			<p class="u-1of2-md">
				<label>
		            <span class="butterbean-label">{{ data.city.label }}</span>
		            <input type="text" class="u-1of1" placeholder="Charlotte" autocomplete="shipping address-level2" value="{{ data.city.value }}" name="{{ data.city.field_name }}" />
		        </label>
			</p>
			<p class="u-1of4-md">
		        <label>
		            <span class="butterbean-label">{{ data.state.label }}</span>
		            <input type="text" class="u-1of1 u-caps" placeholder="NC" maxlength="2" autocomplete="shipping address-level1" value="{{ data.state.value }}" name="{{ data.state.field_name }}" />
		        </label>
			</p>
			<p class="u-1of4-md">
		        <label>
		            <span class="butterbean-label">{{ data.zip.label }}</span>
		            <input type="text" pattern="[0-9]*" class="u-1of1" maxlength="5" placeholder="28203" autocomplete="shipping postal-code" value="{{ data.zip.value }}" name="{{ data.zip.field_name }}" />
		        </label>
			</p>
		</div>

		<div class="row u-flex u-flex-wrap u-flex-jb">

<?= '<a href="https://maps.googleapis.com/maps/api/geocode/json?address=',
    rawurlencode('{{ data.street.value }}'), '&key=AIzaSyBaZXRmZU4v95wWc14Lj_ylEE2110a2EcQ">'; ?>

			<p class="u-1of2">
		        <label>
		            <input type="text" placeholder="Latitude" class="u-1of1" value="{{ data.lat.value }}" name="{{ data.lat.field_name }}" disabled>
		        </label>
			</p>
			<p class="u-1of2-md">
				<label>
		            <input type="text" placeholder="Longitude" class="u-1of1" value="{{ data.lng.value }}" name="{{ data.lng.field_name }}" disabled>
		        </label>
			</p>
		</div>
    <?php }
}
