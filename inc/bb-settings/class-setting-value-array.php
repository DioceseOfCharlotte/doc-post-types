<?php
/**
 * Setting class for storing multiple post meta values for a single key.
 *
 * @package    ButterBean
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       https://github.com/justintadlock/butterbean
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

 if ( ! class_exists( 'ButterBean_Setting' ) ) {
 	return; }

/**
 * Array setting class.
 *
 * @since  1.0.0
 * @access public
 */
	class Doc_Setting_ValueArray extends ButterBean_Setting {

		public function sanitize( $values ) {

			$multi_values = $values && ! is_array( $values ) ? explode( ',', $values ) : $values;

			return $multi_values ? array_map( array( $this, 'map' ), $multi_values ) : array();
		}

		public function map( $value ) {

			return apply_filters( "butterbean_{$this->manager->name}_sanitize_{$this->name}", $value, $this );
		}

		public function save() {

			$old_values  = $this->get_value();
			$new_values  = $this->get_posted_value();
			$save_values = array();

			if ( is_array( $new_values ) ) {

				foreach ( $new_values as $value ) {

					if ( ! in_array( $value, $old_values ) ) {
						$save_values[] = $value;
					}
				}

				if ( $save_values ) {
					update_post_meta( $this->manager->post_id, $this->name, $save_values );
				}
			}

			else if ( $old_values ) {
				delete_post_meta( $this->manager->post_id, $this->name );
			}
		}
	}
