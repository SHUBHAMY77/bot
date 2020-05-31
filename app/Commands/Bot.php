<?php

namespace App\Commands;

use DOMDocument;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Filesystem\Filesystem;

class Bot extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = '__start {website?}{string?}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'sracping data from web site';



    protected $website;
    protected $string;
    protected $file;
    protected $matches;
    

    public function __construct( Filesystem $file)
    {
        parent::__construct();
        $this->file =$file;  
    }
   
   
 public function handle()
    {
       
       
       $this->CheckUrl();
       $this->MakeDirectory();
       

    }
    
    function CheckUrl(){
        $this->website = $this->argument('website');
        if(!$this->argument('website')){
            $this->website = $this->ask('please enter your full domain name');
            
        }

       
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->website);
        curl_setopt($ch,CURLOPT_POST,false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        
        
        $html = curl_exec($ch);  
          curl_close($ch);

       
          $this->string = $this->string;
          if(! $this->argument('string')){
         $this->string = $this->ask("please enter the string you want to match");
         
        }
        

      //  $matches = '';
        $pattern = "/$this->string/";
        preg_match_all($pattern,$html,$matches);
        var_dump($matches);
        

    } 
     
      
         
    function MakeDirectory(){
        
        $path = (getcwd().'/profile');
        if (! $this->file->isDirectory($path)) {
            $this->file->makeDirectory($path);
        }
        $box = $this->matches;
              
        $this->file->put($path.'/detail.txt',$box);
    }


}
