<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Log;

class Usercreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lofm:user:create
                            {--email=: Email Address}
                            {--password=}
                            {--username=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
     
        $name = $this->option("username") ? $this->option("username") : $this->ask('What the name of the User');
        $password = $this->option("password") ? $this->option("password"): $this->secret("what the password");
        $email =$this->option("email") ? $this->option("email") : $this->ask("email");
        $user = new User();
        $user->name= $name;
        $user->password = bcrypt($password);
        $user->email = $email;
        $user->save();

    }
}
