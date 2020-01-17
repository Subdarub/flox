<?php

  namespace App\Console\Commands;

  use Illuminate\Console\Command;

  class Init extends Command {

    protected $signature = 'flox:init {database?} {username?} {password?} {hostname=localhost} {port=3306}';
    protected $description = 'Create .env file, set the app key and fill database credentials';

    public function handle()
    {
      $this->createENVFile();
      $this->fillDatabaseCredentials();
      $this->setAppKey();
    }

    private function createENVFile()
    {
      if( ! file_exists('.env')) {
        $this->info('CREATING .ENV FILE');
        copy('.env.example', '.env');
      }
    }

    private function fillDatabaseCredentials()
    {
      $this->changeENV('DB_DATABASE', getenv('F_DB_DATABASE') );

      $this->changeENV('DB_USERNAME',getenv('F_DB_USERNAME') ) ;

      $this->changeENV('DB_PASSWORD',getenv('F_DB_PASSWORD') );

      $this->changeENV('DB_HOST',getenv('F_DB_HOST') );

      $this->changeENV('DB_PORT',getenv('F_DB_PORT') );

      $this->changeENV('TMDB_API_KEY',getenv('F_TMDB_API_KEY') );
      
      $this->changeENV('TRANSLATION',getenv('F_TRANSLATION') ) ;
      
      $this->changeENV('CLIENT_URI',getenv('F_CLIENT_URI') );
      
      $this->changeENV('TIMEZONE',getenv('F_TIMEZONE') );
      
      $this->changeENV('DB_CONNECTION',getenv('F_DB_CONNECTION') );
      
      $this->changeENV('APP_KEY',getenv('F_APP_KEY') );
      
      

    }

    private function setAppKey()
    {
      if( ! env('APP_KEY')) {
        $this->info('GENERATING APP KEY');
        $this->callSilent('key:generate');
      }
    }

    private function changeENV($type, $value)
    {
      file_put_contents('.env', preg_replace(
        "/$type=.*/",
        $type . '=' . $value,
        file_get_contents('.env')
      ));
    }
  }
