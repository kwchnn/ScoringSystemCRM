<?php
namespace App\ScoringService;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

// название команды - это то, что пользователь вводит после "bin/console"
#[AsCommand(name: 'scoring:user',
    description: 'Получить сумму очков одного пользователя',
    hidden: false,
    aliases: ['scoring:user']
                            )]
class Console extends Command
{
    public function __construct(private UserRepository $user_repository)
    {

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // сконфигурировать аргумент
            ->addArgument('Id', InputArgument::REQUIRED, 'Id пользователя')
            // ...
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $score = $this->user_repository->findOneBy(['id' => $input->getArgument('Id')]);


        $output->writeln([
            "\nПолучение суммы очков пользователя по его id",
            '============',
            '',
        ]);

        $output->writeln(['Имя: ', $score->getFirstName(), "\nФамилия: ", $score->getLastName()]);

        $output->writeln(["\nСумма очков: ", $score->getScore()]);

        return Command::SUCCESS;
    }
}