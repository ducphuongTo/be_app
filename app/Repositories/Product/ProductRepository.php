<?php

namespace App\Repositories\Product;


use App\Models\Review;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use function PHPUnit\Framework\isEmpty;

/**
 * Class ProductRepository.
 */
class ProductRepository
{
    /**
     * @return string
     *  Return the model
     */

    public function getByCondition(Request $request){
        $size = $request->query("size");
        $result = Product::select("products.*", 'product_ratings.rate_point')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->leftjoin('product_ratings', 'product_ratings.product_id', '=', "products.id")
//            ->leftjoin('count_star', 'products.id', '=', 'count_star.id')
            ->with("discount")
            ->with("category")
            ->with("brand")
            ->orderBy('created_at', 'DESC')
            ->filter($request)
            ->sort($request)
            ->search($request)
            ->paginate($size);
        return $result;
    }
    public function getRecommendedPhones(){
        return Product::select("products.*",
            'product_ratings.rate_point')
            ->join('discounts','discounts.id','=','products.discount_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->leftjoin('product_ratings', 'product_ratings.product_id', '=', "products.id")
//            ->leftjoin('count_star', 'products.id', '=', 'count_star.id')
            ->with("discount")
            ->with("category")
            ->with("brand")
            ->where("products.category_id", '=', 1)
            ->selectRaw('products.product_price * (1 - discounts.discount_percent) as final_price')
            ->orderBy('final_price', 'asc')
            ->limit(10)
            ->get();
    }
    public function getRecommendedLaptops(){

        return Product::select("products.*",
            'product_ratings.rate_point')
            ->join('discounts','discounts.id','=','products.discount_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->leftjoin('product_ratings', 'product_ratings.product_id', '=', "products.id")
//            ->leftjoin('count_star', 'products.id', '=', 'count_star.id')
            ->with("discount")
            ->with("category")
            ->with("brand")
            ->where("products.category_id", '=', 2)
            ->selectRaw('products.product_price * (1 - discounts.discount_percent) as final_price')
            ->orderBy('final_price', 'asc')
            ->limit(10)
            ->get();
    }
    public function getRecommendedTablets(){

        return Product::select("products.*",
            'product_ratings.rate_point')
            ->join('discounts','discounts.id','=','products.discount_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->leftjoin('product_ratings', 'product_ratings.product_id', '=', "products.id")
//            ->leftjoin('count_star', 'products.id', '=', 'count_star.id')
            ->with("discount")
            ->with("category")
            ->with("brand")
            ->where("products.category_id", '=', 3)
            ->selectRaw('products.product_price * (1 - discounts.discount_percent) as final_price')
            ->orderBy('final_price', 'asc')
            ->limit(10)
            ->get();
    }
    public function getRecommendedAccessories(){

        return Product::select("products.*"
            ,'product_ratings.rate_point')
            ->join('discounts','discounts.id','=','products.discount_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->leftjoin('product_ratings', 'product_ratings.product_id', '=', "products.id")
//            ->leftjoin('count_star', 'products.id', '=', 'count_star.id')
            ->with("discount")
            ->with("category")
            ->with("brand")
            ->where("products.category_id", '=', 4)
            ->selectRaw('products.product_price * (1 - discounts.discount_percent) as final_price')
            ->orderBy('final_price', 'asc')
            ->limit(10)
            ->get();
    }

    public function getAllProduct(){
        return response()->json(Product::all());
    }

    public function getProductById($id)
    {
        $product = Product::select("products.*","discounts.discount_name","discounts.discount_percent","product_ratings.rate_point",
        "count_star.*")
            ->where("products.id", '=', $id)
            ->join('discounts','discounts.id','=','products.discount_id')
            ->leftjoin('product_ratings', 'product_ratings.product_id', '=', "products.id")
            ->join('count_star', 'products.id', '=', 'count_star.id')


            ->get();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product not found.'
            ], 400);
        }
        return $product;
    }


    public function checkIfUserIsAdmin()
    {
        $isAdmin = DB::table("users")
            ->where("id", auth()->id())
            ->value("is_admin");
        if ($isAdmin == true) {
            return true;
        }
        return false;
    }

    public function createProduct($request)
    {
        if($this->checkIfUserIsAdmin())
        {
            $request['status']="";
            $product = Product::create($request);
            $newProduct = Product::find($product["id"]);

            return response()->json([
                "message" => "Product create successfully",
                "data" => $newProduct
            ],200);
        }
        else{
            return response()->json([
                "message" => "You are not the admin",

            ],403);
        }
    }
    public function updateProduct(Request $request, $id)
    {

        if($this->checkIfUserIsAdmin()){
            $product = Product::find($id);
            if (is_null($product)) {
                return response()->json(['message' => 'Product Not Found'], 404);
            }
            $product->update($request->all());
            return response()->json([
                "message" => "Product create successfully",
                "data" => $product
            ],200);
        }
        else {
            return response()->json([
                "message" => "You are not the admin",

            ], 403);
        }
    }
    public function delete($id)
    {
        if($this->checkIfUserIsAdmin())
        {
            $product = Product::find($id);

            if (is_null($product)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product dose not exist'
                ]);
            }
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product are inactive'
            ], Response::HTTP_OK);
        }
        else{
            return response()->json([
                "message" => "You are not the admin",
            ], 403);
        }
    }
    public function restoreProduct($id){
        $product = Product::withTrashed()->where("id",$id)->restore();
        return response()->json([
            "message" => "Product are active",

        ]);
    }
    public function getListReviewByID($id){
//        $size = $request->query("size");

        return Review::where('product_id', $id)
            ->orderBy('id', 'desc')
            ->get();
//                    ->paginate($size);



    }
}
