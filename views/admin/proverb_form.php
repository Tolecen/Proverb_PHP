<?php

if(!defined('IN_PROVERB')) {
    exit('Access Denied');
}
?>
<?php include ROOT_PATH.'/views/admin/header.php';?>
<body>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <A HREF="index.php?con=<?php echo $GLOBALS['setting']['adminpath'];?>&act=proverb"><em>全部</em></A>
    </div>
</div>
<SCRIPT LANGUAGE="JavaScript">
    <!--
    function checkform(theform)
    {
        if($('#name').val()=='')
        {
            alert('名称不能为空');
            return false;
        }
    }
    //-->
</SCRIPT>

<!--proverbId    成语ID   自增     每一条成语有独一无二的ID-->
<!--name          成语名字-->
<!--pinyin          成语拼音-->
<!--created_at            发布时间-->
<!--updated_at      修改时间-->
<!--shiyi            成语意思-->
<!--chuchu        成语出处-->
<!--liju                成语例句-->
<!--story            成语的故事-->


<div id="man_zone">
    <form action="index.php?con=<?php echo $GLOBALS['setting']['adminpath'];?>&act=proverbmodify" method="post" onsubmit="return checkform(this);">
        <INPUT TYPE="hidden" NAME="commit" value="1">
        <INPUT TYPE="hidden" NAME="updateid" value="<?php echo $proverb['proverbId'];?>">
        <table width="100%" class="table_form">
            <tbody><tr>
                <td width="80">成语名字</td>
                <td><input type="text" id="name" value="<?php echo $proverb['name'];?>" class="input-text" name="name"></td>
            </tr>
            <tr>
                <td>成语拼音</td>
                <td><input type="text" value="<?php echo $proverb['pinyin'];?>" id="pinyin" class="input-text" name="pinyin"></td>
            </tr>
            <tr>
                <td>成语意思</td>
                <td>
                    <TEXTAREA style="width:600px;height:150px;" id="shiyi" name="shiyi"><?php echo $proverb['shiyi'];?></TEXTAREA>
                </td>
            </tr>

            <tr>
                <td>成语出处</td>
                <td>
                <TEXTAREA style="width:600px;height:150px;" id="chuchu" name="chuchu"><?php echo $proverb['chuchu'];?></TEXTAREA>
                </td>
            </tr>

            <tr>
                <td>成语例句</td>
                <td>
                <TEXTAREA style="width:600px;height:150px;" id="liju" name="liju"><?php echo $proverb['liju'];?></TEXTAREA>
                </td>
            </tr>
            <tr>
                <td>成语的故事</td>
                <td>
                <TEXTAREA style="width:600px;height:150px;" id="story" name="story"><?php echo $proverb['story'];?></TEXTAREA>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <INPUT TYPE="submit" class="normal_button" value="提交">
                </td>
            </tr>
            </tbody></table>
    </FORM>
</div>

</body>
</html>
