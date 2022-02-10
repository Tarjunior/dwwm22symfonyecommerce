<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategoryRepository $categoryRepository,
                        ProductRepository $productRepository,
                        VideoRepository $videoRepository): Response
    {
        $products = $productRepository->findBy([],[
            'id' => 'DESC'
        ],
        6);

        $videos = $videoRepository->findBy([],[
            'id' => 'DESC',
        ],
        6);

        return $this->render('home/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'products' => $products,
            'videos' => $videos
        ]);
    }
}
