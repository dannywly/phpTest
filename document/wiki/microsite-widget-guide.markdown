# Structure

## Layout

The php layout file for microsite is located in **src/frontend/views/layouts**
* 'page.php' is for the finial rendered page and 'widget.php' is for the seperate widget page.
* Common theme related classes are defined here, so **don't define color, background-color** for your widget component.

```php
    <style>
        .m-color {color: <?= $color; ?>!important;}
        .m-color:visited {color: <?= $color; ?>!important;}
        .m-color:hover {color: <?= $color; ?>!important;}
        .m-bgcolor {background-color: <?= $color; ?>!important;}
        .m-border-color {border-color: <?= $color; ?>!important;}
        .m-pic-title-bgcolor {background-color: <?= 'RGBA(' . $pageRGBColor . ', 0.5)'; ?>!important;}

        .real-radio:checked + .m-radio,
        .real-checkbox:checked + .m-checkbox {
            background-color: <?= $color; ?>;
        }
    </style>
```

* I added some meta definition here, if you need add new one for specified feature, talk with @vincenthou

```php
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="yes" name="apple-touch-fullscreen" />
    <meta content="telephone=no,email=no" name="format-detection" />
    <meta name="viewport" content="width=device-width,maximum-scale=1,user-scalable=no">
    <meta name="keywords" content="<?= Yii::$app->params['metaKeywords']?>">
    <meta name="description" content="<?= Yii::$app->params['metaDescription']?>">
```

* We use [flexible tool](https://github.com/amfe/lib.flexible) to support responsive design, use **rem** for all the component size definition.

## Widget

* **Template:** All the widget html (actually php) files are located in 'src/frontend/views/msite/widget' folder, widget name is the file name.
* **Images:** All the widget dependent images are located in 'src/frontend/web/images/microsite' folder
* **Styles:** All the widget dependent scss files are located in 'src/static/webapp/msite/page/widget' folder, widget name is the file name.
* **Behavior:** Only some of the widgets need coffee files, they are located in 'src/static/webapp/msite/page' folder. I move old code here, feel free to refine them, if bugs exist.
 - article.coffee is for the article component.
 - album.coffee is for the album component.
 - slide.coffee is for the slide component.
 - questionnaire.coffee is for the questionnaire component.
 - index.coffee is for all the other components.

# Development Guide

## Access
* **Page access:** http://{domain}/msite/page/{pageId}
* **Widget access:** http://{domain}/msite/widget/{widgetId}?t={widgetType}
* **Important:** If you are developing a widget, access the second URL, take title widget for example: http://{domain}/msite/widget?t=title, widgetId is not needed here.

## Compile
Use grunt to build your scss and coffee code

```sh
grunt mobile
```

## Template

All the templates are written in php, php is a native template engine, refine the template logic of old ones, use '<?= $value; >' to render your variables. **Use old variable names** , if you really need to change them make sure it is compatible with configuration page rendered in the creating page part. Example below:

```php
<?php if (!empty($link)) { ?>
<a class="wm-block-title wm-a" href="<?php echo strpos($link, 'http://') === false ? ('http://'. $link) : $link; ?>" <?php echo !empty($link) && strpos($link, DOMAIN) === false ? 'target="_blank"' : ''; ?>>
<?php } else { ?>
<div class="wm-block-title">
<?php } ?>
    <i class="wm-fl wm-title-icon wm-bgcolor wm-title-<?php echo $style; ?>"></i>
    <span><?php echo empty($name) && $name != '0'? '标题' : htmlspecialchars($name, ENT_QUOTES);?></span>
<?php echo !empty($link) ? '</a>' : '</div>'; ?>
```

## Images

Place all the images in 'src/frontend/web/images/microsite' folder, name all the images with the widget name as prefix. Examples: title_style_arrow.png, title_style_flag.png for title widget.

## Styles

* **Use rem for font-size and size definition (width, height, padding, margin and so on), don't use px**, convert the UX defined px to rem (rem value = px value / 64), leave two decimal places. Example: **16px -> 16 / 64 = 0.21875, define 0.22rem**
* **Important: Use m-color, m-bgcolor, m-border-color for theme related places, example below:

```html
<div class="m-title-tail m-bgcolor m-bg-cover"></div>
```

* There are three global style file located in 'src/static/webapp/msite/page/widget' folder, add or use them when you need it.
 - variable.scss: Define global variables here.
 - mixins.scss: Define util mixins and placeholder classes here.
 - common.scss: Define util class here. Like: **m-rel, m-text-overflow**
* **Use 'm-' as prefix**, don't use 'mb2' (indicate margin-bottom:2rem) class, **define the values in components** .Define classes follow component pattern as shown below:

```scss
.m-title {
  display: block;
  font-size: 0.5rem;
  color: #1c1c1c;
  padding: 0.5rem;
  background-color: #fff;
  %m-bg-style {
    display: inline-block;
    padding: 0.17rem 0.56rem;
    padding-right: 0.4rem;
    color: #fff;
  }
  .m-dot {
    position: absolute;
    top: 0.75rem;
  }
  .m-border {
    position: absolute;
    width: 1.8rem;
    bottom: 0.25rem;
  }
  .m-title-tail {
    position: absolute;
    top: 0;
    right: -0.6rem;
    width: 0.6rem;
    height: 1rem;
    @include background-image("/images/microsite/title_style_flag.png");
  }
  .m-title-style {
    position: relative;
    &.m-dot-style {
      padding-left: 0.6rem;
    }
    &.m-flag-style {
      @extend %m-bg-style;
    }
    &.m-arrow-style {
      @extend %m-bg-style;
      .m-title-tail {
        background-image: url("/images/microsite/title_style_arrow.png");
      }
    }
  }
}
```

## Behavior

Reuse old code if possible, or rewrite it as you need.