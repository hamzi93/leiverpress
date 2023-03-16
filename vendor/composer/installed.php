<?php return array(
    'root' => array(
        'name' => '__root__',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => NULL,
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        '__root__' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => NULL,
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'htmlburger/carbon-fields' => array(
            'pretty_version' => 'v3.5.2',
            'version' => '3.5.2.0',
            'reference' => '8c9cd54a8e0d78b676c3ccdf6cb9da70f1b7418d',
            'type' => 'library',
            'install_path' => __DIR__ . '/../htmlburger/carbon-fields',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'twbs/bootstrap' => array(
            'pretty_version' => 'v5.3.0-alpha1',
            'version' => '5.3.0.0-alpha1',
            'reference' => 'cf9454caa00872899215603e5e036d9a824b1b11',
            'type' => 'library',
            'install_path' => __DIR__ . '/../twbs/bootstrap',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'twitter/bootstrap' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => 'v5.3.0-alpha1',
            ),
        ),
    ),
);
