<?php
if (!defined('IN_PROVERB')) {
    exit('Access Denied');
}
function getProverbs($container,$cursor = 0,$limit = 30)
{
    global $db;
    $query = $db->query("select * from " . tname('proverb') . " where 1 ".$container." order by proverbId desc limit " . ($cursor * $limit) . "," . $limit);
    while ($rows = $db->fetch_array($query)) {
        $proverbs[] = $rows;
    }
    return $proverbs;
}