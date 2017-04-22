<?php
header("content-type:text/html;charset=utf-8");
/**
 * Created by PhpStorm.
 * User: 酷酷小帅斌
 * Date: 2017/3/27
 * Time: 18:21
 */
$new_db_name="db_user_message";                                            //新数据库名
$new_tab_name="tab_user_message";                                          //新数据库下新表名
$link=mysqli_connect("localhost" ,"root" ,"root");      //连接数据库
$sql="create database if not exists $new_db_name";                         //构建创建新数据库的SQL语句
mysqli_query($link,$sql);
$sql="use $new_db_name";                                                   //选择数据库
mysqli_query($link,$sql);
$sql="create table if not exists $new_tab_name (                           //构建创建表的SQL语句
              id int  primary key auto_increment,
              username varchar(10) not null unique key,
              userpwd  varchar(10),
              age  int,
              edu varchar(10),
              fav set('排球','篮球','足球','中国足球','网球'),
              come_from enum('华东','华北','西北','东北','华西'),
              datetime timestamp)";
mysqli_query($link,$sql);
$sql="select * from $new_tab_name";                                        //查找新表的内容
$result=mysqli_query($link,$sql);
$records=mysqli_num_rows($result);                                         //取得结果集
if(isset($_POST["ac"])&&$_POST["ac"]=="my"){
    //获取表单提交值
    $username=$_POST["username"];
    $userpwd=$_POST["userpwd"];
    $age=$_POST["age"];
    $edu=$_POST["edu"];
    $arr=$_POST["fav"];
    $fav=implode(",",$arr);
    $come_from=$_POST["come_from"];
    //构建插入的SQL语句
    $sql="insert into $new_tab_name(username,userpwd,age,edu,fav,come_from) values('$username','$userpwd',$age,'$edu','$fav','$come_from')";
    //执行插入的SQL语句
    mysqli_query($link,$sql);
    //构建查询的SQL语句
    $sql="select * from $new_tab_name";
    $result=mysqli_query($link,$sql);
//    $arr=mysqli_fetch_assoc($result);
//    echo "<pre>";
//    var_dump($arr);
//    echo "</pre>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <script type="text/javascript">
        function input_focus(a){
            document.getElementById(a).style.display="inline";
        }
        function input_focus_out(a){
            document.getElementById(a).style.display="none";
        }
    </script>
    <style type="text/css">
        body{background-color:lightcyan;}
        table{border:1px red solid; background-color:#eee;}
    </style>
</head>
<body>
<form name="form1" method="post" action="" >
    <table border="0" width="800" align="center" cellpadding="5">
        <tr>
            <th colspan="2">添加数据</th>
        </tr>
        <tr>
            <td align="right" width="100">用户名：</td>
            <td width="700">
                <input type="text" name="username" onfocus="input_focus('a1')" onblur="input_focus_out('a1')"/>
                <span width="380" id="a1" style="display:none; color:red; font-size:12px;">(字母开头,后跟字母或数字，3-10位)</span>
            </td>

        </tr>
        <tr>
            <td align="right">密码：</td>
            <td>
                <input type="password" name="userpwd" onfocus="input_focus('a2')" onblur="input_focus_out('a2')"/>
                <span id="a2" style="display:none; color:red; font-size:12px;">(字母，数字和以下字符：！@#￥%^&*_的任意组合，3-10位)</span>
            </td>

        </tr>
        <tr>
            <td align="right">年龄：</td>
            <td>
                <input type="text" name="age" onfocus="input_focus('a3')" onblur="input_focus_out('a3')"/>
                <span id="a3" style="display:none; color:red; font-size:12px;">(2位数字)</span>
            </td>
        </tr>
        <tr>
            <td align="right">学历：</td>
            <td>
                <select name="edu" onfocus="input_focus('a4')" onblur="input_focus_out('a4')">
                    <option value="请选择">请选择</option>
                    <option value="小学">小学</option>
                    <option value="初中">初中</option>
                    <option value="高中">高中</option>
                    <option value="中专">中专</option>
                    <option value="大专">大专</option>
                    <option value="本科">本科</option>
                    <option value="研究生">研究生</option>
                </select>
                <span id="a4" style="display:none; color:red; font-size:12px;">(必选)</span>
            </td>
        </tr>
        <tr>
            <td align="right">兴趣：</td>
            <td>
                <input type="checkbox" name="fav[]" value="排球"/>排球
                <input type="checkbox" name="fav[]" value="篮球"/>篮球
                <input type="checkbox" name="fav[]" value="足球"/>足球
                <input type="checkbox" name="fav[]" value="中国足球"/>中国足球
                <input type="checkbox" name="fav[]" value="网球"/>网球
                <span id="a5" style="color:red; font-size:12px;">(至少两项)</span>
            </td>

        </tr>
        <tr>
            <td align="right">来自：</td>
            <td>
                <input type="radio" name="come_from" value="华东"/>华东
                <input type="radio" name="come_from" value="华北"/>华北
                <input type="radio" name="come_from" value="西北"/>西北
                <input type="radio" name="come_from" value="东北"/>东北
                <input type="radio" name="come_from" value="华西"/>华西
                <span id="a5" style="color:red; font-size:12px;">(必填)</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" value="提交"/>
                <input type="hidden" name="ac" value="my"/>
            </td>
        </tr>
    </table>
</form>
<br/>
<table border="1" rules="all" cellpadding="5" width="800" align="center">
    <tr>
        <th>用户名</th>
        <th>年龄</th>
        <th>学历</th>
        <th>兴趣</th>
        <th>来自</th>
        <th>注册时间</th>
        <th>操作</th>
    </tr>
    <?php while($arr=mysqli_fetch_assoc($result)){
        ?>
        <tr>
            <td align="center"><?php echo $arr["username"];?></td>
            <td align="center"><?php echo $arr["age"];?></td>
            <td align="center"><?php echo $arr["edu"];?></td>
            <td align="center"><?php echo $arr["fav"];?></td>
            <td align="center"><?php echo $arr["come_from"];?></td>
            <td align="center"><?php echo $arr["datetime"];?></td>
            <td align="center">
                <a href="delete1.php?id=<?php echo $arr["id"];?>&new_db_name=<?php echo $new_db_name;?>&new_tab_name=<?php echo $new_tab_name;?>">删除</a>
                <a href="amend1.php?id=<?php echo $arr["id"];?>&new_db_name=<?php echo $new_db_name;?>&new_tab_name=<?php echo $new_tab_name;?>">修改</a>
            </td>
        </tr>
    <?php }?>
</table>
</body>
</html>