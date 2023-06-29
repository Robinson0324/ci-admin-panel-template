<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 9/27/14
 * Time: 12:51 AM
 */

require_once __DIR__.'/config.php';

/***
 * In this part,we fetch asin related data
 * Returned info fields: asin/stock/price/seller
 */
/**
 * Class Analyser
 */
Class Analyser {
    /**
     * @var public members
     */
    public $asin;
    public $startday;
    public $endday;
    public $action;
    public $db_con;
    /**
     * constructor
     */
    public function __construct(){
        /**
         * DB setting
         */
        $db_host = DB_HOST;
        $db_name = DB_NAME;
        $this->db_con = new PDO("mysql:host=$db_host;dbname=$db_name", DB_USER, DB_PASSWORD);
        /**
         * GET parameter initialize
         */
        if(isset($_GET['asin'])&&!empty($_GET['asin']))$this->asin = $_GET['asin'];
        if(isset($_GET['startday'])&&!empty($_GET['startday'])){
            $jsDateTS = strtotime($_GET['startday']);
            $this->startday = date('Y-m-d H:i:s', $jsDateTS );
        }
        if(isset($_GET['endday'])&&!empty($_GET['endday'])){
            $jsDateTS = strtotime($_GET['endday']);
            $this->endday = date('Y-m-d H:i:s', $jsDateTS );
        }
        $this->action = $_GET['action'];

        /**
         * Start analysis
         */
        $this->start();
    }

    /**
     * Main process
     */
    public function start(){
        switch($this->action){
            case 'stock':
                $result = $this->get_stock_data();
                $this->output($result);
                break;
            case 'price':
                $result = $this->get_price_data();
                $this->output($result);
                break;
            case 'seller':
                $result = $this->get_seller_data();
                $this->output($result);
                break;
            case 'stock-total-chart':
                $result = $this->get_stock_total_data();
                $this->output($result);
                break;
            case 'price-total-chart':
                $result = $this->get_price_total_data();
                $this->output($result);
                break;
            case 'seller-total-chart':
                $result = $this->get_seller_total_data();
                $this->output($result);
                break;
            case 'all-asin-info':
                $result = $this->get_all_asin_info();
                $this->output($result);
                break;
            case 'all-seller-price-info':
                $result = $this->get_all_seller_price_info();
                $this->output($result);
                break;
            case 'all-seller-stock-info':
                $result = $this->get_all_seller_stock_info();
                $this->output($result);
                break;
            case 'get_all_asin':
                $result = $this->get_all_asin_list();
                $this->output($result);
                break;
            case 'get_dashboard_info':
                $result = $this->get_dashboard_info();
                $this->output($result);
                break;
            case 'asin-detail':
                require_once __DIR__.'/scrapper.php';
                break;
            case 'table-data':
                $result = $this->get_total_table_data();
                $this->output($result);
                break;
            case 'get_stock_change':
                $result = $this->get_stock_change_data();
                $this->output($result);
                break;
            case 'stock-change-sort':
                $result = $this->get_stock_change_sort();
                $this->output($result);
                break;
            case 'stock-num-sort':
                $result = $this->get_stock_num_sort();
                $this->output($result);
                break;
            case 'get_inserted_date_list':
                $response = array(
                    'msg'=> "ファイルがDBに入力されました。",
                    'dates' => $this->get_inserted_date_list()
                );
                $this->output($response);
                break;
            case 'asin-diff-bar-chart':
                $result = $this->get_diff_bar_chart();
                $this->output($result);
                break;
            default:
                $result = array('msg' => 'error:invalid action');
                $this->output($result);
                break;
        }
    }

    /**
     * Get price data for submitted asin from database
     */
    public function get_price_data(){
        /**
         * we have to fetch from database with below matched condition
         *  asin
         *  start date
         *  end date
         *  price
         *
         * SELECT date,price FROM product_data WHERE date >= '2014-05-31' AND date <= '2014-06-01 05:56:00' AND asin = 'B00449YYM8'
         */
        // query prepare
        $sth = $this->db_con->prepare("SELECT date(date) as date,price FROM ".DB_PRODUCT_TABLE." WHERE date >= :startdate AND date <= :enddate AND asin = :asin  AND seller_id = ''");

        $sth->bindParam(':asin', $this->asin, PDO::PARAM_STR);
        $sth->bindParam(':startdate', $this->startday, PDO::PARAM_STR);
        $sth->bindParam(':enddate', $this->endday, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        //get result array
        $data = $sth->fetchAll();

        //sort date normal
        $this->array_sort_by_column($data, 'date');

        //change to chart data array format,no associate array
        $tmp = array();
        foreach($data as $val){
            $tmp[] = array_values($val);
        }
        //result array
        $result = array(
            'label' => $this->asin,
            'data' => $tmp
        );
        return $result;
    }

    /**
     * @return array
     *
     * SELECT date,stock FROM product_data WHERE date >= '2014-05-31' AND date <= '2014-06-01 05:56:00' AND asin = 'B00449YYM8'
     */
    public function get_stock_data(){
        // query prepare
        $sth = $this->db_con->prepare("SELECT date(date) as date,stock FROM ".DB_PRODUCT_TABLE." WHERE date >= :startdate AND date <= :enddate AND asin = :asin ");

        $sth->bindParam(':asin', $this->asin, PDO::PARAM_STR);
        $sth->bindParam(':startdate', $this->startday, PDO::PARAM_STR);
        $sth->bindParam(':enddate', $this->endday, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        //get result array
        $data = $sth->fetchAll();

        //sort date normal
        $this->array_sort_by_column($data, 'date');

        //change to chart data array format,no associate array
        $tmp = array();
        foreach($data as $val){
            $tmp[] = array_values($val);
        }
        //result array
        $result = array(
            'label' => $this->asin,
            'data' => $tmp
        );
        return $result;
    }

    /**
     * Get stock change data
     */
    public function get_stock_change_sort(){
        // query prepare
        /***********************
         * delete from curtb;
         * delete from lasttb;
         * insert into lasttb SELECT asin,sum(stock) FROM `amazon_graph`.`product_data` where DATE(date)= '2014-09-21' group by asin order by sum(stock) DESC
         * insert into curtb SELECT asin,sum(stock) FROM `amazon_graph`.`product_data` where DATE(date)= '2014-09-21' group by asin order by sum(stock) DESC
         * select curtb.asin,curtb.last-lasttb.last from curtb inner join lasttb on curtb.asin=lasttb.asin order by (curtb.last-lasttb.last) DESC
         */

        $startdate = date("Y-m-d", strtotime($this->startday));
        $enddate = date("Y-m-d", strtotime($this->endday));

        /**
         * if $startdate is not exist,then find nearly date $startdate.
         * $enddate is too.
        SELECT DATE( DATE ) AS enddate
        FROM product_data
        WHERE DATE( DATE ) <=  '2014-10-30'
        ORDER BY DATE DESC
        LIMIT 0 , 1

        SELECT DATE( DATE ) AS startdate
        FROM product_data
        WHERE DATE( DATE ) >=  '2014-10-16'
        ORDER BY DATE ASC
        LIMIT 0 , 1
         *
         */

        $sth = $this->db_con->prepare("SELECT DATE( DATE ) AS startdate FROM ".DB_PRODUCT_TABLE." WHERE DATE( DATE ) >=  '".$startdate."' ORDER BY DATE ASC LIMIT 0 , 1");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        //get result row
        $row = $sth->fetch();
        $startdate = $row['startdate'];
        ///
        $sth = $this->db_con->prepare("SELECT DATE( DATE ) AS enddate FROM ".DB_PRODUCT_TABLE." WHERE DATE( DATE ) <=  '".$enddate."' ORDER BY DATE DESC LIMIT 0 , 1");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        //get result row
        $row = $sth->fetch();
        $enddate = $row['enddate'];

        $sth = $this->db_con->prepare("delete from ".DB_TMP_CUR_TABLE);
        $sth->execute();
        $sth = $this->db_con->prepare("delete from ".DB_TMP_LAST_TABLE);
        $sth->execute();
        $sth = $this->db_con->prepare("insert into ".DB_TMP_LAST_TABLE." SELECT asin,stock FROM ".DB_PRODUCT_TABLE." where DATE(date)= :date  AND `asin` NOT LIKE  '%>>>>%' order by stock DESC");
        $sth->bindParam(':date', $startdate, PDO::PARAM_STR);
        $sth->execute();

        $sth = $this->db_con->prepare("insert into ".DB_TMP_CUR_TABLE." SELECT asin,stock FROM ".DB_PRODUCT_TABLE." where DATE(date)= :date  AND `asin` NOT LIKE  '%>>>>%' order by stock DESC");
        $sth->bindParam(':date', $enddate, PDO::PARAM_STR);
        $sth->execute();
        $sth = $this->db_con->prepare("select ".DB_TMP_LAST_TABLE.".asin,".DB_TMP_CUR_TABLE.".last-".DB_TMP_LAST_TABLE.".last as total from ".DB_TMP_CUR_TABLE." inner join ".DB_TMP_LAST_TABLE." on ".DB_TMP_CUR_TABLE.".asin=".DB_TMP_LAST_TABLE.".asin order by (".DB_TMP_CUR_TABLE.".last-".DB_TMP_LAST_TABLE.".last) DESC");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        //get result array
        $result = $sth->fetchAll();

        $result['startdate'] = $startdate;
        $result['enddate'] = $enddate;

        return $result;
    }

    /**
     * Get stock change data
     */
    public function get_stock_num_sort(){
        // query prepare
        //SELECT asin,sum(stock) FROM `amazon_graph`.`product_data` where DATE(date)= '2014-09-23' group by asin order by sum(stock) DESC
        $sth = $this->db_con->prepare("SELECT asin,stock as total FROM ".DB_PRODUCT_TABLE." where DATE(date)= :date  AND `asin` NOT LIKE  '%>>>>%' order by stock DESC");

        $date = date("Y-m-d", strtotime($this->startday));
        $sth->bindParam(':date', $date, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        //get result array
        $result = $sth->fetchAll();
        //print_r($result);
        return $result;
    }


    /**
     * @return array
     *
     * SELECT date,seller_id FROM product_data WHERE date >= '2014-05-31' AND date <= '2014-06-01 05:56:00' AND asin = 'B00449YYM8'
     */
    public function get_seller_data(){
        // query prepare
        $sth = $this->db_con->prepare("SELECT date(date) as date,seller_count FROM ".DB_PRODUCT_TABLE." WHERE date(date) >= :startdate AND date(date) <= :enddate AND asin = :asin  AND `asin` NOT LIKE  '%>>>>%'");

        $sth->bindParam(':asin', $this->asin, PDO::PARAM_STR);
        $sth->bindParam(':startdate', date("Y-m-d",strtotime($this->startday)), PDO::PARAM_STR);
        $sth->bindParam(':enddate', date("Y-m-d",strtotime($this->endday)), PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        //get result array
        $data = $sth->fetchAll();

        //sort date normal
        $this->array_sort_by_column($data, 'date');


        //result array
        $result = array(
            'label' => $this->asin,
            'data' => $data
        );

        return $result;
    }

    /**
     *  We will show all stock with asin each daily
     *
     */
    public function get_stock_total_data(){

        // query prepare
        $sth = $this->db_con->prepare("SELECT date(date) as date,stock FROM ".DB_PRODUCT_TABLE." WHERE date(date) >= :startdate AND date(date) <= :enddate AND asin = :asin");

        $sth->bindParam(':asin', $this->asin, PDO::PARAM_STR);
        $sth->bindParam(':startdate', date("Y-m-d",strtotime($this->startday)), PDO::PARAM_STR);
        $sth->bindParam(':enddate', date("Y-m-d",strtotime($this->endday)), PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        //get result array
        $data = $sth->fetchAll();

        //sort date normal
        $this->array_sort_by_column($data, 'date');

        //change to chart data array format,no associate array
        $arr = array();
        foreach($data as $val){
            $sum = 0;
            foreach($data as $v){

                if($val['date'] == $v['date']){
                    $sum += $v['stock'];

                }
            }
            if(!isset($arr[$val['date']])){
                $arr[$val['date']] = $sum;
            }
        }

        $tmp = array();
        foreach($arr as $key => $val){
            $tmp[] = array($key,$val);
        }

        //result array
        $result = array(
            'label' => "Total daily stock graph: ".$this->asin,
            'data' => $tmp
        );

        return $result;
    }

    /**
     *  We will show total price with asin each daily
     */
    public function get_price_total_data(){

        // query prepare
        $sth = $this->db_con->prepare("SELECT date(date) as date,price FROM ".DB_PRODUCT_TABLE." WHERE date(date) >= :startdate AND date(date) <= :enddate AND asin = :asin");

        $sth->bindParam(':asin', $this->asin, PDO::PARAM_STR);
        $sth->bindParam(':startdate', date("Y-m-d",strtotime($this->startday)), PDO::PARAM_STR);
        $sth->bindParam(':enddate', date("Y-m-d",strtotime($this->endday)), PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        //get result array
        $data = $sth->fetchAll();

        //sort date normal
        $this->array_sort_by_column($data, 'date');

        //change to chart data array format,no associate array
        $arr = array();
        foreach($data as $val){
            $sum = 0;
            foreach($data as $v){

                if($val['date'] == $v['date']){
                    $sum += $v['price'];
                }
            }
            if(!isset($arr[$val['date']])){
                $arr[$val['date']] = $sum;
            }
        }

        $tmp = array();
        foreach($arr as $key => $val){
            $tmp[] = array($key,$val);
        }

        //result array
        $result = array(
            'label' => "Total daily price graph: ".$this->asin,
            'data' => $tmp
        );

        return $result;
    }

    /**
     *  We will show total seller count with asin each daily
     */
    public function get_seller_total_data(){

        $result = array(
            'label' => "Seller Total Test Graph",
            'data' => array(
                array(date('Y-m-d H:i:s', strtotime("201408020245")), 2.0),
                array(date('Y-m-d H:i:s', strtotime("201408031245")), 4.9),
                array(date('Y-m-d H:i:s', strtotime("201408041245")), 7.0),
                array(date('Y-m-d H:i:s', strtotime("201408051245")), 3.2),
                array(date('Y-m-d H:i:s', strtotime("201408061245")), 5.3),
                array(date('Y-m-d H:i:s', strtotime("201408071245")), 6.5),
                array(date('Y-m-d H:i:s', strtotime("201408081245")), 2.0),
                array(date('Y-m-d H:i:s', strtotime("201408091245")), 6.1),
                array(date('Y-m-d H:i:s', strtotime("201408101245")), 7.9),
                array(date('Y-m-d H:i:s', strtotime("201408111245")), 2.9)
            )
        );
        return $result;
    }

    /**
     * Output all asin's info
     * contains all sellerid detail each asin
     */
    public function get_all_asin_info(){
        // query prepare
        $sth = $this->db_con->prepare("SELECT asin,seller_id FROM ".DB_PRODUCT_TABLE);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        //get result array
        $data = $sth->fetchAll();

        $res = $arr = array();
        foreach($data as $val){
            $arr['asin'] = $val['asin'];
            $arr['seller_id'] = array();
            foreach($data as $v){
                if($val['asin'] == $v['asin']){
                    $arr['seller_id'][] = $v['seller_id'];
                }
            }
            $res[] = $arr;
        }

        //remove duplicates
        $result = array_map("unserialize", array_unique(array_map("serialize", $res)));
        return $result;
    }

    /**
     * Output all seller's price info
     * contains all price sum
     */
    public function get_all_seller_price_info(){
        // query prepare
        $sth = $this->db_con->prepare("SELECT seller_id,price_sum FROM ".DB_WEEK_TABLE);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        //get result array
        $data = $sth->fetchAll();
        //remove duplicates
        $unique = array_map("unserialize", array_unique(array_map("serialize", $data)));

        return $unique;
    }

    /**
     * Output all seller's stock info
     * contains all stock sum
     */
    public function get_all_seller_stock_info(){
        // query prepare
        $sth = $this->db_con->prepare("SELECT seller_id,stock_sum FROM ".DB_WEEK_TABLE);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        //get result array
        $data = $sth->fetchAll();
        //remove duplicates
        $unique = array_map("unserialize", array_unique(array_map("serialize", $data)));

        return $unique;
    }

    /**
     * Get dashboard data
     */
    public function get_dashboard_info(){

        $result = array(
            'asin' => 0,
            'stock' => 0,
            'seller' => 0,
            'price' => 0,
            'status' => 0
        );
        // query prepare
        //SELECT SUM(price_sum) AS TotalPrice,SUM(stock_sum) AS TotalStock,SUM(stock_sum) AS TotalStock,SUM(compstock_sum) AS TotalCompStock,SUM(compprice_sum) AS TotalCompPrice FROM week_analysis;
        $sth = $this->db_con->prepare("SELECT SUM(price_sum) AS TotalPrice,SUM(stock_sum) AS TotalStock,SUM(stock_sum) AS TotalStock,SUM(compstock_sum) AS TotalCompStock,SUM(compprice_sum) AS TotalCompPrice FROM ".DB_WEEK_TABLE);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        //get result array
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        $result['price'] = round($data['TotalPrice']);
        $result['stock'] = $data['TotalStock'];

        //get seller count
        $sth = $this->db_con->prepare("SELECT seller_id  FROM ".DB_WEEK_TABLE);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();
        $unique = array_map("unserialize", array_unique(array_map("serialize", $data)));
        $result['seller'] = sizeof($unique);

        //get asin count
        $sth = $this->db_con->prepare("SELECT asin  FROM ".DB_WEEK_TABLE);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();
        $unique = array_map("unserialize", array_unique(array_map("serialize", $data)));
        $result['asin'] = sizeof($unique);

        return $result;
    }

    public function get_all_asin_list(){
        //get asin list
        $sth = $this->db_con->prepare("SELECT DISTINCT asin  FROM ".DB_PRODUCT_TABLE." WHERE `asin` NOT LIKE  '%>>>>%'");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();
        return $data;
    }

    public function get_total_table_data(){

        // query prepare
        $sth = $this->db_con->prepare("SELECT asin,date,price,seller_id,stock,compe,status FROM ".DB_PRODUCT_TABLE." WHERE date >= :startdate AND date <= :enddate AND asin = :asin");

        $sth->bindParam(':asin', $this->asin, PDO::PARAM_STR);
        $sth->bindParam(':startdate', $this->startday, PDO::PARAM_STR);
        $sth->bindParam(':enddate', $this->endday, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        //get result array
        $data = $sth->fetchAll();

        //sort date normal
        //$this->array_sort_by_column($data, 'date');

        return $data;
    }

    public function get_inserted_date_list(){

        //get date list
        $sth = $this->db_con->prepare("SELECT DISTINCT date  FROM ".DB_PRODUCT_TABLE." WHERE `asin` NOT LIKE  '%>>>>%' order by date DESC");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();
        return $data;
    }


    public function get_diff_bar_chart(){
        /**
         * sample sql query
         *
         * get date list
        SELECT DISTINCT DATE( DATE )
        FROM  `product_data`
        WHERE preasin =  'B003V89SS8'
        AND DATE( DATE ) >=  '2014-09-10'
        AND DATE( DATE ) <=  '2014-10-02'
        AND asin LIKE  '%>>>>%'
        ORDER BY  `product_data`.`DATE` ASC
        LIMIT 0 , 30
         *
         * get Seller list
        SELECT DISTINCT asin
        FROM  `product_data`
        WHERE preasin =  'B003V89SS8'
        AND DATE( DATE ) >=  '2014-09-10'
        AND DATE( DATE ) <=  '2014-10-02'
        AND asin LIKE  '%>>>>%'
        ORDER BY  `product_data`.`DATE` ASC
        LIMIT 0 , 30
         *
        SELECT date(date) as date,asin as seller_id,stock
        FROM  `product_data`
        WHERE preasin =  'B003V89SS8'
        AND DATE( DATE ) >=  '2014-09-10'
        AND DATE( DATE ) <=  '2014-10-02'
        AND asin LIKE  '%>>>>%'
        ORDER BY  `product_data`.`DATE` ASC

         */

        //Get unique date list
		$str_query = "SELECT DISTINCT DATE( DATE ) as date FROM ".DB_PRODUCT_TABLE." WHERE preasin =  '".$this->asin."' AND  DATE(date) >=  '".date("Y-m-d",strtotime($this->startday))."' AND DATE(date) <=  '".date("Y-m-d",strtotime($this->endday))."' AND asin LIKE  '%>>>>%' ORDER BY  date ASC";
        $sth = $this->db_con->prepare($str_query);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $date_list = $sth->fetchAll();
		//print_r($str_query);
        //Get unique seller list
		$str_query = "SELECT DISTINCT asin as seller_id FROM ".DB_PRODUCT_TABLE." WHERE preasin =  '".$this->asin."' AND DATE(date) >=  '".date("Y-m-d",strtotime($this->startday))."' AND DATE(date) <=  '".date("Y-m-d",strtotime($this->endday))."' AND asin LIKE  '%>>>>%' ORDER BY  asin ASC";
        $sth = $this->db_con->prepare($str_query);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $seller_list = $sth->fetchAll();
		//print_r($str_query);
        //Get all data
		$str_query = "SELECT date(date) as date,asin as seller_id,stock
                                        FROM  ".DB_PRODUCT_TABLE."
                                        WHERE preasin =  '".$this->asin."'
                                        AND  DATE(date) >=  '".date("Y-m-d",strtotime($this->startday))."'
                                        AND DATE(date) <=  '".date("Y-m-d",strtotime($this->endday))."'
                                        AND asin LIKE  '%>>>>%'
                                        ORDER BY  date ASC";
        $sth = $this->db_con->prepare($str_query);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
		//print_r($str_query);
        //get result array
        $stockdata = $sth->fetchAll();
		
		
		//print_r('--------date list-------');
        //print_r($date_list);
        //print_r('--------seller list-------');
        //print_r($seller_list);
		
		
		//print_r('-------------------------stock data---------------------------');
		//print_r($stockdata);
		//print_r('-------------------------res_matrix---------------------------');
		$res_matrix = array();
		
		for($i=0;$i<count($seller_list);$i++){			
			for($j=0;$j<count($date_list);$j++){
				$res_matrix[$i][$j] = 0;				
			}			
		}
		foreach($stockdata as $val){
			$date = $val['date'];
			$seller_id = $val['seller_id'];
			$date_index = array_search(array('date' => $date), $date_list);
			$seller_index = array_search(array('seller_id' => $seller_id), $seller_list);
			$res_matrix[$seller_index][$date_index] = $val['stock'];		
        }		
		
		
		//print_r('---------------------------diff arry-------------------------');
		$diffarry = array();
		for($i=0;$i<count($seller_list);$i++){			
			for($j=0;$j<count($date_list)-1;$j++){
				$diffarry[$i][$j] = 0;				
			}			
		}
		
		//print_r('---------------------------result diff arry-------------------------');
		for($i=0;$i<count($seller_list);$i++){
			for($j=1;$j<count($date_list);$j++){
				$diffarry[$i][$j-1] = $res_matrix[$i][$j] - $res_matrix[$i][$j-1];
			}
		}
		//print_r($date_list);print_r($seller_list);print_r($res_matrix);print_r($diffarry);
		
		//print_r('---------------------------chart arry-------------------------');
		$chartarry = array();
		
		//get row number
		$rows = count($seller_list);
		$cols = count($date_list);
		
		for($col = 0; $col < $cols-1; $col++ ) {
			$sum = 0;
			for ($row = 0; $row < $rows; $row++) {
				if($diffarry[$row][$col]<0){
					$sum += $diffarry[$row][$col];			
				}
			}	
			$chartarry[] = array('date' => $date_list[$col+1]['date'],'value' => abs($sum));
		}
		
		//print_r($chartarry);
		
        //result array
        $result = array(
            'label' => "Bar : ".$this->asin,
            'data' => $chartarry
        );

        return $result;
    }

    /**
     *
     * Sorting function
     * @param $array
     * @param $column
     * @param int $direction
     */
    public function array_sort_by_column(&$array, $column, $direction = SORT_ASC) {
        $reference_array = array();

        foreach($array as $key => $row) {
            $reference_array[$key] = $row[$column];
        }

        array_multisort($reference_array, $direction, $array);
    }
    /**
     *  All output
     */
    public function output($arry){
        print_r(json_encode($arry));
    }
};


// Here we create new Analyser instance
$analyser = new Analyser();