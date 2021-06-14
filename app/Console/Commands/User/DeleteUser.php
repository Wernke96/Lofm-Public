<?php

namespace App\Console\Commands\User;

use App\Lofm\Domain\Repositories\LofmUserRepository;
use App\Lofm\Infrastructure\Jenssegers\Repository\UserRepository;
use Illuminate\Console\Command;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete all soft deleted user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     *
     */
    public function handle(LofmUserRepository $userRepository)
    {
      $userRepository->forceDelete();
    }
}
