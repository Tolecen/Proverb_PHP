<?

class Proverb extends Controller
{
    public function index()
    {
        print 'Hello uzero.cn';
    }

    public function getAllProverbs()
    {
        $cursor = empty($_POST['cursor']) ? 0 : $_POST['cursor'];
        $proverbId = empty($_POST['proverbId']) ? 0 : $_POST['proverbId'];
        $container = "";
        if ($proverbId) {
            if(empty($_POST['refresh'])){
                $container .= "and proverbId <".$proverbId." ";
            }else{
                $container .= "and proverbId >".$proverbId." ";
            }
        }
        $json = array('msg'=>'0','timestamp'=>time(),'inreview'=>'0','info'=>getProverbs($container, $cursor));
        echo proverb_encode($json);
    }

    public function getProverbByID()
    {
	$proverbId = $_POST['proverbId'];
	$container = "and proverbId=".$proverbId." ";
	$json = array('msg'=>'0','timestamp'=>time(),'info'=>getProverbs($container, $cursor));
        echo proverb_encode($json);
    }

    public function readProverbTohtml()
    {
	$proverbId = $_GET['proverbId'];
	$container = "and proverbId=".$proverbId." ";
	$json = array('msg'=>'0','timestamp'=>time(),'info'=>getProverbs($container, $cursor));
        $contentit = $json['info'][0];
	echo '<title>'.$contentit['name'].'</title>';
	echo '<p style="text-align:center;color:blue;font-size:30">'.$contentit['name'].'<br>'.$contentit['pinyin'].'</p>';
	echo "意思:";
	echo "<br><br>";
	echo $contentit['shiyi'];
	echo "<br><br>";
        echo "出处:";
        echo "<br><br>";
        echo $contentit['chuchu'];
	echo "<br><br>";
        echo "例句:";
        echo "<br><br>";
        echo $contentit['liju'];
	echo "<br><br>";
        echo "成语故事:";
        echo "<br><br>";
        echo $contentit['story'];
	echo '<p style="text-align:center;color:blue;font-size:30"><a href = "https://itunes.apple.com/us/app/tian-tian-cheng-yu/id843601091?ls=1&mt=8" target=“_blank”><img src = "http://www.uzero.cn/proverb/api/Controllers/download.png"></img></a></p>';
    } 
}
