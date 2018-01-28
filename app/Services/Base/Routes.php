<?php
/**
 *------------------------------------------------------
 * Routes.php 路由控制器
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @date      2016/5/26 11:17
 * @version   V1.0
 *
 */

namespace App\Services\Base;

use Route;

/**
 * 系统路由
 * 注：大部分的路由及控制器所执行的动作来说
 * 你需要返回完整的 Illuminate\Http\Response 实例或是一个视图
 */
class Routes
{
    private $_adminDomain;
    private $_mobileDomain;

    /**
     * 初始化，取得配置
     */
    public function __construct()
    {
        $this->_adminDomain = config('sys.sys_admin_domain');
        $this->_mobileDomain = config('sys.sys_mobile_domain');
    }

    /**
     * 后台的通用路由
     * 覆盖通用的路由一定要带上别名，且別名的值为module.class.action
     * 即我们使用别名传入了当前请求所属的module,controller和action
     */
    public function admin()
    {
        Route::group(
            ['domain' => $this->_adminDomain], function () {
            ### 登录页
            Route::any('login', 'Admin\Foundation\LoginController@index');
            ### 退出页
            Route::get('logout', 'Admin\Foundation\LoginController@logout');

            ### 登录验证
            Route::group(
                [], function () {
                $routeUri = request()->path();
                if ($routeUri == '/') {
                    //后台首页
                    Route::any('/', 'Admin\Foundation\IndexController@index');
                } else {
                    //后台通用路由
                    $routeArr = explode('/', $routeUri);
                    if (count($routeArr) > 1) {
                        $action = array_pop($routeArr);
                        $filePath = app_path() . '/Http/Controllers/Admin/' . implode(
                                '/', $routeArr) . 'Controller.php';
                        if (file_exists($filePath)) {
                            $controllerPath = 'Admin\\' . implode('\\', $routeArr) . 'Controller@' . $action;
                            Route::any(request()->path(), ['uses' => $controllerPath]);
                        }
                    }
                }
            });

            /**************************** 后台接口 ****************************/

            #============================ 代加工 ============================#
            //代加工管理
            Route::any(
                'remake/demand/list/{limit}/{page}/{sort}/{order}/complex', 'Admin\Remake\DemandController@lists');
            Route::any('remake/demand/detail/{id}', 'Admin\Remake\DemandController@detail');
            Route::any('remake/demand/update', 'Admin\Remake\DemandController@update');
            Route::any('remake/demand/audit/{id}', 'Admin\Remake\DemandController@audit');
            Route::any('remake/demand/auditOffer/{id}', 'Admin\Remake\DemandController@auditOffer');

            //代加订单
            Route::any('remake/order/list/{limit}/{page}/{sort}/{order}/complex', 'Admin\Remake\OrderController@lists');
            Route::any('remake/order/detail/{id}', 'Admin\Remake\OrderController@detail');
            Route::any('remake/order/update', 'Admin\Remake\OrderController@update');
            Route::any('remake/order/audit/{id}', 'Admin\Remake\OrderController@audit');
            Route::any('remake/order/auditOffer/{id}', 'Admin\Remake\OrderController@auditOffer');
            Route::any('remake/order/auditContract/{id}', 'Admin\Remake\OrderController@auditContract');
            Route::any('remake/order/auditProduction/{id}', 'Admin\Remake\OrderController@auditProduction');
            Route::any('remake/order/auditFinal/{id}', 'Admin\Remake\OrderController@auditFinal');

            //工厂
            Route::any('user/factory/list/{limit}/{page}/{sort}/{order}/complex', 'Admin\User\FactoryController@lists');
            Route::any('user/factory/detail/{id}', 'Admin\User\FactoryController@detail');
            Route::any('user/factory/update', 'Admin\User\FactoryController@update');
            Route::any('user/factory/audit/{id}', 'Admin\User\FactoryController@audit');

            #============================ 订单 ============================#
            //期货订单
            Route::any(
                'order/futures/list/{limit}/{page}/{sort}/{order}/complex', 'Admin\Order\FuturesController@lists');
            Route::any('order/futures/create', 'Admin\Order\FuturesController@create');
            Route::any('order/futures/changePrice', 'Admin\Order\FuturesController@changePrice');
            Route::any('order/futures/cancel', 'Admin\Order\FuturesController@cancel');
            Route::any('order/futures/confirmDeposit', 'Admin\Order\FuturesController@confirmDeposit');
            Route::any('order/futures/confirmArrivePort', 'Admin\Order\FuturesController@confirmArrivePort');
            Route::any('order/futures/confirmFinal', 'Admin\Order\FuturesController@confirmFinal');
            Route::any('order/futures/logistics', 'Admin\Order\FuturesController@logistics');
            Route::any('order/futures/detail/{orderNo}', 'Admin\Order\FuturesController@detail');

            //现货订单
            Route::any(
                'order/commodity/list/{limit}/{page}/{sort}/{order}/complex', 'Admin\Order\CommodityController@lists');
            Route::any('order/commodity/create', 'Admin\Order\CommodityController@create');
            Route::any('order/commodity/changePrice', 'Admin\Order\CommodityController@changePrice');
            Route::any('order/commodity/cancel', 'Admin\Order\CommodityController@cancel');
            Route::any('order/commodity/confirmReceipt', 'Admin\Order\CommodityController@confirmReceipt');
            Route::any('order/commodity/logistics', 'Admin\Order\CommodityController@logistics');
            Route::any('order/commodity/detail/{orderNo}', 'Admin\Order\CommodityController@detail');

            #============================ 财务 ============================#
            //商家结算
            Route::any(
                'finance/settlement/list/{limit}/{page}/{sort}/{order}/complex',
                'Admin\Finance\SettlementController@lists');
            Route::any('finance/settlement/detail/{id}', 'Admin\Finance\SettlementController@detail');
            Route::any('finance/settlement/payment', 'Admin\Finance\SettlementController@payment');

            //还款管理
            Route::any(
                'finance/repayment/list/{limit}/{page}/{sort}/{order}/complex',
                'Admin\Finance\RepaymentController@lists');
            Route::any('finance/repayment/affirmAccount', 'Admin\Finance\RepaymentController@affirmAccount');

            //授信管理
            Route::any(
                'finance/credit/list/{limit}/{page}/{sort}/{order}/complex', 'Admin\Finance\CreditController@lists');
            Route::any('finance/credit/create', 'Admin\Finance\CreditController@create');
            Route::any('finance/credit/update', 'Admin\Finance\CreditController@update');
            Route::any('finance/credit/delete/{id}', 'Admin\Finance\CreditController@delete');

            #============================ 用户 ============================#
            //用户管理
            Route::any('user/list/{limit}/{page}/{sort}/{order}/complex', 'Admin\User\InfoController@lists');
            Route::any('user/detail/{id}', 'Admin\User\InfoController@detail');
            Route::any('user/contractCommodity', 'Admin\User\InfoController@contractCommodity');

            //商家认证
            Route::any('user/store/list/{limit}/{page}/{sort}/{order}/complex', 'Admin\User\StoreController@lists');
            Route::any('user/store/detail/{id}', 'Admin\User\StoreController@detail');
            Route::any('user/store/audit/{id}', 'Admin\User\StoreController@audit');

            //买家认证
            Route::any('user/buyers/list/{limit}/{page}/{sort}/{order}/complex', 'Admin\User\BuyersController@lists');
            Route::any('user/buyers/detail/{id}', 'Admin\User\BuyersController@detail');
            Route::any('user/buyers/audit/{id}', 'Admin\User\BuyersController@audit');

            //团购管理
            Route::put('tuan/index', 'Admin\Activities\TuanController@index');
            Route::put('tuan/store', 'Admin\Activities\TuanController@store');
            Route::put('tuan/detail', 'Admin\Activities\TuanController@detail');
            Route::put('tuan/update', 'Admin\Activities\TuanController@update');
            Route::put('tuan/destroy', 'Admin\Activities\TuanController@destroy');
            Route::put('tuan/view', 'Admin\Activities\TuanController@view');
            Route::put('tuan/goods-search', 'Admin\Activities\TuanController@goodsSearch');

            //商品管理
            //==========================================商品分类=============================================//
            Route::any(
                'commodity/cate/list/{limit}/{page}/{sort}/{order}/complex', 'Admin\Commodity\CateController@index');
            Route::any('commodity/cate/detail/{id}', 'Admin\Commodity\CateController@detail');
            Route::any('commodity/cate/delete/{id}', 'Admin\Commodity\CateController@destroy');
            Route::any('commodity/cate/update', 'Admin\Commodity\CateController@update');
            Route::any('commodity/cate/all', 'Admin\Commodity\CateController@all');
            Route::any('commodity/cate/create', 'Admin\Commodity\CateController@store');
            Route::get('commodity/cate/get-child/{id}', 'Admin\Commodity\CateController@getChild');
            //==========================================商品信息=============================================//
            Route::any(
                'commodity/goods/list/{limit}/{page}/{sort}/{order}/complex',
                'Admin\Commodity\CommodityController@index');
            Route::any('commodity/goods/delete/{id}', 'Admin\Commodity\CommodityController@destroy');
            Route::any('commodity/goods/detail/{id}', 'Admin\Commodity\CommodityController@detail');
            Route::get('commodity/goods/attr/{id}', 'Admin\Commodity\CommodityController@getAttr');
            Route::get('commodity/goods/spec/{id}', 'Admin\Commodity\CommodityController@getSpec');
            Route::post('commodity/goods', 'Admin\Commodity\CommodityController@store');
            //==========================================商品SKU=============================================//
            Route::any(
                '/commodity/product/list/{limit}/{page}/{sort}/{order}/complex', 'Admin\Commodity\SkuController@index');
            Route::put('commodity/product/price/{id}/{price}', 'Admin\Commodity\SkuController@changePrice');
            Route::put('commodity/product/stock/{id}/{stock}', 'Admin\Commodity\SkuController@changeStock');
            Route::put('commodity/product/down/{id}', 'Admin\Commodity\SkuController@down');
            Route::put('commodity/product/up/{id}', 'Admin\Commodity\SkuController@up');
            //==========================================商品品牌=============================================//
            Route::get('commodity/brand/except-self/{id}', 'Admin\Commodity\BrandController@getExceptSelf');
            Route::get('commodity/brand/self/{id}', 'Admin\Commodity\BrandController@getSelf');
            Route::post('commodity/brands', 'Admin\Commodity\BrandController@adds');
            Route::post('commodity/brand', 'Admin\Commodity\BrandController@add');
            Route::put('commodity/brand/all/{id}', 'Admin\Commodity\BrandController@removeAll');
            Route::put('commodity/self-brand', 'Admin\Commodity\BrandController@removes');
            Route::get('commodity/brand/search/{id}/{name}', 'Admin\Commodity\BrandController@search');
            Route::get('commodity/brand/search/{id}', 'Admin\Commodity\BrandController@search');

            //==========================================商品分类属性=============================================//
            Route::get('commodity/cate/attr/{id}', 'Admin\Commodity\CateAttrController@cateAttr');
            Route::delete('commodity/cate/attr/select/{id}', 'Admin\Commodity\CateAttrController@removeSelect');
            Route::delete('commodity/cate/attr/select/value/{id}', 'Admin\Commodity\CateAttrController@removeSelectValue');
            Route::delete('commodity/cate/attr/text/{id}', 'Admin\Commodity\CateAttrController@removeText');
            Route::post('commodity/cate/attr/text', 'Admin\Commodity\CateAttrController@addText');
            Route::post('commodity/cate/attr/select', 'Admin\Commodity\CateAttrController@addSelect');
            //==========================================商品销售属性=============================================//
            Route::get('commodity/cate/spec/{id}', 'Admin\Commodity\CateSpecController@cateSpec');
            Route::delete('commodity/cate/spec/value/{id}', 'Admin\Commodity\CateSpecController@removeSpecValue');
            Route::delete('commodity/cate/spec/{id}', 'Admin\Commodity\CateSpecController@removeSpec');
            Route::post('commodity/cate/spec', 'Admin\Commodity\CateSpecController@addSpec');
            //==========================================商品基本属性=============================================//
            Route::post('commodity/attr', 'Admin\Commodity\AttrController@findOrCreateValue');
        });

        return $this;
    }

