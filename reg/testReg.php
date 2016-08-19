<?php 
    $email = "feedback@example.com";
    if (!ereg('^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $email)) {
        echo "That is not vaild email address.";
    } else {
        echo "Email's formate is correct!";
    }

    //使用split函数分解字符串
    $arr = split('\.|@', $email);
    while (list($key, $value) =  each($arr)) {
        echo $value . '<br/>';
    }

    //使用正则表达式达到替换的效果
    $rep =  ereg_replace('@', '_replace_', $email);
    echo "$rep <br/>";
    echo md5($email);

    echo $email;
 ?>