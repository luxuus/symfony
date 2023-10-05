<?php

namespace App\Command;

use App\Repository\MovieRepository;
use App\Service\Transformer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:find:movie',
    description: 'Add a short description for your command',
)]
class FindMovieCommand extends Command
{
    public function __construct(private Transformer $transformer, private MovieRepository $movieRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::REQUIRED)
            ->setAliases(['movie:find'])
            ->setHelp('...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('title');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }
        $this->transformer->persist($arg1);
        $movie = $this->movieRepository->findOneByTitle($arg1);


        $io->title('Détail du film');
        $io->table([
            'Id',
            'Title',
            'MPAA restriction'
            ], [
                [$movie->getId(), $movie->getTitle(), $movie->getRated()]
        ]);

        return Command::SUCCESS;
    }

}
