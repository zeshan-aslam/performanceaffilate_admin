<?php 
return [ 
    'client_id' => 'AcVFjQCXVKKPaQZFCN8wu4ZspCqSfj9Zkxm2Pn_Gu6L89Kw2EoCgCEcQPxInXBLwONnecZs7A2mTqi2F',
	'secret' => 'EOTjreVO9esBmYM4FD_Ni33a6i5uaNC9wapemrWSO2cICgmbWGzY49zNJ-6bOZcmZT8J3VrYdMMJW1En',
    'settings' => array(
        'mode' => 'Live',
        'http.ConnectionTimeOut' => 1000,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'FINE'
    ),
];