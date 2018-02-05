<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Psr\Log\LoggerInterface;

class CatalogController extends Controller
{
    private function _getProducts(){
        $bdd = array(
            array(  "name"=>"Ordinateur"  , 
                    "price"=>1000, 
                    "ref"=>"azerty", 
                    "desc"=>"
                            Un super ordinateur pour jouer et bosser 
                            ... ( Mais surtout pour jouer )
                    "
            ), 
            array(  
                    "name"=>"Nutella", 
                    "price"=>5, 
                    "ref"=>"palmoil", 
                    "desc"=>"
                        Tu te battrais pour du Nutella !
                    "
                ), 
            array(
                    "name"=>"Pizza", 
                    "price"=>8.5, 
                    "ref"=>"alloresto",
                    "desc"=>"
                        C'est fat, mais c'est trop bon !
                    "
            )
        );

        foreach( $bdd as $key => &$product){
            $product['url'] = $this->generateUrl(
                "product_route", 
                array("product_id"=>$key)
            );
        }

        return $bdd;
    }

    /**
    *@Route("/catalog", name="catalog_route")
    */
    public function displayCatalog(LoggerInterface $logger){
        $logger->info("invoke displayCatalog =)");
        return $this->render(
            "catalog.html.twig", 
            array( "catalog" => $this->_getProducts() )
        );
    }


    /**
    *@Route("/product/{product_id}", name="product_route", requirements={"product_id"="\d*"})
    */
    public function displayProduct(LoggerInterface $logger, $product_id = -1){

        if( $product_id == "" || $product_id == -1 ){
            return $this->redirectToRoute("catalog_route");
        }

        $catalog    = $this->_getProducts();
        $max        = count($catalog) - 1;
        
        if( $product_id > $max ){
            $logger->error("product id is beyond the max authorized: ".$product_id." !");
            throw $this->createNotFoundException('The product does not exist');
        }

        $product    = $catalog[$product_id];

        return $this->render("product.html.twig", array("product"=>$product));
    }
}