<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:show-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Afficher tous les utilisateurs avec leurs rôles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = \App\Models\User::select('id', 'name', 'email', 'role')->get();
        
        $this->info('Utilisateurs existants :');
        $this->table(
            ['ID', 'Nom', 'Email', 'Rôle'],
            $users->map(function ($user) {
                return [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role
                ];
            })
        );
        
        $this->info('Mot de passe par défaut : password');
    }
}
