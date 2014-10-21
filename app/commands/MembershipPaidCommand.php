<?php

use Illuminate\Console\Command;
use Suenos\Payments\PaymentRepository;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MembershipPaidCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'suenos:membership-paid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membership paid for all users by month.';
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;

    /**
     * Create a new command instance.
     *
     * @param PaymentRepository $paymentRepository
     * @return \MembershipPaidCommand
     */
    public function __construct(PaymentRepository $paymentRepository)
    {
        parent::__construct();
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->paymentRepository->membershipFee();
        $this->info('Membership paid done!!');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            //array('example', InputArgument::REQUIRED, 'An example argument.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            //array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
        );
    }

}
