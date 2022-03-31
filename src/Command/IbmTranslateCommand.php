<?php

namespace src\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use src\Translate\App;


class IbmTranslateCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:ibm-translate';

    protected function configure(): void
    {
        $this->
            setDefinition(
                new InputDefinition([
                    new InputOption(
                        'no-backup',
                        null,
                        null,
                        'Must not do a backup'
                    ),
                    new InputArgument(
                        'filename',
                        InputArgument::REQUIRED,
                        'Name file to translate ex translate.json'
                    ),
                    new InputArgument(
                        'translate-from',
                        InputArgument::REQUIRED,
                        'Translate from ex en'
                    ),
                    new InputArgument(
                        'translate-to',
                        InputArgument::REQUIRED,
                        'Translate to ex it'
                    ),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // TEST OPTIONS
        $noBackupOption = $input->getOption('no-backup');
        $output->writeln('Option no-backup value ' . var_export($noBackupOption, true));

        $arguments = $input->getArguments();
        $output->writeln('Script running with arguments ' . var_export($arguments, true));
        $filename = $arguments['filename'];
        $translateFrom = $arguments['translate-from'];
        $translateTo = $arguments['translate-to'];
        

        $config = require_once 'src/config.php';
        $app = new App($config);

        if (!$noBackupOption) {
            $backupFilename = $app->createBackup($filename);
            if (!$backupFilename) {
                // can not create backup
                return Command::FAILURE;
            }

            $output->writeln("Backup file $backupFilename has been created.");
        }

        $app->run($filename, $translateFrom, $translateTo);

        $output->writeln("Translate has been successful. File $filename has been modified.");

        // return this if there was no problem running the command
        return Command::SUCCESS;
    }
}
