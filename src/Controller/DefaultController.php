<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
      * @Route("/",name="homepage")
      */

    public function chargeLibrairie()
    {
        $url = 'https://recrutement.dnd.fr/products.csv';
        $file_name = basename($url); 
        if(file_put_contents( $file_name, file_get_contents($url))) { 
            $message = "File downloaded successfully"; 
        } 
        else { 
            $message =  "File downloading failed."; 
        } 

        // decoding CSV contents
        $csv = file_get_contents('products.csv');

        $lines = explode(PHP_EOL, $csv);
        $array = array();
        foreach ($lines as $line) {
            $array[] = str_getcsv($line,";");
        }

        // save keys in a separate array
        $keys = array($array[0]);

        //remove the keys from the array
        array_splice($array, 0, 1);
        $data = array();
        
        
        //combine 2 arrays
        foreach($array as $value)
        {
            foreach($keys as $val)
            {
                $data[] = array_combine($val, $value);
            }
        }

        return $this->render('home.html.twig',['message'=>$message,'data'=>$data,'keys'=>$keys]);
    }
        
}

?>