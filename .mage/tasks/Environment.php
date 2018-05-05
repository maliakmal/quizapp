<?php
namespace Task;

use Mage\Task\AbstractTask;

class Environment extends AbstractTask
{
  public function getName(){
    return 'Fixing file permissions';
  }

  public function run(){
    $env = $this->getParameter('env', 'production'); 
    $folders = array(
                      'test'=>'/home/admin/web/quizly.theseencompany.ga'
                    );
    $folder = $folders[$env];
    echo "Copying the environment variables from .env.".$env.' to .env ... ';
    $command = 'rm '.$folder.'/current/.env; cp '.$folder.'/current/.env.'.$env.' '.$folder.'/current/.env;';
    $result = $this->runCommandRemote($command);

    return $result;
  }
}