<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class WP_SMS
{
    /**
     * Plugin instance.
     *
     * @see get_instance()
     * @type object
     */
    protected static $instance = null;

    public function __construct()
    {
        /*
         * Plugin Loaded Action
         */
        add_action('plugins_loaded', array($this, 'plugin_setup'));

        /**
         * Install And Upgrade plugin
         */
        require_once WP_SMS_DIR . 'includes/class-wpsms-install.php';

        register_activation_hook(WP_SMS_DIR . 'wp-sms.php', array('\WP_SMS\Install', 'install'));
    }

    /**
     * Access this plugin’s working instance
     *
     * @wp-hook plugins_loaded
     * @return  object of this class
     * @since   2.2.0
     */
    public static function get_instance()
    {
        null === self::$instance and self::$instance = new self;

        return self::$instance;
    }

    /**
     * Constructors plugin Setup
     *
     * @param Not param
     */
    public function plugin_setup()
    {
        // Load text domain
        add_action('init', array($this, 'load_textdomain'));

        $this->includes();
    }

    /**
     * Load plugin textdomain.
     *
     * @since 1.0.0
     */
    public function load_textdomain()
    {
        load_plugin_textdomain('wp-sms', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    /**
     * Includes plugin files
     *
     * @param Not param
     */
    public function includes()
    {
        // Utility classes.
        require_once WP_SMS_DIR . 'src/Helper.php';
        require_once WP_SMS_DIR . 'src/Utils/CsvHelper.php';
        require_once WP_SMS_DIR . 'includes/class-wpsms-features.php';
        require_once WP_SMS_DIR . 'includes/class-wpsms-notifications.php';
        require_once WP_SMS_DIR . 'includes/class-wpsms-integrations.php';
        require_once WP_SMS_DIR . 'includes/class-wpsms-gravityforms.php';
        require_once WP_SMS_DIR . 'includes/class-wpsms-quform.php';
        require_once WP_SMS_DIR . 'includes/class-wpsms-newsletter.php';
        require_once WP_SMS_DIR . 'includes/class-wpsms-rest-api.php';
        require_once WP_SMS_DIR . 'includes/class-wpsms-shortcode.php';
        require_once WP_SMS_DIR . 'includes/admin/class-wpsms-version.php';

        // Blocks
        require_once WP_SMS_DIR . 'src/BlockAbstract.php';
        require_once WP_SMS_DIR . 'src/Blocks/SubscribeBlock.php';
        require_once WP_SMS_DIR . 'src/BlockAssetsManager.php';

        $blockManager = new \WP_SMS\Blocks\BlockAssetsManager();
        $blockManager->init();

        // Controllers
        require_once WP_SMS_DIR . 'src/Controller/AjaxControllerAbstract.php';
        require_once WP_SMS_DIR . 'src/Controller/SubscriberFormAjax.php';
        require_once WP_SMS_DIR . 'src/Controller/GroupFormAjax.php';
        require_once WP_SMS_DIR . 'src/Controller/ExportAjax.php';
        require_once WP_SMS_DIR . 'src/Controller/UploadSubscriberCsv.php';
        require_once WP_SMS_DIR . 'src/Controller/ImportSubscriberCsv.php';
        require_once WP_SMS_DIR . 'src/Controller/ControllerManager.php';

        $controllerManager = new \WP_SMS\Controller\ControllerManager();
        $controllerManager->init();

        // Webhooks
        require_once WP_SMS_DIR . 'src/Webhook/WebhookFactory.php';
        require_once WP_SMS_DIR . 'src/Webhook/WebhookAbstract.php';
        require_once WP_SMS_DIR . 'src/Webhook/WebhookManager.php';
        require_once WP_SMS_DIR . 'src/Webhook/NewSubscriberWebhook.php';
        require_once WP_SMS_DIR . 'src/Webhook/NewSMSWebhook.php';

        $webhookManager = new \WP_SMS\Webhook\WebhookManager();
        $webhookManager->init();

        if (is_admin()) {
            // Admin classes.
            require_once WP_SMS_DIR . 'includes/admin/settings/class-wpsms-settings.php';

            require_once WP_SMS_DIR . 'includes/admin/class-wpsms-admin.php';
            require_once WP_SMS_DIR . 'includes/admin/class-wpsms-admin-helper.php';

            // Outbox class.
            require_once WP_SMS_DIR . 'includes/admin/outbox/class-wpsms-outbox.php';
            require_once WP_SMS_DIR . 'includes/admin/inbox/class-wpsms-inbox.php';

            // Privacy class.
            require_once WP_SMS_DIR . 'includes/admin/privacy/class-wpsms-privacy-actions.php';

            // Send class.
            require_once WP_SMS_DIR . 'includes/admin/send/class-wpsms-send.php';

            // Send class.
            require_once WP_SMS_DIR . 'includes/admin/add-ons/class-add-ons.php';

            // Widgets
            require_once WP_SMS_DIR . 'includes/admin/Widget/WidgetsManager.php';
        }

        if (!is_admin()) {
            // Front Class.
            require_once WP_SMS_DIR . 'includes/class-front.php';
        }

        // API class.
        require_once WP_SMS_DIR . 'includes/api/v1/class-wpsms-api-newsletter.php';
        require_once WP_SMS_DIR . 'includes/api/v1/class-wpsms-api-send.php';
        require_once WP_SMS_DIR . 'includes/api/v1/class-wpsms-api-webhook.php';
        require_once WP_SMS_DIR . 'includes/api/v1/class-wpsms-api-credit.php';
    }

    /**
     * @return \WP_SMS\Pro\Scheduled
     */
    public function scheduled()
    {
        return new \WP_SMS\Pro\Scheduled();
    }

    /**
     * @return \WP_SMS\Newsletter
     */
    public function newsletter()
    {
        return new \WP_SMS\Newsletter();
    }
}
