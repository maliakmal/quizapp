<?php
namespace Task;

use Mage\Task\AbstractTask;

class Migrations extends AbstractTask
{
  public function getName(){
    return 'Running migrations';
  }

  public function run(){

    $env = $this->getParameter('env', 'test'); 
    $folders = array(
                      'test'=>'/home/admin/web/quizly.theseencompany.ga'
                    );
    $folder = $folders[$env];
    echo "Migrating remaining migrations on ".$env.' ... ';
    $command = 'cd '.$folder.'/current; php artisan migrate;';
    $result = $this->runCommandRemote($command);

    return $result;
  }
}