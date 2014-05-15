<?php
if (! defined ( 'IN_PROVERB' )) {
	exit ( 'Access Denied' );
}
class admin {
	static $filelist = array ();
	
	function main_action() {
		global $db,$session;
		$uid = $session->get ( 'adminid' );
		//得到个人信息
		$userinfo = $db->fetch_first( 'select * from '.tname('admin').' where uid=' . $uid);
		include ROOT_PATH . '/views/admin/adminframe.php';
	}
	function index_action() {
		include ROOT_PATH . '/views/admin/index.php';
	}
	
	function login_action() {
		
		if (submitcheck ( 'commit' )) {
			$user = global_addslashes ( trim ( strip_tags ( $_POST ['username'] ) ) );
			$password = md52 ( $_POST ['password'] );
			$container = ' and username="' . $user . '" and passwd="' . $password . '" and usertype="adminuser"';
			
			$user_mod = new common ( 'admin' );
			$userinfo = $user_mod->GetOne ( $container );
			
			if ($userinfo) {
				$GLOBALS ['session']->set ('adminid',$userinfo ['uid']);
				$GLOBALS ['session']->set ('adminuser',$userinfo ['username']);
				echo '<SCRIPT LANGUAGE="JavaScript">
				<!--
					window.onload=function(){window.open("index.php?con=' . $GLOBALS ['setting'] ['adminpath'] . '","_top","")};
				//-->
				</SCRIPT>';
			} else {
				exit ( '<SCRIPT LANGUAGE="JavaScript">
				<!--
					alert("用户名或密码不正确!");
					parent.document.getElementById("user_pass").value="";
				//-->
				</SCRIPT>' );
			}
		} else {
			include ROOT_PATH . '/views/admin/login.php';
		}
	}
	function logout_action() {
		$GLOBALS ['session']->destroy ( array ('adminid' => '', 'adminuser' => '' ) );
		sheader ( 'index.php?con=' . $GLOBALS ['setting'] ['adminpath'] . '&act=login' );
	}
	
	
	//清空缓存
	function delcache_action()
	{
		$dofile=cleancache();
		if($dofile==='nowrite')
		{
			echo '<SCRIPT LANGUAGE="JavaScript">
			<!--
				parent.showDiglog("'.$GLOBALS['setting']['site_cache_dir'].'目录修改权限不足,请联系服务商");
			//-->
			</SCRIPT>';
		}
		elseif(!$dofile)
		{
			echo '<SCRIPT LANGUAGE="JavaScript">
			<!--
				parent.showDiglog("清空缓存失败,请在ftp上手动清除");
			//-->
			</SCRIPT>';
		}
		else
		{
			
			cleancache('php','data/cache/userinfo');
			cleancache('php','data/cache/usercount');
			echo '<SCRIPT LANGUAGE="JavaScript">
			<!--
				parent.showDiglog("清空缓存成功");
			//-->
			</SCRIPT>';
		}
	}
	//管理员列表
	function manageuser_action() {
		$ext='';
		$container='';
		if ($_REQUEST ['username']) {
			$container .= ' and username like "%' . global_addslashes ( $_REQUEST ['username'] ) . '%"';
			$ext = '&username=' . $_REQUEST ['username'];
		}
		
		$showpage = array ('isshow' => 1, 'currentpage' => intval ( $_REQUEST ['page'] ), 'pagesize' => 20, 'url' => 'index.php?con=' . $GLOBALS ['setting'] ['adminpath'] . '&act=admin' . $ext, 'example' => 3 );
		$user_mod = new common ( 'admin' );
		$userlist = $user_mod->GetPage ( $showpage, $container );
		
		
		include ROOT_PATH . '/views/admin/manageuser.php';
	}
	/**
	 *添加会员
	 */
	function manageusermodify_action() {
		
		$updateid = intval ( $_REQUEST ['updateid'] );
		$user_mod = new common ( 'admin' );
		$user = array ();
		if (submitcheck ( 'commit' )) {
			
			$data ['username'] = trim ( strip_tags ( $_POST ['username'] ) );
			$data ['email'] = trim ( strip_tags ( $_POST ['email'] ) );

			if ($updateid > 0) {
				if (! empty ( $_POST ['password'] )) {
					$data ['passwd'] = md52 ( $_POST ['password'] );
				}
				if ($user_mod->UpdateData ( $data, 'and uid=' . $updateid )) {
					sheader ( 'index.php?con=' . $GLOBALS ['setting'] ['adminpath'] . '&act=manageuser&type=manageuser', 3, '修改成功', 'redirect', true );
				} else {
					sheader ( 'index.php?con=' . $GLOBALS ['setting'] ['adminpath'] . '&act=manageuser&type=manageuser', 3, '修改失败', 'redirect', true );
				}
			} else {
				$data ['passwd'] = md52 ( $_POST ['password'] );
				if ($user_mod->InsertData ( $data )) {
					sheader ( 'index.php?con=' . $GLOBALS ['setting'] ['adminpath'] . '&act=manageuser&type=manageuser', 3, '添加成功', 'redirect', true );
				}
			}
		} else {
			if ($updateid) {
				$user = $user_mod->GetOne ( 'and uid=' . $updateid );
			
			}
			include ROOT_PATH . '/views/admin/manageuser_form.php';
		}
	}

    //标签管理
    function proverb_action()
    {
        $data_mod=new common('proverb');
        $id=intval($_REQUEST['id']);
        if($_REQUEST['type']=='del' && $id>0)
        {
            $data_mod->DeleteData('1 and proverbId='.$id);
            sheader ( 'index.php?con=' . $GLOBALS ['setting'] ['adminpath'] . '&act=proverb', 3, '删除成功', 'redirect', true );
        }
        else
        {
            $container = "";
            if(!empty($_REQUEST['keyword']))
            {
                $container.=' and name like "%'.trim(strip_tags($_REQUEST['keyword'])).'%"';
            }
            $showpage=array('isshow'=>1,'currentpage'=>intval($_REQUEST['page']),'pagesize'=>20,'url'=>'index.php?con='.$GLOBALS['setting']['adminpath'].'&act=proverb','example'=>2);
            $taglist=$data_mod->GetPage($showpage,$container,"","","ORDER BY proverbId DESC");
            include ROOT_PATH.'/views/admin/proverb.php';
        }
    }

    /**
     *添加标签
     */
//<!--proverbId    成语ID   自增     每一条成语有独一无二的ID-->
//<!--name          成语名字-->
//<!--pinyin          成语拼音-->
//<!--created_at            发布时间-->
//<!--updated_at      修改时间-->
//<!--shiyi            成语意思-->
//<!--chuchu        成语出处-->
//<!--liju                成语例句-->
//<!--story            成语的故事-->
    function proverbmodify_action() {

        $updateid = intval ( $_REQUEST ['updateid'] );
        $proverb_mod = new common ( 'proverb' );
        $tag = array ();
        if (submitcheck ( 'commit' )) {

            $data ['name'] = trim ( strip_tags ( $_POST ['name'] ) );
            $data ['pinyin'] = trim ( strip_tags ( $_POST ['pinyin'] ) );
            $data ['shiyi'] = trim ( strip_tags ( $_POST ['shiyi'] ) );
            $data ['chuchu'] = trim ( strip_tags ( $_POST ['chuchu'] ) );
            $data ['liju'] = trim ( strip_tags ( $_POST ['liju'] ) );
            $data ['story'] = trim ( strip_tags ( $_POST ['story'] ) );

            if ($updateid > 0) {
                if ($proverb_mod->UpdateData ( $data, 'and proverbId=' . $updateid )) {
                    sheader ( 'index.php?con=' . $GLOBALS ['setting'] ['adminpath'] . '&act=proverb', 3, '修改成功', 'redirect', true );
                } else {
                    sheader ( 'index.php?con=' . $GLOBALS ['setting'] ['adminpath'] . '&act=proverb', 3, '修改失败', 'redirect', true );
                }
            } else {
                $thisTime = time();
                $data ['created_at'] = $thisTime;
                $data ['updated_at'] = $thisTime;
                if ($proverb_mod->InsertData ( $data )) {
                    sheader ( 'index.php?con=' . $GLOBALS ['setting'] ['adminpath'] . '&act=proverb', 3, '添加成功', 'redirect', true );
                }
            }
        } else {
            if ($updateid) {
                $proverb = $proverb_mod->GetOne ( 'and proverbId=' . $updateid );

            }
            include ROOT_PATH . '/views/admin/proverb_form.php';
        }
    }

	//ajax修改添加处理
	function admin_ajax_action() {
		$key = empty ( $_GET ['primarykey'] ) ? 'id' : $_GET ['primarykey'];
		
		if (empty ( $_GET ['table'] )) {
			echo '参数有误';
			exit ();
		} elseif (empty ( $_GET ['field'] )) {
			echo '字段为空';
			exit ();
		} 

		elseif (intval ( $_GET ['primary'] ) == 0) {
			echo '主键不能为0';
			exit ();
		} 

		else {
			$obj = new common ( $_GET ['table'] );
			
			$data [$_GET ['field']] = trim ( strip_tags ( $_GET ['val'] ) );
			$container = "and " . $key . "=" . intval ( $_GET ['primary'] );
			$this->_cachedel ();
			$goods = $obj->GetOne ( $container );
			
			if ($goods && $obj->UpdateData ( $data, $container, true )) {
				exit ( '1' );
			} else {
				exit ( 'failed' );
			}
		}
	}

}