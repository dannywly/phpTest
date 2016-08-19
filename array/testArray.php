<?php 
    $products[0] = 'biak';
    $products[1] = 'baidu';
    $products[2] = 'sugo';

    foreach ($products as $key => $value) {
        echo $key . ' => ' . $value . '<br/>';
    }


    $prices  = array('Tires' => 100, 'Oil' => 10, 'Spark Plugs' => 4);
    //使用list（） 和each（） 方法循环
    while ($element = each($prices)) {
        echo $element['key'];
        echo " - ";
        echo $element['value'];
        echo "<br/>";
    }

    reset($prices); // reset函数可以将数组的指针移到第一个元素位置
    while (list($product, $price) = each($prices)) {
        echo $product . " - " . $price . " <br/>";
    }

    /* 使用array_walk()函数
       bool array_walk(array arr, string fun, [mixed userdata])
       userdata是可选的，如果使用它，他可以作为一个参数传递给我们自己的函数
    */
    $array = range(1,10);
    function my_funtion ($value) {
        echo "$value<br/>";
    }

    array_walk($array, 'my_funtion');

    function my_mutiply(&$array, $key, $factor) {
        $array *= $factor;
    }
    array_walk($array, 'my_mutiply', 5);
    foreach ($array as $key => $value) {
        echo "$value<br/>";
    }

    // extract()函数，将数组按照关键字变成变量名，值变成变量值的方式，将数组变成一组变量
    $data = array('name' => 'danny' , 'age' => 24, 'sex' => 'male');
    //如果提取出来的变量和现有的变量重名，默认时覆盖现有变量
    extract($data);
    echo "$name 's age is $age,and $name is $sex</br>";

 ?>