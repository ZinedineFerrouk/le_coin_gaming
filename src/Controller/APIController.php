<?php

namespace App\Controller;

use App\Repository\JeuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    /**
     * @Route("game/listing/search", name="api_search", methods={"POST"})
     */
    public function search(Request $request, JeuRepository $repo): Response
    {

        // dd($repo->getSearchResult('Cyber'));
        if ($request->isXmlHttpRequest()) {

            $searchBar = $request->request->get('search');

            if (mb_strlen($searchBar) >= 3) {
                $results = $repo->getSearchResult($searchBar);
            }
        }
        
        return $this->json(['result' => $results ?? []]);
        
    }
}
