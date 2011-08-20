<?php

/**
 * @file
 * Theme settings for the Zentropy
 */
function zentropy_form_system_theme_settings_alter(&$form, &$form_state) {
  
  /**
   * General Settings
   */
  $form['zentropy_general'] = array(
    '#type' => 'fieldset',
    '#title' => t('General'),
  );
  $form['zentropy_general']['zentropy_feed_icons'] = array(
    '#type' => 'checkbox',
    '#title' => t('Display Feed Icons'),
    '#default_value' => theme_get_setting('zentropy_feed_icons'),
  );
  $form['zentropy_general']['zentropy_clear_registry'] = array(
    '#type' => 'checkbox',
    '#title' => t('Rebuild theme registry on every page.'),
    '#description' => t('During theme development, it can be very useful to continuously <a href="!link">rebuild the theme registry</a>. WARNING: this is a huge performance penalty and must be turned off on production websites.', array('!link' => 'http://drupal.org/node/173880#theme-registry')),
    '#default_value' => theme_get_setting('zentropy_clear_registry'),
  );

  /**
   * Floating tabs
   */
  $form['zentropy_tabs'] = array(
    '#type' => 'fieldset',
    '#title' => t('Tabs'),
  );

  $form['zentropy_tabs']['zentropy_tabs_float'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable floating tabs'),
    '#default_value' => theme_get_setting('zentropy_tabs_float'),
  );

  $form['zentropy_tabs']['zentropy_tabs_node'] = array(
    '#type' => 'checkbox',
    '#title' => t('Only for nodes'),
    '#default_value' => theme_get_setting('zentropy_tabs_node'),
  );

  /**
   * Breadcrumb settings
   */
  $form['zentropy_breadcrumb'] = array(
    '#type' => 'fieldset',
    '#title' => t('Breadcrumb'),
  );

  $form['zentropy_breadcrumb']['zentropy_breadcrumb_hideonlyfront'] = array(
    '#type' => 'checkbox',
    '#title' => t('Hide the breadcrumb if the breadcrumb only contains the link to the front page.'),
    '#default_value' => theme_get_setting('zentropy_breadcrumb_hideonlyfront'),
  );
  
  $form['zentropy_breadcrumb']['zentropy_breadcrumb_showtitle'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show page title on breadcrumb.'),
    '#default_value' => theme_get_setting('zentropy_breadcrumb_showtitle'),
  );

  $form['zentropy_breadcrumb']['zentropy_breadcrumb_separator'] = array(
    '#type' => 'textfield',
    '#title' => t('Breadcrumb separator'),
    '#default_value' => theme_get_setting('zentropy_breadcrumb_separator'),
  );

  /**
   * Google Analytics settings
   */
  $roles_all = user_roles();
  $roles_tracked = theme_get_setting('zentropy_ga_trackroles');

  $form['zentropy_ga'] = array(
    '#type' => 'fieldset',
    '#title' => t('Google Analytics'),
  );
  
  $form['zentropy_ga']['zentropy_ga_enable'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable Google Analytics'),
    '#default_value' => theme_get_setting('zentropy_ga_enable'),
  );
  
  $form['zentropy_ga']['zentropy_ga_trackingcode'] = array(
    '#type' => 'textfield',
    '#title' => t('Tracking code'),
    '#default_value' => theme_get_setting('zentropy_ga_trackingcode'),
  );
  
  $form['zentropy_ga']['zentropy_ga_trackroles'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Exclude roles'),
    '#options' => $roles_all,
    '#description' => t('Exclude the following roles from being tracked'),
    '#default_value' => !empty($roles_tracked) ? array_values((array) $roles_tracked) : array(),
  );
  
  $form['zentropy_ga']['zentropy_ga_anonimize'] = array(
    '#type' => 'checkbox',
    '#title' => t('Anonimize IP'),
    '#description' => t('Tells Google Analytics to anonymize the information sent by the tracker objects by removing the last octet of the IP address prior to its storage. Note that this will slightly reduce the accuracy of geographic reporting.'),
    '#default_value' => theme_get_setting('zentropy_ga_anonimize')
  );
}