<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Category_Child;
use App\Models\Product;
use App\Models\Product_Detail;
use App\Models\Size_Product;
use App\Models\Product_Images;
use App\Models\ShopProfile;
use App\Models\Order_Detail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SellerProductController extends Controller
{
    public function index()
    {
        $username = session('username');
        $id_ShopProfile = ShopProfile::where('username', $username)->value('id');
        $products = Product::with('category_child')  // Assuming there's a relationship named 'category_child' in the Product model
                            ->where('id_shop', $id_ShopProfile)
                            ->get();
    
        foreach ($products as $product) {
            // Assuming there's a relationship between Product and Product_Detail
            $productDetails = Product_Detail::where('id_product', $product->id)->get();
            $totalProductNumber = 0;
            $totalQuantity = 0;
    
            foreach ($productDetails as $productDetail) {
                // Assuming there's a relationship between Product_Detail and Size_Product
                $sizeProducts = Size_Product::where('id_product_detail', $productDetail->id)->get();
                foreach($sizeProducts as $sizeProduct){
                    $totalProductNumber += $sizeProduct->product_number;
                }

                // Assuming there's a relationship between Product_Detail and Order_Detail
                $orderDetails = Order_Detail::where('id_product_detail', $productDetail->id)->get();
                
                foreach ($orderDetails as $orderDetail) {
                    $totalQuantity += $orderDetail->quantity;
                }
            }
    
            // You can add the totalProductNumber and totalQuantity to the $product object
            $product->totalProductNumber = $totalProductNumber;
            $product->totalQuantity = $totalQuantity;
            $product->productDetails = $productDetails;
        }
    
        return view('seller.product.index', compact('products'));
    }


    public function create()
    {
        $username = session('username');
        $id_ShopProfile = ShopProfile::where('username', $username)->value('id');
        $categories = Category_Child::where('id_shop',$id_ShopProfile)->get();

        return view('seller.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name_product' => 'required|string|max:255',
                'id_category_child' => 'required|exists:category_child,id',
                'description' => 'required|string',
                'product_details' => 'required|array|min:1',
                'product_details.*.name_product_detail' => 'required|string|max:255',
                'product_details.*.price' => 'required|numeric|min:0',
                'product_details.*.sizes' => 'required|array|min:1',
                'product_details.*.sizes.*' => 'nullable|string|max:255',
                'product_details.*.product_numbers' => 'required|array|min:1',
                'product_details.*.product_numbers.*' => 'required|integer|min:0',        
                'URL_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $username = session('username');
            $id_ShopProfile = ShopProfile::where('username', $username)->value('id');
            $product = Product::create([
                'name_product' => $request->input('name_product'),
                'id_shop'=> $id_ShopProfile,
                'id_category_child' => $request->input('id_category_child'),
                'description' => $request->input('description'),
            ]);

            $productDetails = $request->input('product_details');

            foreach ($productDetails as $detail) {
                // Tạo một chi tiết sản phẩm mới và gán các giá trị từ dữ liệu yêu cầu
                $productDetail = new Product_Detail();
                $productDetail->name_product_detail = $detail['name_product_detail'];
                $productDetail->price = $detail['price'];
                $product->productDetails()->save($productDetail); // Lưu chi tiết sản phẩm vào cơ sở dữ liệu

                // Tạo các kích thước và số lượng sản phẩm cho chi tiết sản phẩm mới
                $sizes = $detail['sizes'];
                $productNumbers = $detail['product_numbers'];

                foreach ($sizes as $key => $size) {
                    // Tạo một kích thước sản phẩm mới và gán các giá trị từ dữ liệu yêu cầu
                    $sizeProduct = new Size_Product();
                    $sizeProduct->size = $size;
                    $sizeProduct->product_number = $productNumbers[$key];
                    $productDetail->productSizes()->save($sizeProduct); // Lưu kích thước sản phẩm vào cơ sở dữ liệu
                }

                if ($request->hasFile('URL_image')) {
                    // Xử lý tập tin hình ảnh và lưu nó vào thư mục lưu trữ
                    $imagePath = $request->file('URL_image')->store('profile_images', 'public');

                    // Tạo một hình ảnh sản phẩm mới và gán đường dẫn hình ảnh
                    $productImage = new Product_Images();
                    $productImage->url_image = Storage::url($imagePath);

                    // Lưu hình ảnh sản phẩm vào cơ sở dữ liệu
                    $productDetail->productImage()->save($productImage);
                }
            }

            // Hiển thị thông báo thành công nếu không có lỗi xảy ra
            Session::flash('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $err) {
            // Xử lý các ngoại lệ và hiển thị thông báo lỗi
            Session::flash('error', 'Thêm sản phẩm lỗi');
            \Log::error($err->getMessage());
            return redirect()->back()->withInput();
        }

        // Chuyển hướng đến trang danh sách sản phẩm sau khi thêm thành công
        return redirect()->intended('/seller1/products/list');
    }

}
