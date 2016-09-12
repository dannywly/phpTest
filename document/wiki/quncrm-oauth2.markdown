
内部文档，第一版本的群脉 App 授权方式说明。

### 用户授权

- 请求用户授权: https://api.quncrm.com/oauth2/authorize
- 获取access_token: https://api.quncrm.com/oauth2/access_token

**备注：** 目前采用了 https://api.quncrm.com 这个域名，由于open api不托管页面，所以需要在 nginx 的地方，将 https://api.quncrm.com/oauth2/authorize 转发至 https://www.quncrm.com/oauth2/authorize 提供用户登录的界面。

登录界面参考：![群脉oauth登录界面](http://git.augmentum.com.cn/scrm/Mobile-POS-iOS/uploads/7ccc3ceb0cf9e93c91a047380a22e5ad/2%E7%BE%A4%E8%84%89POS%E7%B3%BB%E7%BB%9F_%E7%AE%A1%E7%90%86%E5%91%98%E5%90%8E%E5%8F%B0%E7%99%BB%E5%BD%95.png)

#### 请求用户授权

- URL: https://api.quncrm.com/oauth2/authorize
- HTTP请求方式：GET/POST
- 请求参数：

    - app_id: 必选，类型为string，账户类型中的 Access Key
    - redirect_uri: 必选，类型为string，目前仅支持：https://api.quncrm.com/oauth2/default.html
    - state: 非必选，类型为string，用于保持请求和回调的状态，授权请求后原样带回给第三方。该参数可用于防止csrf攻击（跨站请求伪造攻击），建议第三方带上该参数，可设置为简单的随机数加session进行校验
    - display:  非必选，类型为 string，默认值为default，目前仅支持default
    - scope: 必选，类型为string，目前仅支持：scope_account
- 返回数据：

    - code: 类型为string，用于调用access_token，接口获取授权后的access token。
    - state: string, 如果传递参数，会回传该参数。

#### 获取access_token

- URL: https://api.quncrm.com/oauth2/access_token
- HTTP请求方式：POST
- 请求参数：

    - app_id: 必选，类型为string，账户类型中的 Access Key
    - app_secret：必选，类型为 string，账户类型中的 Secret Key
    - grant_type: 必选，类型为 string，填 authorization_code
- 返回数据：

    - access_token：开放API接口调用的凭证
    - expires_in：access_token接口调用凭证超时时间，单位（秒）

### 关于群脉自己App的授权说明

- 群脉的admin需要有创建群脉app的功能，可以在群脉的admin后台，创建群脉自己的mobile app，以及分配 app_id 和 app_secret。群脉自己的app和非群脉的app共用一套oauth2的API进行授权。
- oauth2返回的access_token，如果是群脉的app进行授权某一个账户，access_token则利用该账户下的 Access Key & Acess Secret 生成一个临时的 access_token，目前有效期半年。用户可以在 “**开发者中心**” 查看到 群脉App 以及针对这个App的授权access_token。
