## Add dependency

To support echarts library lazy loading, the wmCharts or wmMapChart dependency should be declared clearly.

Each page which needs the basic chart directive should add wmCharts as dependency, example like below:

```coffeescript
define [
  'wm/app'
  'wm/config'
  'core/directives/wmCharts'
  ...
```

Each page which needs the map directive should add wmMapChart as dependency, example like below:

```coffeescript
define [
  'wm/app'
  'wm/config'
  'core/directives/wmMapChart'
  ...
```

## Line Chart

html example:

```html
<div wm-line-chart options="chart.lineChartOptions" width="100%" height="400px"></div>
```

data example:

```coffeescript
vm.lineChartOptions =
  color: '#57C6CD' # Array or String
  categories: ['Q1', 'Q2', 'Q3', 'Q4']
  series: [
      name: 'KLP Pull'
      data: [1.21, 1.25, 1.24, 1.3]
    ,
      name: 'KLP FT'
      data: [1.5, 1.45, 1.47, 1.50]
  ]
```

or use date as categories:

```coffeescript
vm.lineChartOptions =
  color: "#57C6CD" # Array or String
  categories: ['2015-01-02', '2015-01-03', '2015-01-04', '2015-01-05']
  series: [
      name: 'KLP Pull'
      data: [1.21, 1.25, 1.24, 1.3]
    ,
      name: 'KLP FT'
      data: [1.5, 1.45, 1.47, 1.50]
  ]
  startDate: "2015-01-01" # Optional
  endDate: "2015-01-10" # Optional
```

## Horizontal Area Line Chart

html example:

```html
<div wm-h-area-line-chart options="chart.hAreaLineChartOptions" width="50%" height="400px"></div>
```

data example:

```coffeescript
vm.hAreaLineChartOptions =
  color: ['#AFDB51', '#37C3AA', '#88C6FF', '#8660BB', '#F29C9F', '#FFBD5A', '#FACD89', '#F8E916']
  categories: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
  title: "KLP Channel Penetration in Acct"
  series: [
      data: [10, 100, 300, 300, 600, 90, 109]
      name: 'T2'
    ,
      data: [200, 1000, 200, 20, 400, 90, 190]
      name: 'CR'
    ,
      data: [300, 1000, 200, 300, 400, 900, 180]
      name: 'Others'
    ,
      data: [400, 200, 200, 300, 400, 900, 100]
      name: 'Canteen'
  ]
```

## Bar Chart

html example:

```html
<div wm-bar-chart options="chart.barChartOptions" width="100%" height="400px"></div>
```

data example:

```coffeescript
vm.barChartOptions =
  color: ['#7E56B5', '#9374BE'] # Array or String
  categories: ['Q1', 'Q2', 'Q3', 'Q4']
  stack: false
  type: 'percent'
  series: [
      name: 'Pull'
      data: [1800, 467, 233, 980]
    ,
      name: 'Free Trade'
      data: [515, 888, 432, 123]
  ]
```

or use date as categories:

```coffeescript
vm.barChartOptions =
  color: ['#7E56B5', '#9374BE'] # Array or String
  categories: ['2015-01-01', '2015-01-02', '2015-01-09', '2015-01-04', '2015-01-05', '2015-01-08']
  stack: true
  type: 'percent' # Optional
  series: [
      name: 'Pull'
      data: [1800, 467, 233, 178, 678, 980]
    ,
      name: 'Free Trade'
      data: [515, 345, 662, 888, 432, 123]
  ]
  startDate: "2015-01-01" # Optional
  endDate: "2015-01-30" # Optional
```

**stack** : means the bar is arranged side by side or stacked one by one

**type** : `percent` means the label in the bar displays the percentage of the current bar data; if the type is not set, the label will display the current bar data

## Horizontal Bar Chart

html example:

```html
<div wm-h-bar-chart options="chart.hbarChartOptions" width="100%" height="200px"></div>
```

data example:

```coffeescript
vm.hBarChartOptions =
  color: ['#57C6CD', '#C490BF'] # Array or String
  categories: ['Q1', 'Q2', 'Q3', 'Q4']
  stack: false
  series: [
      name: '人数',
      data: [11, 15, 35, 89]
    ,
      name: '次数',
      data: [11, 15, 10, 90]
  ]
```

or use date as categories:

