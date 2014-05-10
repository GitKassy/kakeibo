<?php

App::uses('ModelBehavior', 'Model');

class KakeiboBehavior extends ModelBehavior
{
    /**
     * 明細をすべて取得する
     * 取得するカラムは以下
     *     ・pay_date
     *     ・money
     *     ・method
     * デフォルトでは今月の明細を取得
     * 指定可能なオプションは以下
     * 個人利用なのでlimitは設けない
     *    ・pay_date
     *    ・category
     *    ・method
     */
    public function getMeisai(Model $model, $options=array())
    {
        $preParams = array(
            'fields' => array(
                'id',
                'pay_date',
                'category',
                'money',
                'method',
            ),
        );
        $params = $this->_generateParams($preParams, $options);
        $records = $model->find('all', $params);
        return $records;
    }

    /**
     * 明細を取得し
     * 取得したレコード配列を組み替える
     * return array
     * 返し方
     * ['Meisai'] = array(
     *     ['category1'] => array(
     *         [0] = array(
     *             [key1] = ...,
     *             [key2] = ...,
     *             [keyn] = ...,
     *         ),
     *         [1] = array( ...),
     *         [n] = array( ...),
     *     ),
     *     ['category2'] => array(
     *         [0] = array(
     *             [key1] = ...,
     *             [key2] = ...,
     *             [keyn] = ...,
     *         ),
     *         [1] = array( ...),
     *         [n] = array( ...),
     *     ),
     *     ['categoryN'] => array(
     *         [0] = array(
     *             [key1] = ...,
     *             [key2] = ...,
     *             [keyn] = ...,
     *         ),
     *         [1] = array( ...),
     *         [n] = array( ...),
     *     ),
     * )
     * 
     */
    public function getMeisai_f(Model $model, $options=array())
    {
        $preParams = array(
            'fields' => array(
                'id',
                'pay_date',
                'category',
                'money',
            ),
        );
        $params = $this->_generateParams($preParams, $options);
        $records = $model->find('all', $params);
        
        //配列の組み換え
        $resultOfArray = array();
        foreach($records as $record){
            if(!array_key_exists($record['Kakeibo']['category'], $resultOfArray)){
                $resultOfArray[$record['Kakeibo']['category']][] = Hash::remove($record['Kakeibo'], "category");
            }else{
                $resultOfArray[$record['Kakeibo']['category']][count($resultOfArray[$record['Kakeibo']['category']])] = Hash::remove($record['Kakeibo'], "category");
            }
        }
        $records = array('Meisai' => $resultOfArray);
        
        return $records;
    }

    public function loginCheck(Model $model, $user, $password)
    {
        $user_pass = array('kassy' => '9608');
        if(!array_key_exists($user, $user_pass))
        {
            $errors[] ='ユーザー名またはパスワードが違います';
            return array('errors' => $errors);
            if($password != $user_pass[$user])
            {
                $errors[] ='ユーザー名またはパスワードが違います';
                return array('errors' => $errors);
            }
        }

        return true;
    }

    //--------------------------------------
    // default
    //--------------------------------------
    private $_params = array(
        'conditions' => array(),
        'fields' => array(),
    );

    private $categories = array(
        '食事',
        '日用品',
        '本',
        '趣味',
        '服',
        '交通費',
        '光熱費',
        '医療',
    );

    //--------------------------------------
    // private method
    //--------------------------------------

    private function _generateParams($preParams, $options)
    {
        $merge_options = $this->merge($options, $preParams);
        $params = $this->_generateAdjustParams($merge_options);
        return $params;
    }
    
    /**
    * pay_dateに関するoptionsがない場合に今月を指定する
    *
    * return array 
    */
    private function _generateAdjustParams($options)
    {
    $params = $this->_params;
    foreach($params as $key => $val) {
        if(array_key_exists($key, $options)) {
            $params[$key] = $options[$key];
        }
    }

    array_change_key_case($params, CASE_LOWER);
    if(
    !array_key_exists('pay_date', $params['conditions']) &&
    !array_key_exists('pay_date >=', $params['conditions']) &&
    !array_key_exists('pay_date <=', $params['conditions']) &&
    !array_key_exists('pay_date BETWEEN ? AND ?', $params['conditions'])
    ){
        if(date('d', time()) <= 25){
            $params['conditions']['pay_date BETWEEN ? AND ?'] = array(date("Y-m-26", strtotime('-1 month')), date("Y-m-25", time()) );
        }else{
            $params['conditions']['pay_date BETWEEN ? AND ?'] = array(date("Y-m-26", time()), date("Y-m-25", strtotime('+1 month')) );
        }
    }else{
        if(array_key_exists('pay_date', $params['conditions']) && is_null($params['conditions']['pay_date'])){
            unset($params['conditions']['pay_date']);
        }elseif(array_key_exists('pay_date >=', $params['conditions']) && is_null($params['conditions']['pay_date >='])){
            unset($params['conditions']['pay_date >=']);
        }elseif(array_key_exists('pay_date <=', $params['conditions']) && is_null($params['conditions']['pay_date <='])){
            unset($params['conditions']['pay_date <=']);
        }elseif(array_key_exists('pay_date BETWEEN ? AND ?', $params['conditions']) && is_null($params['conditions']['pay_date BETWEEN ? AND ?'])){
            unset($params['conditions']['pay_date BETWEEN ? AND ?']);
       } 
    }
    return $params;
    }

    /**
    * 配列同士を連結し、連結した配列を返す
    *
    * 第3引数の指定があれば配列2で配列1の対象キーの値を上書きし、
    * 指定がなければ上書きしない。
    * LIMITが指定されていなければデフォルト値を指定する。
    * merge_overwrite_keyが文字列だった場合、配列に変換。
    *
    * @param array $array1 配列1
    * array $array2 配列2
    * array $merge_overwrite_key 上書き対象キー
    *
    * return array 配列1と配列2を連結した配列
    */
    private function merge($array1, $array2, $overwrite_key = array())
    {
        if(empty($overwrite_key)) {
            return array_merge($array1, $array2);
        } elseif(!is_array($overwrite_key)) {
            $overwrite_key = array($overwrite_key);
        }

        //変数の整形
        $array1 = array_change_key_case($array1, CASE_LOWER);
        $array2 = array_change_key_case($array2, CASE_LOWER);
        $overwrite_key = array_change_key_case($overwrite_key, CASE_LOWER);
        
        foreach($array1 as $key => $val) {
            if(array_key_exists($key, $array2)) {
                if(array_search($key, $overwrite_key) !== false) {
                    $array1[$key] = $array2[$key];
                    unset($array2[$key]);
                }
            }
        }
        $array1 = Hash::merge($array1, $array2);
        return $array1;
    }

}
