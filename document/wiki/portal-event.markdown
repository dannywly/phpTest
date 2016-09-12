### Common

#### Tag deleted

```php
[
    'type'=> 'tag_deleted',
    'account_id'=> new MongoId('54a1461eb8137480048b4567'),
    'name'=> 'test'
]
```

#### Tag renamed

```php
[
    'type'=> 'tag_renamed',
    'account_id'=> new MongoId('54a1461eb8137480048b4567'),
    'old_name'=> 'haha',
    'new_name'=> 'hahad'
]
```

#### Open payment

```php
[
    'type'=> 'open_payment',
    'account_id'=> new MongoId('54b3333d2c3e99e9338b4567'),
    'channel_id'=> '5510ec60e4b0f7b9ba20ed5a'
]
```

### Channel

#### Channel deleted

```php
[
    'type'=> 'channel_deleted',
    'account_id'=> new MongoId('54a1461eb8137480048b4567'),
    'channel_id'=> '552621b9e4b00231bde18bdb',
    'origin' => 'wechat',
    'is_test' => false,
]
```

#### Channel created

```php
[
    'type'=> 'channel_created',
    'account_id'=> new MongoId('54a1461eb8137480048b4567'),
    'channel_id'=> '552621b9e4b00231bde18bdb',
    'origin' => 'wechat',
    'is_test' => false,
]
```

### Product

#### product updated

```php
[
    'type' => 'product_updated',
    'account_id' => new MongoId('54a1461eb8137480048b4567'),
    'product_id' => new MongoId('55c04116d6f97f1b408b4567'),
    'category_id' => new MongoId('55530790d6f97fdd138b4567'),
    'sku' => '1438662919909773',
    'name' => '旺仔牛奶',
    'product_type' => 'product',
    'pictures' => [
        {
            'url' : 'http://vincenthou.qiniudn.com/fca49d46fd95df4a738ffee0.jpg',
            'size' : '0.41',
            'name' : '7e3e6709c93d70cfa990b406fadcd100baa12b56'
        }
    ]
]
```

#### Product deleted

```php
[
    'type'=> 'product_deleted',
    'account_id'=> new MongoId('54a1461eb8137480048b4567'),
    'product_ids'=> [
        new MongoId('55c04116d6f97f1b408b4567'),
    ]
]
```

### Member

#### Member merged

```php
[
    'type' => 'member_merged',
    'account_id'=> new MongoId('54a1461eb8137480048b4567'),
    'main_member_id' => new MongoId('57566ba0d6f97f0c048b456e'),
    'main_member_name' => 'Tom',
    'merged_member_ids' => [
        new MongoId('55154985d6f97f35708b4570'),
    ],
    'created_at' => '2016-06-23T18:44:02+08:00'
]
```

#### Member property deleted

```php
[
    'type' => 'member_property_deleted',
    'account_id'=> new MongoId('54a1461eb8137480048b4567'),
    'member_property_id' => '57566ba0d6f97f0c048b456e'
]
```

#### Member name updated

```php
[
    'type' => 'member_name_updated',
    'member_id'=> new MongoId('54a1461eb8137480048b4567'),
    'account_id' => new MongoId('54a1461eb8137480048b4567'),
    'member_old_name' => 'hi',
    'member_new_name' => 'hello'
]
```


### Content

#### Questionnaire answered

```php
[
    'type' => 'questionnaire_answered',
    'account_id'=> new MongoId('54a1461eb8137480048b4567'),
    'questionnaire_id' => new MongoId('55154985d6f97f35708b4570'),
    'answerer' => [
        'channelId' => '552621b9e4b00231bde18bdb',
        'openId' => 'oDn77jjjXhs9XpwVOHkZ7an5VzLw',
        'name' => '麦田傀儡'
    ]
]
```
note: The answerer may be empty
