# 脉SCRM微信支付

> 注：本文档只针对微信支付， 文中所说一切关于支付的概念，仅对微信有效

## 参考文档

- [Weconnect API](http://git.augmentum.com.cn/scrm/we-connect/blob/develop/docs/trade_api.md)
- [公众号支付](https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=7_1)
- [扫码支付](https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_1)

## 支付配置

### 在脉SCRM开通支付

在**管理中心** -> **渠道管理** -> **微信公众号** 选择一个具有支付功能的微信公众号去开通支付功能

### 支付设置提醒
系统中存在一些模块依赖于支付功能， 当我们激活模块后, 如果没有开通微信支付, 我们提供通用机制，提醒用户去开通微信支付, 如图所示:
![Payment setting remind](images/payment_tip.png)

***Notice***: 只需要在模块的`static/config.json`文件中添加 `"hasPayment": true `即可开启这种通用机制.

### 注册支付通知

**需要在系统的两处注册支付通知事件**:

   + 在模块激活时注册
   + 在开通支付时注册


#### 在模块激活时注册

模块的***Install.php***中的`run`方法会在模块激活时被执行， 可以在`run`中添加如下代码用于注册支付通知:
```php
//Subscribe weconnect payment notification
Yii::$app->webhookEvent->subscribePaymentNotification($accountId, $moduleName);
```
#### 在开通支付时注册
在**管理中心**成功开通支付之后， 会trigger出一个`open_payment`事件出来，数据格式如下:
```
{
    "type": "open_payment",
    "account_id": ObjectId("55bb296dd6f97f23688b4567"),
    "channel_id": "54d9c155e4b0abe717853ee1"
}
```

需要在模块下面的`events/PortalEvent.php`中监听相应的事件， 以**store**模块为例:
在`backend\modules\store\events\PortalEvent.php`中添加如下代码:
```php
<?php
namespace backend\modules\store\events;

use Yii;
use backend\components\BaseEvent;
use backend\utils\LogUtil;
use backend\models\WebhookEvent;

class PortalEvent extends BaseEvent
{
    public function handle($data)
    {
        parent::handle($data);

        if (empty($data['type'])) {
            LogUtil::error(['PortalEvent' => 'missing parameter', 'data' => $data], 'store');
            return;
        }

        switch ($data['type']) {
            case 'open_payment':
                $this->subscribePaymentNotification($data);
                break;
        }
    }

    private function subscribePaymentNotification($notification)
    {
        Yii::$app->webhookEvent->subscribeMsg('store', $notification['channel_id'], WebhookEvent::DATA_TYPE_MSG_PAYMENT, time());
    }
}

```

#### 为什么需要在两处注册

在我们激活模块时， 可能账号下面并不存在一个开通支付功能的微信公众号， 那么在模块激活的时候就不能成功注册， 因此需要在模块激活之后再去开通支付， 然后监听`open_payment`事件.

那么只去监听`open_payment`事件呢？ 不行， 因为有可能在系统中已经开通了微信支付功能，所以不会再trigger出`open_payment`事件.

所以为了保证成功注册支付通知， 确保在这两处做了正确的处理.

### 支付目录配置
因为可能存在多个模块依赖于支付功能，但公众号能够设置的支付目录是有限的(3个)，所以我们为模块设置了统一的支付目录。
我们统一的规则为:
1. 唤起支付的页面的url路径为: `${domain}/webapp/common/pay/${module}`
2. 在`${module}/webapp/controllers/${module}Controller.php`中添加`actionPay`用于渲染支付页面

#### 在公众号内设置支付安全域名
**注意事项:**
1. 发起支付的页面目录必须于设置的精确匹配, 子目录无法正常调用支付
2. 头部必须要包含http或https, 需细化到二级或三级目录，且以左斜杠`/`结尾,
   - 如: `https://staging.quncrm.com/webapp/common/pay/`

我们统一的支付域名可以通过: ***管理中心*** -> ***渠道管理***， 选择已开通微信支付的公众号， 点击**编辑**, 显示如图:

![Payment records list](images/payment_dir_setting.png)

可以看到支付授权目录.

## 支付流程

1. 选择商品下单
2. 在脉SCRM系统内生成订单信息
3. 调用统一的微信支付API获取支付签名
    - $signature = Yii::$app->tradeService->pay($order);
4. 网页端调起支付API
    - https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=7_7&index=6
5. 接收支付通知, 处理订单状态

### 支付API详解

使用 `$signature = Yii::$app->tradeService->pay($order);` 来获取支付签名，唯一参数是`$order`, 类型是***array***, 所需要的field如下表:

| field | required | default | description |
|:-----:|:--------:|:-------:|:-----------|
| accountId | yes | none | The MaiScrm account id |
| subject | yes | none | The subject of order |
| totalFee | yes | none | The price of order, use cent as unit |
| metadata | yes | none | The extra message of order, eg. channelId, detailUrl, isTest, orderNumber |
| openId | yes | none | The openId of user |
| timeExpire | no | 3600s | The order expire time, if provided, use millisecond, for exapmle:  1472179274653|
| userIp | no | Yii::$app->request->userIp | The user request ip |
| detail | no | '' | The order detail message |
|tradeType | no | JSAPI | The trade type, default JSAPI |
| outTradeNo | no | new MongoId() |  If not provide, we will use MongoId to ensure unique, if provided, pls make sure it's uniqueness |

得到的signature结构如下:
```
[
    'timeStamp' => 1472179274,
    'nonceStr'  => 'nonceStr',
    'package'   => 'prepay_id=prepayId',
    'appId'     => 'appId',
    'signType'  => 'MD5',
    'paySign'   => 'paySign'
]
```

### 接收支付通知
成功注册支付通知之后，每当用户发起一笔支付请求时，系统都会收到对应的支付通知, 用于处理对应的订单。
为了处理支付通知，需在模块的`events/WeconnectEvent.php`中的`handle`方法中监听`payment_notification`事件， 示例如下:
```php
<?php
namespace backend\modules\store\events;

use Yii;
use backend\components\BaseEvent;
use backend\models\WebhookEvent;

class WeconnectEvent extends BaseEvent
{
    public function handle($data)
    {
        parent::handle($data);

        $notification = $data['data'];
        $channel = $data['channel'];

        if (empty($notification['type'])) {
            return;
        }

        switch ($notification['type']) {
            case WebhookEvent::DATA_TYPE_MSG_PAYMENT:
                // Weconnect payment notification
                $this->handlePaymentNotification($notification);
                break;
        }
    }

    /**
     * Handle weconnect payment notifcation
     * @param  array $notification The notification content
     */
    private function handlePaymentNotification($notification)
    {
        //TODO
    }
}
```

其中支付通知的数据格式如下:
```
{
    "type": "msg",
    "channel": {
      "id":"54d8525f0cf2b6e3041e124b",
      "name":"QunCRM",
      "type":"online",
      "social":"wechat/alipay"
    },
    "data": {
      "type": "payment_notification",
      "channelType": "WECHAT / ALIPAY",
      "quncrmAccountId": "群脉账号",
      "tradeType": "支付类型 JSAPI(公众号支付)，NATIVE(扫码支付)",
      "sellerId":"微信商户ID / 卖家支付宝账户号",
      "buyerId":"买家微信openId / 买家支付宝账户号",
      "spbillCreateIp": "买家终端IP",
      "subject": "订单标题",
      "detail": "订单详情",
      "outTradeNo": "商户订单号",
      "tradeNo": "微信订单号 / 支付宝订单号",
      "totalFee": "订单金额",
      "createTime": "订单创建时间",
      "timeExpire": "订单过期时间",
      "paymentTime": "订单付款时间",
      "extension": {
        "wechatAppId": "微信公众号ID",
        "buyerNickname": "买家昵称(未订阅用户值为unknown)",
        "prepayId": "微信预支付交易会话标识",
        "codeUrl": "二维码链接, tradeType为NATIVE是有返回，可将该参数值生成二维码展示出来进行扫码支付"
      },
      "metadata": {}, // 订单附加信息
      "tradeStatus": "订单状态",
      "tradeStateDesc": "交易状态描述",
      "failureCode": "微信/支付宝 错误代码",
      "failureMsg": "微信/支付宝 错误代码描述"
    }
}
```

### 渠道支付记录
如何查看支付记录呢？我们在 **渠道** -> **渠道支付记录** 中可以看到当前公众号的支付记录，为了能够显示出来，
![Payment records list](images/payment_list.png)

需要在调用统一下单API时,在请求的数据中添加channelId字段, 格式如下:
```
{
    "metadata": {
        "isTest": false,
        "channelId": "552b58370cf2b1c155831b9a",
        "orderNumber": "P2016070400000006",
        "detailUrl": "https://www.quncrm.com/reservation/view/order/577a2073fa2f94c53c8b4665"
    }
}
```
***channelId***: 标识出了当前支付记录应该在哪个公众号下面显示。 **注意：只有支付成功的记录才会被显示出来**

***isTest***: 用于表明这是一个正常的支付单，还是用于测试支付功能的测试单

***orderNumber***: 业务订单号

***detailUrl***: 用于连接到具体订单的详情页，如果detailUrl不为空，那么业务订单号将会以超链接的形式显示，点击可以跳转到detailUrl指定的地址。

## 关于代支付
**代支付**: 公众号本身不具备支付功能， 但是可以通过在脉SCRM中的配置，在公众号内实现支付。

例如： 存在公众号A, channelId为`channelId_A`, 公众号B的 channelId为`channelId_B`. 公众号A具备支付功能， 公众号B不具备支付功能。 那么我们可以通过配置， 让公众号A代替公众号B实现支付，然后可以在公众号B中正常支付， **但是钱会支付到公众号A中**。

值得注意的是，***如果在系统内采用的是`代支付`, 需要获取用户对应的实际具备支付能力的公众号的`openId`***.

存在用户*user_1*, 对应公众号A的openId为 *openId_A*, 对应公众号B的oepnId为*openId_B*, *user_1*在公众号B下面购物商品下单， 需要在调用统一下单API之前获取对应公众号A的openId *openId_A*.

可以通过做*pay oauth*来获取:
`{domain}/api/mobile/pay?channelId=${channelId}&redirect=${redirectUrl}`

那么redirectUrl中会添加额外的参数:  *channelId*, *openId*,
  - channelId的值为pay oauth时传递的channelId值
  - openId的值就是公众号A下面的*openId_A*

**需要注意:** 系统对于手机用户做了权限验证, 如果手机用户访问的链接带有参数*channelId*和*openId*, 那么就会将该参数值与*token*中的值做比较(在base oauth过程中会将用户的channelId/openId写入到token中)，以确保是同一个用户. 如果系统内采用了**代支付**实现方式，通过*pay oauth*拿到的openId在传递过程中推荐更名为*buyerId. (因为base oauth和pay oauth拿到的openId值不同，pay oauth拿到的其实为buyerId)


# 微信jssdk
[微信JS-SDK说明文档](https://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html)

我们提供了统一的方式获取微信jssdk signPackage的方式, `$signPackage = Yii::$app->wechatSdk->getSignPackage($channelId);`

其中: $channelId为非必填项, 如果使用jssdk的页面不在脉SCRM的domain下面，　需要传递`refererUrl`
使用形式为:

```php
$wechatSdk = Yii::$app->wechatSdk;
$wechatSdk->refererUrl = $refererUrl;
$signPackage = $wechatSdk->getSignPackage($channelId);
```
***Notice***: 这种方式获取的signPackage, 其channelId对应的公众号必须托管在weconnect的平台上。(不是采用的appId和appSecret的方式获取的ticket)
