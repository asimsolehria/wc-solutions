<!-- These are the below email class that is used in WooCommerce Subscription. -->

$email_classes['WCS_Email_New_Renewal_Order']              = new WCS_Email_New_Renewal_Order();
$email_classes['WCS_Email_New_Switch_Order']               = new WCS_Email_New_Switch_Order();
$email_classes['WCS_Email_Processing_Renewal_Order']       = new WCS_Email_Processing_Renewal_Order();
$email_classes['WCS_Email_Completed_Renewal_Order']        = new WCS_Email_Completed_Renewal_Order();
$email_classes['WCS_Email_Customer_On_Hold_Renewal_Order'] = new WCS_Email_Customer_On_Hold_Renewal_Order();
$email_classes['WCS_Email_Completed_Switch_Order']         = new WCS_Email_Completed_Switch_Order();
$email_classes['WCS_Email_Customer_Renewal_Invoice']       = new WCS_Email_Customer_Renewal_Invoice();
$email_classes['WCS_Email_Cancelled_Subscription']         = new WCS_Email_Cancelled_Subscription();
$email_classes['WCS_Email_Expired_Subscription']           = new WCS_Email_Expired_Subscription();
$email_classes['WCS_Email_On_Hold_Subscription']           = new WCS_Email_On_Hold_Subscription


<!-- WCS_Email_New_Switch_Order and WCS_Email_New_Switch_Order these are the only class that is sending email to admin.

Below are actions that are used in WCS_Email_New_Switch_Order and WCS_Email_New_Switch_Order to send emails. -->


'woocommerce_order_status_pending_to_processing_renewal_notification'
'woocommerce_order_status_pending_to_completed_renewal_notification'
'woocommerce_order_status_pending_to_on-hold_renewal_notification'
'woocommerce_order_status_failed_to_processing_renewal_notification'
'woocommerce_order_status_failed_to_completed_renewal_notification'
'woocommerce_order_status_failed_to_on-hold_renewal_notification'
'woocommerce_order_status_cancelled_to_processing_renewal_notification'
'woocommerce_order_status_cancelled_to_completed_renewal_notification'
'woocommerce_order_status_cancelled_to_on-hold_renewal_notification'
'woocommerce_subscriptions_switch_completed_switch_notification'


<!-- FILE-CONTENT-STARTS -->

<?php
/*
Plugin Name: WooCommerce Subscriptions No $0 Emails
Plugin URI:
Description: Do not send a processing or completed renewal order emails to customers when the order or renewal is for $0.00.
Author:
Author URI:
Version: 0.1
*/

function eg_maybe_remove_email( $order_id ){

    $order = new WC_Order( $order_id );

    if ( 0 == $order->get_total() ) {

        $email_class = array();
        
        switch( current_filter() ) {
            case 'woocommerce_order_status_completed_renewal_notification':
                $email_class[] = 'WCS_Email_Completed_Renewal_Order';
                break;
            case 'woocommerce_order_status_pending_to_processing_renewal_notification':
                $email_class[] = 'WCS_Email_Processing_Renewal_Order';
                $email_class[] = 'WCS_Email_New_Renewal_Order';
                break;
            case 'woocommerce_order_status_failed_renewal_notification':
                $email_class[] = 'WCS_Email_Customer_Renewal_Invoice';
                $email_class[] = 'WCS_Email_New_Renewal_Order';
                break;
            case 'woocommerce_order_status_pending_to_completed_renewal_notification':
            case 'woocommerce_order_status_pending_to_on-hold_renewal_notification':
            case 'woocommerce_order_status_failed_to_processing_renewal_notification':
            case 'woocommerce_order_status_failed_to_completed_renewal_notification':
            case 'woocommerce_order_status_failed_to_on-hold_renewal_notification':
            case 'woocommerce_order_status_cancelled_to_processing_renewal_notification':
            case 'woocommerce_order_status_cancelled_to_completed_renewal_notification':
            case 'woocommerce_order_status_cancelled_to_on-hold_renewal_notification':
                $email_class[] = 'WCS_Email_New_Renewal_Order';
                break;
            case 'woocommerce_subscriptions_switch_completed_switch_notification':
                $email_class[] = 'WCS_Email_New_Switch_Order';
                break;
            default:
                $email_class[] = array();
                break;
        }

        if ( ! empty( $email_class ) ) {
            foreach ( $email_class  as $key => $email ) {
                remove_action( current_filter(), array( WC()->mailer()->emails[ $email ], 'trigger' ) );
            }
        }

    }
    
}

//customer
add_action( 'woocommerce_order_status_completed_renewal_notification',             'eg_maybe_remove_email', 0, 1 );
add_action( 'woocommerce_order_status_pending_to_processing_renewal_notification', 'eg_maybe_remove_email', 0, 1 );
add_action( 'woocommerce_order_status_failed_renewal_notification',                'eg_maybe_remove_email', 0, 1 );

//admin
add_action( 'woocommerce_order_status_pending_to_completed_renewal_notification',    'eg_maybe_remove_email', 0, 1  );
add_action( 'woocommerce_order_status_pending_to_on-hold_renewal_notification',      'eg_maybe_remove_email', 0, 1  );
add_action( 'woocommerce_order_status_failed_to_processing_renewal_notification',    'eg_maybe_remove_email', 0, 1  );
add_action( 'woocommerce_order_status_failed_to_completed_renewal_notification',     'eg_maybe_remove_email', 0, 1  );
add_action( 'woocommerce_order_status_failed_to_on-hold_renewal_notification',       'eg_maybe_remove_email', 0, 1  );
add_action( 'woocommerce_order_status_cancelled_to_processing_renewal_notification', 'eg_maybe_remove_email', 0, 1  );
add_action( 'woocommerce_order_status_cancelled_to_completed_renewal_notification',  'eg_maybe_remove_email', 0, 1  );
add_action( 'woocommerce_order_status_cancelled_to_on-hold_renewal_notification',    'eg_maybe_remove_email', 0, 1  );
add_action( 'woocommerce_subscriptions_switch_completed_switch_notification',        'eg_maybe_remove_email', 0, 1  );