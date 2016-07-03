<?php

add_action( 'pre_get_posts', 'doc_custom_queries', 1 );


/**
 * Register taxonomies.
 *
 * @since  0.1.0
 * @access public
 * @param array $query Main Query.
 */
function doc_custom_queries( $query ) {
	if ( ! $query->is_main_query() || is_admin() )
		return;

	if ( is_tax( 'agency' ) ) {
		$post_type = $query->get( 'post_type' );
		$meta_query = $query->get( 'meta_query' );
		$post_type = doc_home_tiles();
		$meta_query[] = array(
			'key'       => 'doc_alias_checkbox',
			'value'     => 'on',
			'compare'   => 'NOT EXISTS',
		);
		$query->set( 'meta_query', $meta_query );
		$query->set( 'post_type', $post_type );
		$query->set( 'order', 'ASC' );
	  	$query->set( 'orderby', 'title' );

	} elseif ( is_post_type_archive( doc_place_cpts() ) ) {
			$query->set( 'order', 'ASC' );
			$query->set( 'post_parent', 0 );
			$query->set( 'orderby', 'name' );
	}
}



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
            <input type="text" value="{{ data.street.value }}" name="{{ data.street.field_name }}" />
        </label>

		<label>
            <span class="butterbean-label">{{ data.street_2.label }}</span>
            <input type="text" value="{{ data.street_2.value }}" name="{{ data.street_2.field_name }}" />
        </label>

        <label>
            <span class="butterbean-label">{{ data.state.label }}</span>
            <input type="text" value="{{ data.state.value }}" name="{{ data.state.field_name }}" />
        </label>

        <label>
            <span class="butterbean-label">{{ data.zip.label }}</span>
            <input type="text" value="{{ data.zip.value }}" name="{{ data.zip.field_name }}" />
        </label>
    <?php }
}
