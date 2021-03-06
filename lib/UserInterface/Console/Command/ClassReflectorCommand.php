<?php

namespace Phpactor\UserInterface\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Phpactor\Application\ClassReflector;
use Symfony\Component\Console\Input\InputArgument;
use Phpactor\Phpactor;
use Phpactor\UserInterface\Console\Logger\SymfonyConsoleCopyLogger;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;
use Phpactor\UserInterface\Console\Prompt\Prompt;
use Symfony\Component\Console\Helper\Table;
use Phpactor\UserInterface\Console\Dumper\DumperRegistry;

class ClassReflectorCommand extends Command
{
    /**
     * @var ClassReflector
     */
    private $reflector;

    /**
     * @var DumperRegistry
     */
    private $dumperRegistry;

    public function __construct(
        ClassReflector $reflector,
        DumperRegistry $dumperRegistry
    ) {
        parent::__construct();
        $this->reflector = $reflector;
        $this->dumperRegistry = $dumperRegistry;
    }

    public function configure()
    {
        $this->setName('class:reflect');
        $this->setDescription('Reflect a given class (file or FQN)');
        $this->addArgument('name', InputArgument::REQUIRED, 'Source path or FQN');
        Handler\FormatHandler::configure($this);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $reflection = $this->reflector->reflect($input->getArgument('name'));
        $this->dumperRegistry->get($input->getOption('format'))->dump($output, $reflection);
    }
}
