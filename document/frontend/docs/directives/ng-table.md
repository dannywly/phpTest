## ngTable
The `ngTable` directive is used to custom table columns. Refer to [ngTable document](https://github.com/esvit/ng-table)

---

## Directive Info
This directive executes at priority level 1001.

---

## Arguments
Param | Type | Default | Details
----- | ---- | ------ | ----
ngTable | `expression` | | Table configuration
noData  | `string` | |Text of no data
hasCustomNodata | `string` | | You can custom no data style
tableOperationTemplate | `string` | | ID of table operation template

---

## Arguments Explaination
- **ngTable:** Instance of NgTableParams. You should inject this service into your controller. When you new NgTableParams's instance, it has two parameters, such as parameters and settings. You can see examples as below.
```sh
NgTableParams
  ├── parameters
  │     ├── page(number, current page, getter and setter)
  │     ├── count(number, page size, getter and setter)
  │     └── sorting(object, sort by column, getter and setter)
  │
  └── settings
        ├── counts(array, page size collection)
        ├── total(number, total count of list, getter and setter)
        └── getData(function, it should return a promise to fetch server data. When you change page, count or sorting, the function will be called)
```

- **noData:** Text of no data. You can set no data text as below:
```html
no-data="{{'no_data' | translate}}"
no-data="{{card.noData | translate}}"
```

- **hasCustomNodata:** Custom style of no data. If default no data style can not meet your requirements, you can define your no data style as design. The wrapper element should has an attribute like `has-custom-nodata=true`.
```html
<div class="center-block" has-custom-nodata="true">Add</div>
```

- **tableOperationTemplate:** The template id of table operations which are placed on top of the table and under the table. You can add `table-operation` class name which has `float left` style to template wrapper.
```html
<script type="text/ng-template" id="cardOperation.html">
  <div class="table-operation">
    <wm-checkbox ng-model="card.selectAll"></wm-checkbox>
    <button class="btn btn-success" ng-click="card.reloadCard()">Operate Card</button>
    <span>Total Count: {{params.count()}} | Current Page: {{params.page()}}</span>
  </div>
</script>
```

- **$data*:* List of data you want to render the table. You can used it directedly. Actually it is the data your promise resolved. You can refer the examples below.

- **header-class:** Table header class name. You can set header column style like `header-class="'checkbox-col'"`.

- **data-title:** Table header text. You should give i18n key of title, such as `data-title="'customer_card_name'"`. Please be careful about single quote mark of the i18n key.

- **sortable:** Sort by field of table. If you want to sort by some field, you can set such as `sortable="'createdAt'"`.

- **NgTableParams.reload():** You can refetch server data as you want.

**When you fetch data, you should set conditions which are from parameters of ngTable. Only in this way, when you change page size, current page or sorting, ngTable will refetch server data automatically. You can refer the examples below.**

---

## Example
### Simple Table(Without Operation)
html
```
<div ng-table="card.tableParams" no-data="{{'no_data' | translate}}">
  <table class="wm-data-table">
    <tr ng-repeat="row in $data track by $index">
      <td data-title="'customer_card_name'" class="text-el">
        <a ng-href="{{row.cardName.link}}">{{row.cardName.text}}</a>
      </td>
      <td data-title="'customer_card_extend_number'" class="text-el">
        {{row.provideCount}}
      </td>
      <td data-title="'customer_card_create_time'" class="text-el" sortable="'createdAt'">
        {{row.createdAt}}
      </td>
    </tr>
  </table>
</div>
```

coffeescript
```
      formatCardData = (items) ->
        for item in items
          item.cardName =
            link: '/member/view/card/' + item.id
            text: item.name
        items

      fetchCards = (params) ->
        defered = $q.defer()
        # set parameters when fetch server data
        condition =
          page: params.page() # get current page
          'per-page': params.count() # get page size
          orderBy: JSON.stringify params.sorting() # get sort
        restService.get config.resources.cards, condition, (data) ->
          params.total data._meta.totalCount # set total count
          vm.list = formatCardData(data.items)
          defered.resolve vm.list
        defered.promise

      vm.tableParams = new NgTableParams(
        page: 1 # default current page
        count: 10 # default page size
        sorting: # default sort
          createdAt: 'desc'
      ,
        counts: [10, 20, 50, 100] # setting of page size
        total: 0
        getData: fetchCards # fetch server data, it should return a promise
      )

      vm.reloadCard = ->
        vm.tableParams.reload() # fetch server data again when you want
```

### Complex Table(With Operation)
html
```
<div ng-table="card.tableParams" no-data="{{'no_data' | translate}}" table-operation-template="cardOperation.html">
  <table class="wm-data-table">
    <tr ng-repeat="row in $data track by $index">
      <td header-class="'checkbox-col'">
        <wm-checkbox ng-model="row.checked"></wm-checkbox>
      </td>
      <td data-title="'customer_card_name'" class="text-el" sortable="'name'">
        <a ng-href="{{row.cardName.link}}">{{row.cardName.text}}</a>
      </td>
      <td data-title="'customer_card_extend_number'" class="text-el">
        {{row.provideCount}}
      </td>
      <td data-title="'customer_card_create_time'" class="text-el" sortable="'createdAt'">
        {{row.createdAt}}
      </td>
    </tr>
  </table>
  <div has-custom-nodata="true" style="text-align:center">Add</div>
</div>
<!-- operation template -->
<script type="text/ng-template" id="cardOperation.html">
  <div class="table-operation">
    <wm-checkbox ng-model="card.selectAll"></wm-checkbox>
    <button class="btn btn-success" ng-click="card.reloadCard()">Operate Card</button>
    <span>Total Count: {{params.count()}} | Current Page: {{params.page()}}</span>
  </div>
</script>
```
