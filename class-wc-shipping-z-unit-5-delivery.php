<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC_Shipping_Z_Unit_5_Delivery Delivery Shipping Method
 *
 * A simple shipping method allowing local delivery as a shipping method
 *
 * @class 		WC_Shipping_Z_Unit_5_Delivery
 * @version		2.0.0
 * @package		WooCommerce/Classes/Shipping
 * @author 		WooThemes
 */
class WC_Shipping_Z_Unit_5_Delivery extends WC_Shipping_Method {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
		$this->id           = 'z_delivery';
		$this->method_title = __( 'Unit Threshold Delivery', 'woocommerce' );
		$this->init();
	}

	/**
	 * init function.
	 *
	 * @access public
	 * @return void
	 */
	function init() {

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables
		$this->title        = $this->get_option( 'title' );
		$this->type         = $this->get_option( 'type' );
		$this->fee          = $this->get_option( 'fee' );
		$this->type         = $this->get_option( 'type' );
		$this->codes        = $this->get_option( 'codes' );
		$this->availability = $this->get_option( 'availability' );
		$this->countries    = $this->get_option( 'countries' );
		$this->units    	= $this->get_option( 'units' );

		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	/**
	 * calculate_shipping function.
	 *
	 * @access public
	 * @param array $package (default: array())
	 * @return void
	 */
	function calculate_shipping( $package = array() ) {

		$shipping_total = 0;
		$fee = ( trim( $this->fee ) == '' ) ? 0 : $this->fee;

		if ( $this->type =='fixed' ) 	$shipping_total 	= $this->fee;

		if ( $this->type =='percent' ) 	$shipping_total 	= $package['contents_cost'] * ( $this->fee / 100 );

		if ( $this->type == 'product' )	{
			foreach ( $package['contents'] as $item_id => $values ) {
				$_product = $values['data'];

				if ( $values['quantity'] > 0 && $_product->needs_shipping() ) {
					$shipping_total += $this->fee * $values['quantity'];
                }
			}
		}

		if ( $this->type == 'unit' )	{
			// print_r($package['contents']);
			$quantity = 0;

			foreach ( $package['contents'] as $item_id => $values ) {
				$_product = $values['data'];

				if ( $values['quantity'] > 0 && $_product->needs_shipping() ) {
					$quantity += $values['quantity'];
                }
			}

			if ( $quantity <= 5 ) {

				$shipping_total =  49;
			} 
			elseif ( $quantity <= 10 ) {
				$shipping_total =  80;
			}
			else {
				$available_methods = false;
				return;
			}
		}

		$rate = array(
			'id'    => $this->id,
			'label' => $this->title,
			'cost'  => $shipping_total
		);

		$this->add_rate($rate);
	}

	/**
	 * init_form_fields function.
	 *
	 * @access public
	 * @return void
	 */
	function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
				'title'       => __( 'Enable', 'woocommerce' ),
				'type'        => 'checkbox',
				'label'       => __( 'Enable 5 Units delivery', 'woocommerce' ),
				'default'     => 'no'
			),
			'title' => array(
				'title'       => __( 'Title', 'woocommerce' ),
				'type'        => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
				'default'     => __( 'Delivery Fee', 'woocommerce' ),
				'desc_tip'    => true,
			),
			'type' => array(
				'title'       => __( 'Fee Type', 'woocommerce' ),
				'type'        => 'select',
				'description' => __( 'How to calculate delivery charges', 'woocommerce' ),
				'default'     => 'fixed',
				'options'     => array(
					'fixed'       => __( 'Fixed amount', 'woocommerce' ),
					'percent'     => __( 'Percentage of cart total', 'woocommerce' ),
					'product'     => __( 'Fixed amount per product', 'woocommerce' ),
					'unit'     => __( '5 Units', 'woocommerce' ),

				),
				'desc_tip'    => true,
			),
			'fee' => array(
				'title'       => __( 'Delivery Fee', 'woocommerce' ),
				'type'        => 'price',
				'description' => __( 'What fee do you want to charge for local delivery, disregarded if you choose free. Leave blank to disable.', 'woocommerce' ),
				'default'     => '',
				'desc_tip'    => true,
				'placeholder' => wc_format_localized_price( 0 )
			),
			'codes' => array(
				'title'       => __( 'Zip/Post Codes', 'woocommerce' ),
				'type'        => 'textarea',
				'description' => __( 'What zip/post codes would you like to offer delivery to? Separate codes with a comma. Accepts wildcards, e.g. P* will match a postcode of PE30.', 'woocommerce' ),
				'default'     => '',
				'desc_tip'    => true,
				'placeholder' => '12345, 56789 etc'
			),
			'availability' => array(
				'title'       => __( 'Method availability', 'woocommerce' ),
				'type'        => 'select',
				'default'     => 'all',
					'class'       => 'availability',
					'options'     => array(
					'all'         => __( 'All allowed countries', 'woocommerce' ),
					'specific'    => __( 'Specific Countries', 'woocommerce' )
				)
			),
			'countries' => array(
				'title'       => __( 'Specific Countries', 'woocommerce' ),
				'type'        => 'multiselect',
				'class'       => 'chosen_select',
				'css'         => 'width: 450px;',
				'default'     => '',
				'options'     => WC()->countries->get_shipping_countries(),
				'custom_attributes' => array(
					'data-placeholder' => __( 'Select some countries', 'woocommerce' )
				)
			)
		);
	}

	/**
	 * admin_options function.
	 *
	 * @access public
	 * @return void
	 */
	function admin_options() {
		?>
		<h3><?php echo $this->method_title; ?></h3>
		<p><?php _e( '5 Units delivery is a shipping method for Sydney and Melbourne orders only.', 'woocommerce' ); ?></p>
		<table class="form-table">
			<?php $this->generate_settings_html(); ?>
		</table> <?php
	}


	/**
	 * is_available function.
	 *
	 * @access public
	 * @param array $package
	 * @return bool
	 */
	function is_available( $package ) {

		$quantity = 0;
		foreach ( $package['contents'] as $item_id => $values ) {
			$_product = $values['data'];

			if ( $values['quantity'] > 0 && $_product->needs_shipping() ) {
				$quantity += $values['quantity'];
            }
		}
		// print_r($quantity);
		// print_r($package['destination']['postcode']);
		$subject = $package['destination']['postcode'];
		$pattern = '/^[2-3]\d{3}$/';
		// print_r(preg_match($pattern, $subject));

		if ( !preg_match($pattern, $subject) || ( preg_match($pattern, $subject) && $quantity > 10 ) ) {
			return false;
		}

		if ($this->enabled=="no") return false;

		// If post codes are listed, let's use them.
		$codes = '';
		if ( $this->codes != '' ) {
			foreach( explode( ',', $this->codes ) as $code ) {
				$codes[] = $this->clean( $code );
			}
		}

		if ( is_array( $codes ) ) {

			$found_match = false;

			if ( in_array( $this->clean( $package['destination']['postcode'] ), $codes ) ) {
				$found_match = true;
            }


			// Pattern match
			if ( ! $found_match ) {

				$customer_postcode = $this->clean( $package['destination']['postcode'] );
				foreach ($codes as $c) {
					$pattern = '/^' . str_replace( '_', '[0-9a-zA-Z]', $c ) . '$/i';
					if ( preg_match( $pattern, $customer_postcode ) ) {
						$found_match = true;
						break;
					}
				}

			}


			// Wildcard search
			if ( ! $found_match ) {

				$customer_postcode = $this->clean( $package['destination']['postcode'] );
				$customer_postcode_length = strlen( $customer_postcode );

				for ( $i = 0; $i <= $customer_postcode_length; $i++ ) {

					if ( in_array( $customer_postcode, $codes ) ) {
						$found_match = true;
                    }

					$customer_postcode = substr( $customer_postcode, 0, -2 ) . '*';
				}
			}

			if ( ! $found_match ) {
				return false;
            }
		}

		// Either post codes not setup, or post codes are in array... so lefts check countries for backwards compatibility.
		if ( $this->availability == 'specific' ) {
			$ship_to_countries = $this->countries;
		} else {
			$ship_to_countries = array_keys( WC()->countries->get_shipping_countries() );
        }

		if (is_array($ship_to_countries)) {
			if (!in_array( $package['destination']['country'] , $ship_to_countries)){
				return false;
            }
        }

		// Yay! We passed!
		return apply_filters( 'woocommerce_shipping_' . $this->id . '_is_available', true, $package );
	}


	/**
	 * clean function.
	 *
	 * @access public
	 * @param mixed $code
	 * @return string
	 */
	function clean( $code ) {
		return str_replace( '-', '', sanitize_title( $code ) ) . ( strstr( $code, '*' ) ? '*' : '' );
	}

}
