<?php

if (!defined('IN_PROVERB')) {
    exit('Access Denied');
}
?>
<?php include ROOT_PATH . '/views/admin/header.php'; ?>
<body>


<form method="post" action="index.php?con=<?php echo $GLOBALS['setting']['adminpath']; ?>&act=proverb" name="searchform">
    <table width="100%" cellspacing="0" class="search-form">
        <tbody>
        <tr>
            <td>
                <div class="explain-col">
                    关键字：<INPUT TYPE="text" NAME="keyword" class="input-text"
                               value="<?php echo $_REQUEST['keyword']; ?>">

                    <input type="submit" class="button" value="确定">
                </div>
            </td>

        </tr>
        </tbody>
    </table>
</form>

<!--proverbId    成语ID   自增     每一条成语有独一无二的ID-->
<!--name          成语名字-->
<!--pinyin          成语拼音-->
<!--created_at            发布时间-->
<!--updated_at      修改时间-->
<!--shiyi            成语意思-->
<!--chuchu        成语出处-->
<!--liju                成语例句-->
<!--story            成语的故事-->
<div class="table-list">
    <TABLE cellpadding="1" cellspacing="1" width="100%">
        <thead>
        <TR>
            <TH>成语名字</TH>
            <TH>成语拼音</TH>
            <TH>成语意思</TH>
            <TH>成语出处</TH>
            <TH>成语例句</TH>
            <TH>成语的故事</TH>
            <TH>发布时间</TH>
            <TH>修改时间</TH>
            <TH>操作</TH>
        </TR>
        </thead>
        <tbody>
        <?php foreach ($taglist['data'] as $key => $val) { ?>
            <TR class="tr<?php echo $key % 2; ?>" id="user<?php echo $val['proverbId']; ?>">
                <TD align="center">
                    <?php echo $val['name']; ?>
                </TD>

                <TD align="center">
                    <?php echo $val['pinyin']; ?>
                </TD>
                <TD align="center">
                    <?php echo $val['shiyi']; ?>
                </TD>
                <TD align="center">
                    <?php echo $val['chuchu']; ?>
                </TD>
                <TD align="center">
                    <?php echo $val['liju']; ?>
                </TD>
                <TD align="center">
                    <?php echo $val['story']; ?>
                </TD>

                <TD align="center"><?php echo date('Y-m-d', $val['created_at']); ?></TD>
                <TD align="center"><?php echo date('Y-m-d', $val['updated_at']); ?></TD>


                <TD align="center">
                    <A HREF="index.php?con=<?php echo $GLOBALS['setting']['adminpath']; ?>&act=proverbmodify&updateid=<?php echo $val['proverbId']; ?>">修改</A>
                    <A HREF="index.php?con=<?php echo $GLOBALS['setting']['adminpath']; ?>&act=proverb&type=del&id=<?php echo $val['proverbId']; ?>"
                       onclick="return confirm('确认删除？');">删除</A>
                </TD>
            </TR>
        <?php } ?>
        </tbody>
    </TABLE>
</div>
<div class="pages"><?php echo $taglist['pageinfo']; ?></div>

</body>
</html>