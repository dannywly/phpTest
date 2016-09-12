# Nike Activity Document


## Key-value Definition in Redis

### Key

- Follower: 'F_' + openId
- Example: F_oTAN2jp5sBHYOlGMxqyCsHq72rmQ

- Member : 'M_openId_' + openId
- Example: M_openId_oB5wkwrKhYXtcSRnd91w


### Value
For follower, refer to the following return example of getFollowerFromCache. Please note that it's jason format.
For member, refer to the following return example of getMemberFromCache.

## Extension Service Description

### Get Follower by openId from cache
- Example

    $service->nikeActivity->getFollowerFromCache($openId, $redisHost, $redisPort, $redisDb, $redisPw)

- Parameters

    | name | type | description | required | example |
    |------|-----|-------|---------|-------|
    | $openId | string | openId | Yes | oC9Aes3uSQDN46XNtK2oL8m9J8ZU |
    | $redisHost | string |redis hostname or ip | Yes | 127.0.0.1 |
    | $redisPort | string | redis port | Yes | 6379 |
    | $redisDb | Int | redis databse | Yes | 1 |
    | $redisPw | string | redis password | No | abc123_ |

- Return

    | name | type | description | example |
    |------|-----|-------|-------|
    | message | string | success or fail | as below|
    | data | array | follower information only if success | as below |    
    | exceptionMessage | string | error message if failed | as below |

```php
sucessful example:
{
    "message": "success",
    "data": {
        "accountId": "57578d64e4b0cff6c5c7e4f3",
        "subscribed": true,
        "originId": "o5lB5t0uI3Y1N7QjrSmS6UZLvixg_289",
        "nickname": "Bennett_289",
        "gender": "MALE",
        "city": "南通",
        "province": "江苏",
        "country": "中国",
        "headerImgUrl": "http://wx.qlogo.cn/mmopen/Q3auHgzwzM6pSO9k0Lnt2aEJXlwVe5CiawDcOgt1S4HEBibN6Ih0Eq0qTDo3zrhdUH2IFfr5rsSoejia57iaYia15RA/0",
        "unionId": null,
        "subscribeSource": "other",
        "tags": [
            "g:MALE",
            "中国",
            "中国 江苏",
            "中国 江苏 南通",
            "High_A",
            "High_E",
            "AMS_57567fc8e4b0d70bbd498d42_2"
        ]
    },
    "exceptionMessage": ""
}

failed example:
{
    "message": "fail",
    "data": [],
    "exceptionMessage": "Follower not found"
}
```
#### Register member

- Example

    $service->nikeActivity->register($redisHost, $redisPort, $redisPassword, $redisDb, $data);

- Parameters

    | name | type | description | required | example |
    |------|-----|-------|---------|-------|
    | redisHost | string | redis host | Yes | 127.0.0.1 |
    | redisPort | int | redis port | Yes | 6379 |
    | redisPassword | string | password | Yes | "" |
    | redisDb | int | redis db | Yes | 2 |
    | data | array | member info | true |  as follows |

```php
member info example
default propertyId
username => 用户姓名
tel => 电话
email => 邮箱
gender => 性别
birthday => 生日

```php
example:
[
 "socials": [
     [
        "channel": "56d7d34de4b015bc167b06ff",
        "openId": "oB5wkwrKhYXtcSRnd91w",
        "unionId":"oB5wkwrKhYXtcSRnd91w",
        "origin":"wechat",
        "originScene": "other",
        "isOriginal": true,
     ]
 ],
 "properties": [
    "propertyId":"propertyName",//propertyId在memberProperty唯一属性
    "phone":"1548653265472",
    "email":"11@qq.com"
 ],
 "avatar":"http://wx.qlogo.cn/mmopen/RNiaicvOT0t7nfeQe/0",
 "location": [
    "city":"上海",
    "country":"中国",
    "province":"上海"
 ],
 "tags":[
    "測試",
    "測試1"
 ]
] 
```

```

- Return

    | name | type | description | example |
    |------|-----|-------|-------|
    | messgae | string | result description | success/fail |
    | data | array | member info | as follows |
    | exceptionMessage | string | exception description | fail to connect to redis |
