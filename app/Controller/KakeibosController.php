<?php

class KakeibosController extends AppController{
    public $uses = array('Kakeibo');
    public $components = array('Session');
    public $helpers = array(
        'Html'
       ,'Form'
       ,'Session'
    );

    /*
    * ログイン確認
    */
    public function beforeFilter()
    {
        //TODO;
    }
    
    /*
     * ログイン画面
     */
    public function index(){
        $this->layout = 'login';
    }

    public function login()
    {
        $this->layout = 'login';

        $user = $this->request->data['Kakeibo']['user'];
        $password = $this->request->data['Kakeibo']['password'];
        $loginCheck = $this->Kakeibo->loginCheck($user, $password);

        if(!empty($loginCheck['errors']))
        {
            $errors = $loginCheck['errors'];
            $this->set('errors', $errors);
            return $this->render('index');
        }
        $this->Session->write('login', 'ok');
        return $this->redirect( array('action' => 'top' ) );
    }

    /*
    * TOP画面表示
    */
    public function top()
    {
        //ビヘイビアからレコード取得
        $cashRecords = $this->Kakeibo->getMeisai_f(array(
            'conditions'=> array(
                'method' => 'cash',
            ),
        ));
        $creditRecords = $this->Kakeibo->getMeisai_f(array(
            'conditions'=> array(
                'method' => 'credit',
            ),
        ));

        //ビューにレコードを渡す
        $this->set(compact('cashRecords', 'creditRecords'));
    }

    /*
    * 明細画面表示 
    */
    public function meisaiView()
    {
        $cashRecords = $this->Kakeibo->getMeisai_f(array(
            'conditions'=> array(
                'method' => 'cash',
            ),
        ));
        $creditRecords = $this->Kakeibo->getMeisai_f(array(
            'conditions'=> array(
                'method' => 'credit',
            ),
        ));
        $records = $this->Kakeibo->getMeisai();
        $this->set(compact('cashRecords', 'creditRecords', 'records'));
    }
    
    /*
    * 明細追加
    */
    public function addMeisai(){
        if( $this->request->is('post') ){
            $this->Kakeibo->create();
            if( $this->Kakeibo->save($this->request->data) ){
                $this->Session->setFlash('登録完了！！');
                return $this->redirect( array('action' => 'top') );
            }
            $this->Session->setFlash('登録失敗');
        }
    }

    /*
    * 明細編集
    */
    public function editMeisai($id = null){
        if(!$id){
            throw new NotFoundException(不正な明細です);
        }
        
        $meisai = $this->Kakeibo->findById($id);
        if(!$meisai){
            throw new NotFoundException(不正な明細です);
        }

        if( $this->request->is(array('meisai','put')) ){
            $this->Kakeibo->id = $id;
            if( $this->Kakeibo->save($this->request->data)  ){
                $this->Session->setFlash('編集完了！！');
                return $this->redirect( array('action' => 'top' ) );
            }
            $this->Session->setFlash('編集失敗');
        }

        if(!$this->request->data){
            $this->request->data = $meisai;
        }
    }

    /*
    * 明細削除
    */
    public function deleteMeisai($id=null)
    {
        if ( $this->request->is('get') ){
            throw new MethodNotAllowedException();
        }

        if($this->Kakeibo->delete($id)){
            $this->Session->setFlash('削除完了！！');
            return $this->redirect( array('action' => 'top' ) );
        }
    }
}

