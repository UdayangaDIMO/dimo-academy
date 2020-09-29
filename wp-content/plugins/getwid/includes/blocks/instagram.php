<?php

namespace Getwid\Blocks;

class Instagram extends \Getwid\Blocks\AbstractBlock {

	protected static $blockName = 'getwid/instagram';

    public function __construct() {

        parent::__construct( self::$blockName );

		add_action( 'wp_ajax_get_instagram_token', [ $this, 'get_instagram_token'] );

        register_block_type(
            'getwid/instagram',
            array(
                'attributes' => array(
                    'photoCount' => array(
                        'type' => 'number',
                        'default' => 6
                    ),
                    'gridColumns' => array(
                        'type' => 'number',
                        'default' => 3
                    ),
                    'spacing' => array(
                        'type' => 'string',
                        'default' => 'default'
                    ),
                    'align' => array(
                        'type' => 'string'
                    ),
                    'className' => array(
                        'type' => 'string'
                    ),
                ),
                'render_callback' => [ $this, 'render_callback' ]
            )
        );

		if ( $this->isEnabled() ) {
			add_filter( 'getwid/blocks_style_css/dependencies', [ $this, 'block_frontend_styles' ] );
		}
    }

	public function getLabel() {
		return __('Instagram', 'getwid');
	}

    public function get_instagram_token() {
        $action = $_POST[ 'option' ];
        $data   = $_POST[ 'data' ];

        $response = false;
        if ( $action == 'get' ) {
            $response = get_option( 'getwid_instagram_token', '' );
        }

        wp_send_json_success( $response );
    }

    public function block_frontend_styles($styles) {

		getwid_log( self::$blockName . '::hasBlock', $this->hasBlock() );

        return $styles;
    }

    public function render_callback( $attributes ) {
        $error = false;
        $empty = false;

        //Get Access Token
        $access_token = get_option( 'getwid_instagram_token' );

        //If Empty Token
        if ( empty($access_token) ) {
            if ( current_user_can('manage_options') ) {
                return '<p>' . sprintf(
                    __( 'Instagram Access Token is not set. <a href="%s">Connect Instagram Account</a>.', 'getwid' ),
                    admin_url( 'options-writing.php#getwid-settings' ) ) . '</p>';
            } else {
                return '';
            }
		}

        $instagram_media = get_transient( 'getwid_instagram_response_data' );

        if ( false === $instagram_media ) {

            $api_uri = 'https://graph.instagram.com/me/media?fields=id,media_type,media_url,permalink,caption,thumbnail_url&access_token=' . $access_token;

			//Get data from Instagram
            $response = wp_remote_get(
                $api_uri,
                array( 'timeout' => 15 )
			);

            if ( is_wp_error( $response ) ) {
                if ( current_user_can('manage_options') ){
                    return '<p>' . $response->get_error_message() . '</p>';
                } else {
                    return '';
                }
            } else {
                $instagram_media = json_decode( wp_remote_retrieve_body( $response ) );

                //JSON valid
                if ( json_last_error() === JSON_ERROR_NONE ) {
                    if ( isset($instagram_media->data) ) {

						//Cache response
						$expiration = intval( get_option( 'getwid_instagram_cache_timeout', 30 ) );

                        set_transient( 'getwid_instagram_response_data', $instagram_media, $expiration * MINUTE_IN_SECONDS );

                    } else {
                        if ( current_user_can( 'manage_options' ) ) {
                            return '<p>' . $instagram_media->error->message . '</p>';
                        } else {
                            return '';
                        }
                    }
                } else {
                    return __( 'Error in json_decode.', 'getwid' );
                }
            }
        }

        $class = $block_name = 'wp-block-getwid-instagram';

        if ( isset( $attributes[ 'align' ] ) ) {
            $class .= ' align' . $attributes[ 'align' ];
        }

        $wrapper_class = 'wp-block-getwid-instagram__wrapper';
        $wrapper_class .= " has-" . $attributes[ 'gridColumns' ] . "-columns";

        if ( isset( $attributes[ 'spacing' ] ) && $attributes[ 'spacing' ] != 'default' ) {
            $class .= ' has-spacing-' . $attributes[ 'spacing' ];
        }

        if ( isset( $attributes[ 'className' ] ) ) {
            $class .= ' ' . $attributes[ 'className' ];
        }

        ob_start();
        ?><div class="<?php echo esc_attr( $class ); ?>">
            <div class="<?php echo esc_attr( $wrapper_class );?>">
                <?php
                    $counter = 1;
                    foreach ( $instagram_media->data as $key => $value ) {
                        if ( $counter <= $attributes[ 'photoCount' ] ) {
                            $extra_attr = array(
                                'block_name' => $block_name,
                                'post' => $value
                            );
                            getwid_get_template_part( 'instagram/post', $attributes, false, $extra_attr );
                        }
                        $counter ++;
                    } // end foreach
                ?></div>
        </div><?php

        $result = ob_get_clean();
        return $result;
    }
}

getwid()->blocksManager()->addBlock(
	new \Getwid\Blocks\Instagram()
);