```php
example:
{
    "message": "success",
    "data": {
        "avatar": "http://wx.qlogo.cn/mmopen/RNiaicvOT0t7nfeQe/0",
        "location": {
            "city": "上海",
            "country": "中国",
            "province": "上海"
        },
        "tags": [
            "測試2",
            "測試31"
        ],
        "socials": [
            {
                "channel": "56d7d34de4b015bc167b06ff",
                "openId": "testbCeE",
                "unionId": "oB5wkwrKh11YXtcSRnd91w",
                "origin": "wechat",
                "originScene": "other",
                "isOriginal": true
            }
        ],
        "activatedAt": "2016-07-29 12:14:39",
        "properties": [
            {
                "id": "56c13bf11374734b4e8b456c",
                "name": "name",
                "username": "register"
            },
            {
                "id": "56c13bf11374734b4e8b456d",
                "name": "tel",
                "tel": "615472"
            },
            {
                "id": "56c13bf11374734b4e8b4570",
                "name": "email",
                "email": "0222@qq.com"
            }
        ],
        "phone": "615472",
        "accountId": "55c18ac0d6f97f2f7c8b4567"
    },
    "exceptionMessage": ""
}
```

#### Get member from cache
- Example

    $service->nikeActivity->getMemberFromCache($redisHost, $redisPort, $redisPassword, $redisDb, $openId);

- Parameters

    | name | type | description | required | example |
    |------|-----|-------|---------|-------|
    | redisHost | string | redis host | Yes | 127.0.0.1 |
    | redisPort | int | redis port | Yes | 6379 |
    | redisPassword | string | password | Yes | "" |
    | redisDb | int | redis db | Yes | 2 |
    | openId | string | open id | Yes | ojmADuBrXk2s3o4szDE |

- Return

    | name | type | description | example |
    |------|-----|-------|-------|
    | messgae | string | result description | success/fail |
    | data | array | member info | as follows |
    | exceptionMessage | string | exception description | fail to connect to redis |

```php
{
    "message": "success",
    "data": {
        "avatar": "http://wx.qlogo.cn/mmopen/RNiaicvOT0t7nfeQe/0",
        "location": {
            "city": "上海",
            "country": "中国",
            "province": "上海"
        },
        "tags": [
            "測試2",
            "測試31"
        ],
        "socials": [
            {
                "channel": "56d7d34de4b015bc167b06ff",
                "openId": "testbCeE",
                "unionId": "oB5wkwrKh11YXtcSRnd91w",
                "origin": "wechat",
                "originScene": "other",
                "isOriginal": true
            }
        ],
        "activatedAt": "2016-07-29 12:14:39",
        "properties": [
            {
                "id": "56c13bf11374734b4e8b456c",
                "name": "name",
                "username": "register"
            },
            {
                "id": "56c13bf11374734b4e8b456d",
                "name": "tel",
                "tel": "615472"
            },
            {
                "id": "56c13bf11374734b4e8b4570",
                "name": "email",
                "email": "0222@qq.com"
            }
        ],
        "phone": "615472",
        "accountId": "55c18ac0d6f97f2f7c8b4567"
    },
    "exceptionMessage": ""
}
```

#### get openId by phone
- Example

    $service->nikeActivity->getOpenIdByPhone($redisHost, $redisPort, $redisPassword, $redisDb, $phone);

- Parameters

    | name | type | description | required | example |
    |------|-----|-------|---------|-------|
    | redisHost | string | redis host | Yes | 127.0.0.1 |
    | redisPort | int | redis port | Yes | 6379 |
    | redisPassword | string | password | Yes | "" |
    | redisDb | int | redis db | Yes | 2 |
    | phone | string | phone | Yes | 154266865424 |

- Return

    | name | type | description | example |
    |------|-----|-------|-------|
    | message | string | message |  |
    | data | string | openID | oB5wkwrKhYXtcSRnd91w |
    | exceptionMessage | string | exceptionMessage |  |

```php
{
    "message": "success",
    "data": "oB5wkwrKhYXtcSRnd91w",//如果有多个openId, 用逗号分割oB5wkw,Rnd91w
    "exceptionMessage": ""
}
```

#### Update openId
- Example

    $service->nikeActivity->updateOpenId($redisHost, $redisPort, $redisPassword, $redisDb, $oldOpenId, $newOpenId);

- Parameters

    | name | type | description | required | example |
    |------|-----|-------|---------|-------|
    | redisHost | string | redis host | Yes | 127.0.0.1 |
    | redisPort | int | redis port | Yes | 6379 |
    | redisPassword | string | password | Yes | "" |
    | redisDb | int | redis db | Yes | 2 |
    | oldOpenId | string | openId | Yes | oB5wkwrKhYXtcSRnd91w |
    | newOpenId | string | openId | Yes | 995wkwrKh24tcSRn4321 |

- Return

    | name | type | description | example |
    |------|-----|-------|-------|
    | messgae | string | result description | success/fail |
    | exceptionMessage | string | exception description | fail to connect to redis |

```php
{
    "message": "success",
    "exceptionMessage": ""
}
```
