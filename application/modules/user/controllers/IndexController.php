<?php

class User_IndexController extends Zend_Controller_Action {

    public function preDispatch() {
        
    }

    public function init() {
        
    }

    public function indexAction() {
		$this->view->form = new Form_AddUser;
    }

    public function addAction() {
        $this->view->form = new Form_AddUser;
		$m = $this->getRequest()->getPost();//$this->getRequest()->getPost();
		print_r($m);				
			if ($this->getRequest()->isPost()) {
				if ($this->view->form->isValid($this->getRequest()->getPost())) {
					print_r($this->view->form->getValues());
				}
			} 
    }
    
    public function updateAction() {
        
        $updateId = base64_decode( $this->_getParam('id') );
        $productMapper = new Application_Model_ProductMapper();
        $productDetailsRowSet = $productMapper->fetchProductDetails( array( 'id' => $updateId ) );
        
        if( count($productDetailsRowSet) ){
            $productDetailsRow = $productDetailsRowSet->current()->toArray();
            $this->view->productDetails = $productDetailsRow;
            $this->view->productDesignNo = $productDetailsRow['code'].$productDetailsRow['series'];

            
            $productDataMapper = new Application_Model_ProductDataMapper();
            $productDataRowSet = $productDataMapper->fetchProductDetails( array( 'product_id' => $productDetailsRow['id'] ) );
            
            if( count($productDataRowSet) ){
                $productDataRow     = $productDataRowSet->toArray();
                $productDataDetails = array();
                
                foreach( $productDataRow as $productData ){
                    $productDataDetails[$productData['color_code']] = $productData;
                }
                
                $this->view->productData = $productDataDetails;
            }
            
            $objPrimaryCategoryMapper = new Application_Model_PrimaryCategoryMapper();
            $primaryCatRowSet = $objPrimaryCategoryMapper->fetchAllByOrder();
            if( count( $primaryCatRowSet ) ){
                $productMapper = new Application_Model_ProductMapper();
                $productRowset = $productMapper->fetchMaxSeriesForAllCode();

                $priCatMaxSeries = array();
                if( count($productRowset) ){
                    $productRow = $productRowset->toArray();
                    foreach( $productRow as $product ){
                        $priCatMaxSeries[$product['code']] = $product['series'];
                    }
                }

                $primaryCatRow = $primaryCatRowSet->toArray();

                $primaryCategoryOpt = array();
                foreach( $primaryCatRow as $primaryCat ){
                    $series            = ( !empty($priCatMaxSeries[$primaryCat['shortcode']]) ? ( $priCatMaxSeries[$primaryCat['shortcode']] + 1 ) : 1000 );
                    $productDesignerNo = $primaryCat['shortcode'].$series;

                    $primaryCategoryOpt[] = array( 'id'         => $primaryCat['id'],
                                                   'name'       => $primaryCat['name'],
                                                   'attributes' => array( 'data-maxcode' => $productDesignerNo,
                                                                          'data-code'    => $primaryCat['shortcode'],
                                                                          'data-series'  => $series ) );
                }
            }

            $txtFieldArr = array();
            $txtFieldMapper = new Application_Model_TextFieldMapper();
            $txtFieldRowSet = $txtFieldMapper->fetchName();
            if( count($txtFieldRowSet) ){
                $txtFieldRow = $txtFieldRowSet->toArray();

                foreach( $txtFieldRow as $txtFieldId => $txtField ){
                    $txtFieldArr[$txtFieldId] = $txtField['name'];
                }

                $this->view->txtFieldArr = $txtFieldArr;
            }

            $attributeArr = array();
            $tagAttributeMapper = new Application_Model_TagAttributeMapper();
            $tagAttributeRowSet = $tagAttributeMapper->fetchCategoryAtribute();
            if( count($tagAttributeRowSet) ){
                $tagAttributeRow = $tagAttributeRowSet->toArray();
                foreach( $tagAttributeRow as $tagAttribute ){
                    $attributeArr[$tagAttribute['tg_cat_name']][$tagAttribute['tg_att_name']] = $tagAttribute['tg_att_name'];
                }
                $this->view->attributeArr = $attributeArr;
            }

            $colourCodeArr = array();
            $colorCodeMapper = new Application_Model_ColorCodeMapper();
            $colorCodeRowset = $colorCodeMapper->fetchColorByOrder();
            if( count( $colorCodeRowset ) ){
                $colorCodeRow = $colorCodeRowset->toArray();
                foreach( $colorCodeRow as $colorCode ){
                    $colourCodeArr[$colorCode['shortcode']] = $colorCode['name'];
                }
                $this->view->colourCodeArr = $colourCodeArr;
            }

            $productForm = new Form_Product( array( 'primary_category'  => $primaryCategoryOpt,
                                                    'product_design_no' => $this->view->productDesignNo,
                                                    'code'              => $productDetailsRow['code'],
                                                    'series'            => $productDetailsRow['series'],
                                                    'txt_field'         => $txtFieldArr,
                                                    'attribute'         => $attributeArr,
                                                    'color_code'        => $colourCodeArr ) );
            $this->view->objProdForm = $productForm;

            if ($this->_request->isPost()) {
                $postValue = $this->getRequest()->getPost();
  
                if( $productForm->isValid( $postValue ) ){

                    $productFields = array();
                    foreach( $txtFieldArr as $field ){
                        if( !empty($postValue[$field] ) ){
                            $productFields[$field] = $postValue[$field];
                        }
                    }

                    $productAttribute = array();
                    foreach( $attributeArr as $key => $attr ){
                        if( !empty($postValue[$key]) ){
                            $productAttribute[$key] = $postValue[$key];
                        }
                    }

                    $product = array( 'primaryCategoryId'  => $postValue['primaryCategory'],
                                      'code'               => $postValue['code'],
                                      'series'             => $postValue['series'],
                                      'supplierDesignerNo' => $postValue['supplierDesignerNo'],
                                      'costPrice'          => $postValue['cp'],
                                      'sellingPrice'       => $postValue['sp'],
                                      'fields'             => json_encode($productFields),
                                      'attributes'         => json_encode($productAttribute),
                                      'isDeleted'          => 'N',
                                      'timestamp'          => time() );

                    $productId = $productMapper->save( new Application_Model_Product($product) );

                    if( !empty($postValue['productcolour']) && $productId ){
                        $productdataMapper = new Application_Model_ProductDataMapper();
                        foreach( $postValue['productcolour'] as $colourCode ){
                            $productData = array( 'colorCode'    => $colourCode,
                                                  'quantity'     => $postValue['quantity_' . $colourCode],
                                                  'productId'    => $productId,
                                                  'costPrice'    => $postValue['cost_price_' . $colourCode],
                                                  'sellingPrice' => $postValue['sell_price_' . $colourCode],
                                                  'img'          => '',
                                                  'barcode'      => '',
                                                  'isDeleted'    => 'N',
                                                  'timestamp'    => time() );
                            $productdataMapper->save( new Application_Model_ProductData($productData) );
                        }
                    }
                    if( $productId ){
                        $this->_helper->redirector('list', 'index', 'product');
                    }

                    try {
                        /* $fileTransfer = new Zend_File_Transfer_Adapter_Http();
                          $fileTransfer->setDestination(APPLICATION_PATH . '/../public/data/product/img')
                          ->addValidator('Count', false, 1)
                          ->addValidator('IsImage', false);

                          $files = $fileTransfer->getFileInfo();

                          foreach ($files as $fieldname => $fileinfo) {

                          if (($fileTransfer->isUploaded($fileinfo['name'])) && ($fileTransfer->isValid($fileinfo['name']))) {
                          $extension = substr($fileinfo['name'], strrpos($fileinfo['name'], '.') + 1);
                          $this->view->product_img = $filename = 'pdct_img_' . date('YmdHis') . '.' . $extension;
                          $imageDir = realpath(APPLICATION_PATH . '/../public/data/product/img/');
                          $fileTransfer->addFilter('Rename', array('target' => $imageDir . '/' . $filename, 'overwrite' => true));
                          $fileTransfer->receive($fileinfo['name']);
                          $serviceImage = new Service_Image_Image($imageDir . '/' . $filename);
                          $serviceImage->resizeToHeight(80);
                          $serviceImage->save($imageDir . '/thumb/' . $filename);
                          }
                          }
                         */                       // var_dump($fileTransfer->getMessages());
                        /* echo 'formData<pre>';
                          print_r($formData);
                          echo '</pre>';
                          exit; */
                    } catch (Exception $exc) {

                        //                echo $exc->getMessage().'<br><br>';
                        //                echo $exc->getTraceAsString();
                    }
                }
            }
        }
    }

    public function addColorVariantAction() {

        $colorMapper = new Application_Model_ColorMapper();
        $color = $colorMapper->fetchAll();
        if (count($color)) {
            $this->view->color = $color = $color->toArray();
        }

        $prodDesign = new Application_Model_ProductDesignMapper();
        $lastCategory = $prodDesign->fetchLast();

        if (count($lastCategory)) {
            $lastCategory = $lastCategory->toArray();

            $this->view->lastCat = $lastCategory[0]['code'];
        }

        if ($this->getRequest()->getPost()) {
            $post = $this->getRequest()->getPost();
        }
    }

    public function listAction() {
        $pageNo = $this->_getParam('page');

        $productDataMapper = new Application_Model_ProductDataMapper();
        $paginatorQuery = $productDataMapper->fetchPaginatorData();

        $paginator = Zend_Paginator::factory($paginatorQuery);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);
        $paginator->setCurrentPageNumber($pageNo);

        $this->view->paginator = $paginator;
        
    }

}

