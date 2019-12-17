<?php
  /**
   * Pantheon drush alias file, to be placed in your ~/.drush directory or the aliases
   * directory of your local Drush home. Once it's in place, clear drush cache:
   *
   * drush cc drush
   *
   * To see all your available aliases:
   *
   * drush sa
   *
   * See http://helpdesk.getpantheon.com/customer/portal/articles/411388 for details.
   */


  $aliases['live'] = array(
    'uri' => 'live-si8.pantheonsite.io',
    'db-url' => 'mysql://pantheon:86af63107ff747bcaa27bb665f3baac0@dbserver.live.eef9ff8e-ba9f-4c1a-b42e-7111476acc3e.drush.in:10012/pantheon',
    'db-allows-remote' => TRUE,
    'remote-host' => 'appserver.live.eef9ff8e-ba9f-4c1a-b42e-7111476acc3e.drush.in',
    'remote-user' => 'live.eef9ff8e-ba9f-4c1a-b42e-7111476acc3e',
    'ssh-options' => '-p 2222 -o "AddressFamily inet"',
    'path-aliases' => array(
      '%files' => 'code/sites/default/files',
      '%drush-script' => 'drush',
    ),
  );
  $aliases['test'] = array(
    'uri' => 'test-si8.pantheonsite.io',
    'db-url' => 'mysql://pantheon:c4b36afa1e64460aa50b92cab4f30d6f@dbserver.test.eef9ff8e-ba9f-4c1a-b42e-7111476acc3e.drush.in:10159/pantheon',
    'db-allows-remote' => TRUE,
    'remote-host' => 'appserver.test.eef9ff8e-ba9f-4c1a-b42e-7111476acc3e.drush.in',
    'remote-user' => 'test.eef9ff8e-ba9f-4c1a-b42e-7111476acc3e',
    'ssh-options' => '-p 2222 -o "AddressFamily inet"',
    'path-aliases' => array(
      '%files' => 'code/sites/default/files',
      '%drush-script' => 'drush',
    ),
  );
  $aliases['dev'] = array(
    'uri' => 'dev-si8.pantheonsite.io',
    'db-url' => 'mysql://pantheon:ed9db62d00e445c6b5159c5b307b827b@dbserver.dev.eef9ff8e-ba9f-4c1a-b42e-7111476acc3e.drush.in:10037/pantheon',
    'db-allows-remote' => TRUE,
    'remote-host' => 'appserver.dev.eef9ff8e-ba9f-4c1a-b42e-7111476acc3e.drush.in',
    'remote-user' => 'dev.eef9ff8e-ba9f-4c1a-b42e-7111476acc3e',
    'ssh-options' => '-p 2222 -o "AddressFamily inet"',
    'path-aliases' => array(
      '%files' => 'code/sites/default/files',
      '%drush-script' => 'drush',
    ),
  );
