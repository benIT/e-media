<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use IMSGlobal\LTI\ToolProvider;
use IMSGlobal\LTI\ToolProvider\DataConnector;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;


class LTIRegisterConsumer extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:lti-register-consumer')
            ->setDescription('register a new lti consumer tool.')
            ->setHelp('This command registers a new lti consumer tool')
            ->addOption(
                'consumerKey',
                null,
                InputOption::VALUE_REQUIRED,
                'What is the consumer key (eg: \'testing.edu\')?'
            )
            ->addOption(
                'consumerName',
                null,
                InputOption::VALUE_REQUIRED,
                'What is the consumer name (eg: \Testing\')?'
            )
            ->addOption(
                'consumerSecret',
                null,
                InputOption::VALUE_REQUIRED,
                'What is the consumer secret (eg: \'ThisIsASecret!\')?'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Register a lti consumer tool',
            '============',
            '',
        ]);

        if (!$consumerKey = $input->getOption('consumerKey')) {
            throw new MissingMandatoryParametersException('consumerKey');
        }
        if (!$consumerName = $input->getOption('consumerName')) {
            throw new MissingMandatoryParametersException('consumerName');
        }
        if (!$consumerSecret = $input->getOption('consumerSecret')) {
            throw new MissingMandatoryParametersException('consumerSecret');
        }
        $output->writeln([
            'You are about to register a new LTI consumer with the following parameters:',
            'consumerKey: ' . $consumerKey,
            'consumerName: ' . $consumerName,
            'consumerSecret: ' . $consumerSecret,
        ]);
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('It that ok (y/n)?', false);
        $output->writeln('');

        if(!$input->getOption('no-interaction')){
            if (!$helper->ask($input, $output, $question)) {
                return;
            }
        }
        $dsn = sprintf('%s:host=%s;dbname=%s', getenv('DB_TYPE'), getenv('DB_HOST'), getenv('DB_NAME'));
        $db = new \PDO($dsn, getenv('DB_USER'), getenv('DB_PWD'));
        $dataConnector = DataConnector\DataConnector::getDataConnector('', $db);
        $consumer = new ToolProvider\ToolConsumer($consumerKey, $dataConnector);
        $consumer->name = $consumerName;
        $consumer->secret = $consumerSecret;
        $consumer->enabled = TRUE;
        $consumer->save();
        $sth = $db->prepare('SELECT * FROM lti2_consumer WHERE consumer_key256=:consumerKey');
        $sth->execute(['consumerKey' => $consumerKey]);
        $result = $sth->fetchAll();
        dump($result);
        if (!count($result)) {
            throw new \ErrorException('your consumer app has not been created!');
        } else {
            $output->writeln('Your consumer app has been created!');
        }
    }
}