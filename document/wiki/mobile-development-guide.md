# Introduction

We recommend you to implement mobile pages with [vuejs](http://vuejs.org/) and the related static assets are built with [webpack](http://webpack.github.io/) and [grunt](http://www.gruntjs.net/).

**More Info:** You can also use the standard `Yii MVC` to implement your mobile page in `webapp` folder, place `coffee/js`, `scss/css`, fonts and images folder in static folder as mobile static assets(they will be compiled and copied to the right place at runtime), write standard `Yii` views as pages.

# Tech Stack

## Core Javascript Libs (Load by Default)

* [vuejs](http://vuejs.org/)
* [vue-router](https://github.com/vuejs/vue-router)
* [vue-resource](https://github.com/vuejs/vue-resource)
* [vue-i18n](https://github.com/kazupon/vue-i18n)
* [vue-tap](https://github.com/MeCKodo/vue-tap)

---

* [lib-flexible](https://github.com/amfe/lib-flexible)
* [alogs](https://github.com/fex-team/alogs)

---

* Utils [TODO]

## Optional Javascript Libs (Load with Need)

* [vue-preload](https://github.com/egoist/vue-preload)
* [vue-jwt-authentication](https://github.com/auth0/vue-jwt-authentication)
* [vue-touch](https://github.com/vuejs/vue-touch): Only use it if you really need [hammer](http://hammerjs.github.io/getting-started/) support
* [vue-validator](https://github.com/vuejs/vue-validator)
* [vue-rx](https://github.com/vuejs/vue-rx): Use it only in page logic **(Don't use it in component definition)** if you prefer to write event-based programs.
* [vue-chart](https://github.com/miaolz123/vue-chart): Use it to draw chart.

---

* [lazyload](https://github.com/jieyou/lazyload#1.3.1)
* [moment](https://github.com/moment/moment)
* [mobile-detect](https://github.com/hgoebl/mobile-detect.js)

---

* Components [TODO]

# Debug Guide

Install [vue-devtools](https://github.com/vuejs/vue-devtools) chrome plugin for vue app debuging.

# Component Style Guide

## Reference

Refer the common component library below to learn components definition and implementation for better quality and effect, our documentaion will be generated as the [doc](http://mui.yaobieting.com/docs/index.html) shows.

* [vui](https://github.com/lepture/vui)
* [vue-mui](https://github.com/mennghao/vue-mui)

# Customization

## Entry template

Basically, we provide default `index.ejs` as template in `src/static/h5` folder, it will add default meta and import the common library like `flexible` and `wechat jssdk`, other static assets will be injected by `webpack`, but you can create your customized entry file named as `index.ejs` in module `h5` folder. A simple example is shown below:

```html
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="XXX" name="keywords">
    <meta content="XXX" name="description">
    <meta content="telephone=no,email=no" name="format-detection">
    <link rel="canonical" href="https://www.quncrm.com/">
    <title>XXX</title>
    <link rel="shortcut icon" href="/favicon.png">
  </head>
  <body>
    <div id="app"></div>
    <!-- built files will be auto injected -->
  </body>
</html>
```

# Development Guide

## Common Guide

### Setup Development Environment

* Use [nvm](https://github.com/creationix/nvm) to install the same node version **(v0.12.10)**

```
nvm install v0.12.10
nvm use v0.12.10
```

* Install related node module dependencies

```sh
cd src
sudo npm install
```

* Start up development local server (You should replace moduleName with your own one)

```sh
npm run h5dev moduleName
```

* Access the development server

```sh
open http://localhost:8081/
```

### Install cssrem plugin

As we use [lib.flexible](https://github.com/amfe/lib-flexible) to adapter mobile devices, use rem to define all the size. In order to caculate the value easier, install [cssrem plugin](https://github.com/flashlizi/cssrem) to translate `px` to `rem` in scss and vue file.

**Notice:** Change the default value for `px_to_rem` from 40 to 75, and add `.vue` to `available_file_types` array.

### Follow the Mobile Development Rule

Follow the [session](https://github.com/frontnode/PPT/blob/master/ppts/mobile-page-development-in-OmniSocials.md) introduced for all the team developers to implement your pages.

## Component Guide

There are two types of component: `common component` and `module component`. `common component` is shared across modules and `module component` is only used by a specific module. All the component is defined in module, only if the component defined in module is seen in other module design, the `module component` can be promoted as `common component`.

### Component Conventions

* Vue Component should contains `template`, `script` and `styles` in one file.
* The file name should be capitalized.
* Only if the component becomes a common component, the validation for props should be added.


### Scope the Stylesheet for Common Component

All the styles defined in `components` folder should add scoped property

```html
<style scoped>
.title {
  padding-right: 1rem;
  color: #fff;
  background-color: #ccc;
}
</style>
```

## Page Guide

### Folder Structure

All the assets for a page are placed under `pages` folder in module. Every page is an individual folder with the structure below:

```
├── i18n
│   ├── locate-en_us.js
│   └── locate-zh_cn.js
├── list.less
└── list.vue
```

### Style Convention

All the styles for a page is placed in `less` file. Every less file has a id namespace for the page.

```scss
#list {
  .list-header {
    background-color: red;
    color: #fff;
  }
}
```

The id `list` is used as a wrapper for the page styles, you should add a div with id `list` to wrap all the html structure in `vue` template as the example below:

```html
<template>
  <div id="list">
    <header class="centered list-header">Current Scores {{ $t("list.hello") }}</header>
    <ul>
      <li v-for="item in items">
        <card :title="item.title" :poster="item.poster" :url="item.url">
      </li>
    </ul>
    <footer class="fixed-bottom">Shopping cart is empty {{ count }}</footer>
  </div>
</template>
```

### Page Convention

* Vue page only contains `template` and `script`, styles is defined in `less` file.
* Vue page name is lowercased, you can use '-' to seperate names.
* Vue page can import module component or common component with need.
* Use [vue-router's data](http://router.vuejs.org/zh-cn/pipeline/data.html) to load async data needed after page loaded at the first time.

#### Import Page Style

Every time you add a page, you should add import declartion in `App.vue` file.

```
<script>
  import '../../../static/h5/styles/util.less'

  // Page imports
  import './pages/list/list.less'
</script>
```

#### Use Common Style Definitions

Because of the limitaion for loader, mixins and global variables can only be loaded in page style file, you should import it manually as the example below:

```less
@import "../../../../../static/h5/styles/variables.less";
@import "../../styles/variables.less";

#goods {
}
```

**Notice:** As we extract the files as submodule, you need to specify the long path if it is placed in omnisocials main repo. You can define your variables in `h5/styles` folder in module repo, later importing definition will override the values defined before.

#### Use Relative Image Path

Every module has a folder called `images` to contain all the images used in the module, you can refer it with relative path in less file as the example below:

```less
.cart-icon {
  background: url('../../images/empty_cart.png') no-repeat;
  background-color: @primaryColor;
}
```

#### Define Page Router

Every time you add a page, you should add router configuration in `router.js`. You can refer [vue-router document](http://vuejs.github.io/vue-router/zh-cn/index.html) for help. The vue page component is lazyloaded with webpack.

```js
module.exports = {
  '/': {
    name: 'list',
    component (resolve) {
      return require(['./pages/list/list'], resolve)
    }
  },
  '/goods/:id': {
    name: 'detail',
    component (resolve) {
      return require(['./pages/detail/detail'], resolve)
    }
  }
}
```

#### Use v-tap instead of v-click Directive

```html
<div v-tap:="handler('hello', $event)">I am a div.</div>
```

Detailed example can be found [here](https://github.com/leolin1229/vue-tap/tree/master/example)

#### Update Router Configuration for Pages

When you need to add a new page, add proper configuration in `router.js` file in module.

```js
module.exports = {
  '/': {
    name: 'list',
    component (resolve) {
      return require(['./pages/list/list'], resolve)
    }
  },
  '/goods/:id': {
    name: 'detail',
    component (resolve) {
      return require(['./pages/detail/detail'], resolve)
    }
  }
}
```

**Notice:** Every page path should have a name for `v-link`, so that you can use `v-link` as the example below:

```html
<!-- literal string -->
<a v-link="'home'">Home</a>

<!-- same as above -->
<a v-link="{ path: 'home' }">Home</a>

<!-- named route -->
<a v-link="{ name: 'user', params: { userId: 123 }}">User</a>
```

#### I18n Convention

All the i18n files are placed under `i18n` folder for pages. `locales.js` is the entry file for all the i18n file in module. The js files under `i18n` folder exports a plain object. You can use it in `template` and `script`, detailed exmple can be found [here](https://github.com/kazupon/vue-i18n).

* You only need to add chinese version at first time.
* Add page name string in `pages` array in `locales.js` file to new page i18n locate.
* The i18n key should be camelCase

#### Only Import Needed module

In vue file script import needed module (vue component or CommonJS module) as the example below:

```js
// Components
import Card from '../../components/Card'
// Logic
import interaction from '../../../../../static/h5/utils/interaction'
import fomatter from '../../utils/fomatter'
```

#### Import library

With the help of `import`, it's easy to use library in vue. But as the project is a module of [omnisocials](http://git.augmentum.com.cn/scrm/aug-marketing), you should install the library in omnisocials' project.

For example, `chart.js` is needed for current module.

After asking @wyatt.fang for permission (Email: wyatt.fang@augmentum.com), open terminal, and input the following command:

```bash
cd /path/to/omnisocials/project

npm install chart.js --save
```

After installing the library, import it in vue's page or component file like:

```html
<template>
  <!-- some html -->
  <vue-chart></vue-chart>
</template>

<script>
import Chart from 'chart.js'

// it's a component library, assuming we've already installed the VueChart in omnisocials
import VueChart from 'vue-chart'

export default {
  ready () {
    let barChart = new Chart({
      // data/options
    })
  },
  components: {
    VueChart
  }
}
</script>
```