    /**
     * 移动端
     */
    public function mobile()
    {
        Route::group(
            ['middleware' => ['web'], 'domain' => $this->_mobileDomain], function () {

        });

        return $this;
    }

    /**
     * API接口
     */
    public function api()
    {
        //附件上传
        Route::any(
            'attachment/webupload',
            ['uses' => 'Api\AttachmentController@webUpload', 'as' => 'api.attachment.webupload']);
        //附件下载
        Route::any(
            'api/attachment/download',
            ['uses' => 'Api\AttachmentController@download', 'as' => 'api.attachment.download']);
        //区域相关
        Route::any('api/area/index', ['uses' => 'Api\AreaController@index', 'as' => 'api.area.index']);

        ## 修改购物车商品数量
        Route::any('api/order/cart/lists', 'Api\CartController@lists');
        Route::any('api/order/cart/modifyQuantity', 'Api\CartController@modifyQuantity');
        Route::any('api/order/cart/remove/{id}', 'Api\CartController@remove');

        ## 收货地址
        Route::any('api/user/consignee/storeAddress', 'Api\ConsigneeController@storeAddress');
        Route::any('api/user/consignee/updateAddress', 'Api\ConsigneeController@updateAddress');
        Route::any('api/user/consignee/getAddress', 'Api\ConsigneeController@getAddress');
        Route::any('api/user/consignee/setDefault/{id}', 'Api\ConsigneeController@setDefault');
        ## 关注喜欢
        Route::any('api/user/favorite/add', 'Api\FavoriteController@add');

        // 现货订单
        Route::any('api/order/commodity/cancel', 'Api\Order\CommodityController@cancel');
        Route::any('api/order/commodity/finish', 'Api\Order\CommodityController@finish');
        Route::any('api/order/commodity/payment', 'Api\Order\CommodityController@payment');
        Route::any('api/order/commodity/detail/{orderNo}', 'Api\Order\CommodityController@detail');

        return $this;
    }

}
