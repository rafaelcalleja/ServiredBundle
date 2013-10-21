<?php
namespace RC\ServiredBundle\Service;

use Symfony\Component\Finder\Finder;

class CommandTools{


    protected $files = false;
    protected $directory;
    protected $trans_serializer;
    protected $pattern = '/(_transaction)/';

    public function __construct($cachedir, $trans_serializer){
        $this->directory = $cachedir;
        $this->trans_serializer = $trans_serializer;
    }

    public function getTransactions($type = 'transaction'){
        
        switch($type){
            case 'exception':
               return $this->getFilesException();
               break;
            case 'transaction':
            default:
                return $this->getFilesIncompletes();
                break;
        }

    }

    public function getFilesIncompletes(){
        return $this->getFiles('/(_transaction)/');
    }

    public function getFilesException(){

        return $this->getFiles('/(_exception)/');
    }

    protected function getFiles($pattern = '/(_transaction)/'){
        $this->pattern = $pattern;
        $files = Finder::create()->in($this->directory)->name($this->pattern)->files();

        return $files;
    }


    public function showListInfo($output, $type = 'transaction'){
        if(!$this->files) $this->files = $this->getTransactions($type);

        foreach($this->files as $file){
            $id = preg_replace($this->pattern, '', $file->getFilename());
            $transaction = $this->trans_serializer->restore($id);
            $output->writeln(sprintf('<info>ID: </info><comment>%s</comment> <info>Estado:</info><error>%s</error> <info>Importe:</info><comment>%s</comment> <info>Fecha:</info><comment>%s</comment>', $transaction->getDsOrder(), $transaction->getDsResponse(), $transaction->getDsAmount(), $transaction->getDsDate()));
        }

    }

    public function isEmpty($type = 'transaction'){
        if(!$this->files) $this->files = $this->getTransactions($type);
        return count($this->files) < 1;
    }
}