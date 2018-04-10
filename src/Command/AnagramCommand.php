<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\{ ConsoleOutputInterface, OutputInterface };
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validation;
use App\{ AnagramCalculator, AnagramSource };
use App\Validator\AnagramSourceValidator;

/**
 * Class AnagramCommand
 * @package App\Command
 */
class AnagramCommand extends Command
{
    /**
     * @var QuestionHelper
     */
    private $questionHelper;

    /**
     * @var AnagramSourceValidator
     */
    private $validator;

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('app:anagram')
            ->setDescription('Check if a string\'s anagram is contained in another string')
            ->setHelp('If any arguments is not passed then application will ask to provide it')
            ->addArgument('a', InputArgument::OPTIONAL, 'String which will be anagram')
            ->addArgument('b', InputArgument::OPTIONAL, 'String to search in for anagram')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->questionHelper = $this->getHelper('question');
        $this->validator = new AnagramSourceValidator(Validation::createValidator());
    }

    /**
     * @param string $question
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    private function askForInput(string $question, InputInterface $input, OutputInterface $output)
    {
        return $this->questionHelper->ask($input, $output, new Question($question));
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output instanceof ConsoleOutputInterface ? $output->getErrorOutput() : $output);

        $anagram = AnagramSource::createFromString(
            $input->getArgument('a') ?: $this->askForInput('Please enter string which will be anagram: ', $input, $output)
        );

        $findIn  = $input->getArgument('b') ?: $this->askForInput('Please enter string to check in: ', $input, $output);

        $violations = $this->validator->validate($anagram);
        if (0 !== \count($violations)) {
            foreach ($violations as $violation) {
                $io->error($violation->getMessage());
            }
            return;
        }

        if (\strlen($findIn) > 1024) {
            $io->error('Argument too long, maximum allowed 1024');
            return;
        }

        $calculator = new AnagramCalculator();

        foreach ($calculator->getAnagramsForSource($anagram) as $permutation) {
            if (false !== stripos($findIn, $permutation)) {
                $io->block('true', null, 'fg=white;bg=green', '', true);
                return;
            }
        }

        $io->block('false', null, 'fg=white;bg=red', '', true);
    }
}