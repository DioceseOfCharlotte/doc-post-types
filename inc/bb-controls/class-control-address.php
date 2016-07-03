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

		$this->json['street_2'] = array(
            'label'      => 'Street 2',
            'value'      => $this->get_value( 'street_2' ),
            'field_name' => $this->get_field_name( 'street_2' )
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
    }

    public function get_template() { ?>

        <label>
            <span class="butterbean-label">{{ data.street.label }}</span>
            <input type="text" class="u-1of1" value="{{ data.street.value }}" name="{{ data.street.field_name }}" />
        </label>

		<label>
            <span class="butterbean-label">{{ data.street_2.label }}</span>
            <input type="text" class="u-1of1" value="{{ data.street_2.value }}" name="{{ data.street_2.field_name }}" />
        </label>

		<label class="u-1of3">
            <span class="butterbean-label">{{ data.city.label }}</span>
            <input type="text" value="{{ data.city.value }}" name="{{ data.city.field_name }}" />
        </label>

        <label class="u-1of3">
            <span class="butterbean-label">{{ data.state.label }}</span>
            <input type="text" value="{{ data.state.value }}" name="{{ data.state.field_name }}" />
        </label>

        <label class="u-1of3">
            <span class="butterbean-label">{{ data.zip.label }}</span>
            <input type="text" value="{{ data.zip.value }}" name="{{ data.zip.field_name }}" />
        </label>
    <?php }
}
