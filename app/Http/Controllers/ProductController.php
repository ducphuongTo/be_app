<?php

namespace App\Http\Controllers;
use App\Repositories\Product\ProductRepository;
use App\Http\Requests\Product\ProductCreateRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $productRepository;
    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }

    public function getByCondition(Request $request){

        $allProducts = $this->productRepository->getByCondition($request);

        return $allProducts;
    }

    public function getRecommendedPhones(){
        $recommendedPhones = $this->productRepository->getRecommendedPhones();
        return $recommendedPhones;
    }
    public function getRecommendedLaptops(){
        $recommendedLaptops = $this->productRepository->getRecommendedLaptops();
        return $recommendedLaptops;
    }
    public function getRecommendedTablets(){
        $recommendedTablets = $this->productRepository->getRecommendedTablets();
        return $recommendedTablets;
    }
    public function getRecommendedAccessories(){
        $recommendedTablets = $this->productRepository->getRecommendedAccessories();
        return $recommendedTablets;
    }

    public function index(){
        $products = $this->productRepository->getAllProduct();
        return $products;
    }
    public function show($id){
         $products = $this->productRepository->getProductById($id);
         return $products;
    }

    public function store(ProductCreateRequest $request){
        $validated = $request->validated();
        return $this->productRepository->createProduct($validated);

    }
    public function update(Request $request,$id){
        return $this->productRepository->updateProduct($request,$id);
    }
    public function delete($id){
        return  $this->productRepository->delete($id);
    }
   public function restore($id){
        return $this->productRepository->restoreProduct($id);
   }
    public function getListReviewByID(Request $request){
        return $this->productRepository->getListReviewByID($request->id);
    }

}