```coffeescript
vm.hBarChartOptions =
  color: ['#57C6CD', '#C490BF'] # Array or String
  categories: ['2015-01-01', '2015-01-02', '2015-01-03', '2015-01-04', '2015-01-05', '2015-01-06', '2015-01-07']
  stack: false
  series: [
      name: '人数',
      data: [11, 15, 35, 89, 90, 80, 10]
    ,
      name: '次数',
      data: [11, 15, 35, 89, 90, 80, 10]
  ]
  startDate: '2015-01-01' # Optional
  endDate: '2015-01-10' # Optional
```

## Accumulated Bar Chart

html example:

```html
<div wm-accumulated-bar-chart options="chart.accumulatedBarChartOptions" width="100%" height="400px"></div>
```

data example:

```coffeescript
vm.accumulatedBarChartOptions =
  color: ['#F86961', '#2DA4A8'] # Array
  tooltipTitle: '累积粉丝数'
  categories: ['立顿', '多芬']
  series: [[
      name: '立顿茶'
      value: 1500
    ,
      name: '立顿上海活动群'
      value: 200
  ], [
      name: '多芬爱美丽'
      value: 1750
    ,
      name: '多芬活动'
      value: 200
  ]]
```

## Pie Chart

html example:

```html
<div wm-pie-chart options="chart.pieChartOptions" width="100%" height="400px"></div>
```

data example:

```coffeescript
vm.pieChartOptions =
  color: ['#AFDB51', '#37C3AA', '#88C6FF', '#8660BB', '#F29C9F', '#FFBD5A', '#FACD89', '#F8E916'] # Array
  title: 'KLP Channel Penetration in Volume'
  type: 'inner' # 'inner' or 'outer', 'outer' is the default value
  series: [
      value: 10009
      name: 'T2'
    ,
      value: 70209
      name: 'CR'
    ,
      value: 30209
      name: 'Others'
    ,
      value: 2864
      name: 'Canteen'
    ,
      value: 42193
      name: 'Other LET'
    ,
      value: 35398
      name: 'WR'
    ,
      value: 21859
      name: 'Hotel'
    ,
      value: 18859
      name: 'Food Factory'
  ]
```

## Donut Chart

html example:

```html
<div wm-donut-chart options="chart.donutChartOptions" width="100%" height="400px"></div>
```

data example:

```coffeescript
vm.donutChartOptions =
  color: ['#19BE9B', '#88C6FF'] # Array
  title: 'Active and Inactive Acct Tracking'
  totalTitle: 'Active Acct'
  series: [
      value: 1500
      name: 'NEW'
    ,
      value: 1720
      name: 'Current'
  ]
```

## Map

html example:

```html
<div wm-map options="chart.mapOptions" width="100%" height="400px"></div>
```

data example:

```coffeescript
vm.mapOptions =
  series: [
      name: 'iphone3',
      data: [
          name: '北京'
          value: 100
        ,
          name: '天津'
          value: 200
        ,
          name: '上海'
          value: 300
        ,
          name: '重庆'
          value: 150
        ,
          name: '河北'
          value: 400
        ,
          name: '河南'
          value: 200
      ]
    ,
      name: 'iphone4',
      data: [
          name: '北京'
          value: 600
        ,
          name: '天津'
          value: 300
        ,
          name: '上海'
          value: 300
        ,
          name: '重庆'
          value: 250
        ,
          name: '河北'
          value: 400
        ,
          name: '河南'
          value: 300
      ]
    ,
      name: 'iphone5',
      data: [
          name: '北京'
          value: 700
        ,
          name: '天津'
          value: 300
        ,
          name: '上海'
          value: 300
        ,
          name: '重庆'
          value: 350
        ,
          name: '河北'
          value: 400
        ,
          name: '河南'
          value: 200
      ]
    ]
```

## Custom config

If the default chart config does not meet your needs, you can pass `config` as `options` object key. The config can be echarts native configuration.

```coffeescript
vm.lineChartOptions =
  color: '#57C6CD' # Array or String
  categories: ['Q1', 'Q2', 'Q3', 'Q4']
  series: [
      name: 'KLP Pull'
      data: [1.21, 1.25, 1.24, 1.3]
    ,
      name: 'KLP FT'
      data: [1.5, 1.45, 1.47, 1.50]
  ]
  config:
    grid:
      borderWidth: 0
```
