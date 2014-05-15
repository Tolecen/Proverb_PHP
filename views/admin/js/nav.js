// 导航栏配置文件
var outlookbar=new outlook();
var t;

t=outlookbar.addtitle('管理首页','管理首页',1)
outlookbar.additem('管理首页',t,'index.php?con='+adminpath+'&act=main')

t=outlookbar.addtitle('管理员管理','会员管理',1)
outlookbar.additem('管理员管理',t,'index.php?con='+adminpath+'&act=manageuser')
outlookbar.additem('添加管理员',t,'index.php?con='+adminpath+'&act=manageusermodify')


t=outlookbar.addtitle('成语管理','数据信息',1)
outlookbar.additem('成语管理',t,'index.php?con='+adminpath+'&act=proverb')
outlookbar.additem('添加成语',t,'index.php?con='+adminpath+'&act=proverbmodify');