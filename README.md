# Translate
Read file and send request to translate. Receive response put the file. 

## Install
Run command
>composer install

tests run
>./vendor/bin/phpunit --colors=auto --debug -v tests

Put src/config.php file follow command:
```
echo -e "<?php\n\
\n\
return [\n\
    'ibm' => [\n\
        'apiUri' => '',\n\
        'apiKey' => '',\n\
    ],\n\
];\n" > src/config.php
```

Put your config file apiUri and apiKey

script run example
>php src/index.php app:ibm-translate sometranslatefile.json ru en
if you don't want make a backup file use option --no-backup for example
>php src/index.php app:ibm-translate --no-backup sometranslatefile.json ru en
