
## 安装

- git clone 到本地
- 执行 `composer install`,`npm install`创建好数据库
- 配置 **.env** 中数据库连接信息,没有.env请复制.env.example命名为.env
- 执行 `php artisan key:generate`
- 执行 `php artisan migrate`
- 执行 `php artisan db:seed`
- storage下所有目录 和 bootstrap/cache 目录应该是可写的
- 键入 '域名/admin/login'(后台登录)
- 用户名：user1；密码：123456

- 生成文档 apidoc -i app/Http/Controllers/Api/V1 -o public/apidoc
- api文档在public/apidoc里面, 也可以看上面的 `在线api文档`


####注意第一次安装的时候要  


## USEFUL LINK
- dingo/api [https://github.com/dingo/api](https://github.com/dingo/api)
- transformer [fractal](http://fractal.thephpleague.com/)
- apidoc [apidocjs](http://apidocjs.com/)
- 参考文章 [http://oomusou.io/laravel/laravel-architecture](http://oomusou.io/laravel/laravel-architecture/)
- debug rest api [postman](https://chrome.google.com/webstore/detail/postman/fhbjgbiflinjbdggehcddcbncdddomop?hl=en)

