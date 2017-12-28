<?php

namespace CustomizeStaticLayout;

/**
 * Class ControlEditWidget
 *
 * @package CustomizeStaticLayout
 */
class ControlEditWidget extends \WP_Customize_Control
{
    /**
     * Control type
     * @var string
     */
    public $type = 'edit_widget';

    /**
     * Constructor
     *
     * @param \WP_Customize_Manager $manager
     * @param string                $id
     * @param array                 $args
     */
    public function __construct( $manager, $id, array $args = [] )
    {
        $this->type = StaticLayout::NAME . "_{$this->type}";
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON
     *
     * @see WP_Customize_Control::json()
     *
     * @return array
     */
    public function json()
    {
        $json = parent::json();
        $json['l10n'] = [
            'edit'          => sprintf( esc_html__( 'Edit %s', 'customize-static-layout' ), $this->label ),
            'remove'        => sprintf( esc_html__( 'Remove %s', 'customize-static-layout' ), $this->label ),
            'confirmRemove' => esc_html__( 'Are you sure you wish to remove this widget?', 'customize-static-layout' ),
        ];

        return $json;
    }

    public function enqueue()
    {
        parent::enqueue();
        wp_enqueue_style(
            StaticLayout::NAME . '-control-edit-widget',
            plugins_url( 'assets/css/control-edit-widget.css', __DIR__ ),
            [],
            CUSTOMIZE_STATIC_LAYOUT
        );
        wp_enqueue_script(
            StaticLayout::NAME . '-control-edit-widget',
            plugins_url( 'assets/js/control-edit-widget.js', __DIR__ ),
            [ 'jquery', 'underscore', 'customize-models' ],
            CUSTOMIZE_STATIC_LAYOUT,
            true
        );
        wp_localize_script( StaticLayout::NAME . '-control-edit-widget', 'customizeStaticLayoutControlEditWidget', [
            'type'      => $this->type,
            'namespace' => StaticLayout::NAME,
        ] );
    }

    /**
     * Render the control's content
     */
    public function content_template()
    {
        ?>
        <button
            type="button"
            class="button <?= StaticLayout::NAME ?>-edit-widget-button"
        >{{{ data.l10n.edit }}}</button><button
            type="button"
            class="button dashicons dashicons-trash <?= StaticLayout::NAME ?>-remove-widget-button"
            title="{{ data.l10n.remove }}"
        ></button>
        <?php
    }


}