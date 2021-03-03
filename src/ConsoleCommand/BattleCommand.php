<?php


namespace Emag\ConsoleCommand;


use Emag\Battle\Model\Turn;
use Emag\Battle\Service\BattleService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class BattleCommand extends Command
{
    protected BattleService $battleService;

    public function __construct(BattleService $battleService)
    {
        $this->battleService = $battleService;

        parent::__construct();
    }

    protected function configure()
    {
        $this->addOption('contestant1', 'c1', InputOption::VALUE_REQUIRED, 'The first contestant', 'Orderus')
            ->addOption('contestant2', 'c2', InputOption::VALUE_REQUIRED, 'The second contestant', 'Wild Beast')
            ->setName('emag:battle')
            ->setDescription('Emag Recruitment hero game!');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $battle = $this->battleService->fight($input->getOption('contestant1'), $input->getOption('contestant2'));
        /** @var \Emag\Battle\Model\Turn $turn */
        foreach ($battle as $turn) {
            if (!($turn instanceof Turn)) {
                $io->block($turn);
                continue;
            }
            $io->block($turn->getTurnLog()->getMessage());
        }

        return Command::SUCCESS;
    }
}
