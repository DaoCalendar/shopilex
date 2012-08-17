<?php

/**
 * �н鵣��������
 * ============================================================================
 * api˵����
 * init(),��ʼ������Ĭ�ϸ�һЩ����ֵ����cmdno,date�ȡ�
 * getGateURL()/setGateURL(),��ȡ/������ڵ�ַ,�������ֵ
 * getKey()/setKey(),��ȡ/������Կ
 * getParameter()/setParameter(),��ȡ/���ò���ֵ
 * getAllParameters(),��ȡ���в���
 * getRequestURL(),��ȡ����������URL
 * doSend(),�ض��򵽲Ƹ�֧ͨ��
 * getDebugInfo(),��ȡdebug��Ϣ
 * 
 * ============================================================================
 *
 */

require ("RequestHandler.class.php");

class MediPayRequestHandler extends RequestHandler {
	
	function __construct() {
		$this->MediPayRequestHandler();
	}
	
	function MediPayRequestHandler() {
		//Ĭ��֧����ص�ַ
		$this->setGateURL("https://www.tenpay.com/cgi-bin/med/show_opentrans.cgi");	
	}
	
	/**
	*@Override
	*��ʼ������Ĭ�ϸ�һЩ����ֵ��
	*/
	function init() {
		//�Զ�����ԭ���
		$this->setParameter("attach", "1");
		
		//ƽ̨���ʺ�
		$this->setParameter("chnid",  "");
		
		//�������
		$this->setParameter("cmdno", "12");
		
		//�������� 1:gbk 2:utf-8
		$this->setParameter("encode_type", "1");
		
		//����˵�������ܰ�<>����%�����ַ�
		$this->setParameter("mch_desc", "");
		
		//��Ʒ��ƣ����ܰ�<>����%�����ַ�
		$this->setParameter("mch_name", "");
		
		//��Ʒ�ܼۣ���λΪ�֡�
		$this->setParameter("mch_price",  "");
		
		//�ص�֪ͨURL
		$this->setParameter("mch_returl",  "");
		
		//�������ͣ�1��ʵ�ｻ�ף�2�����⽻��
		$this->setParameter("mch_type",  "");
		
		//�̼ҵĶ�����
		$this->setParameter("mch_vno",  "");
		
		//�Ƿ���Ҫ�ڲƸ�ͨ�������Ϣ��1����Ҫ��2������Ҫ��
		$this->setParameter("need_buyerinfo",  "");
		
		//���ҲƸ�ͨ�ʺ�
		$this->setParameter("seller",  "");
		
		//֧������̻�֧�����չʾҳ��
		$this->setParameter("show_url",  "");
		
		//������˾��������ʽ˵��
		$this->setParameter("transport_desc",  "");
		
		//������֧������������
		$this->setParameter("transport_fee",  "");
		
		//�汾��
		$this->setParameter("version",  "2");
		
		//ժҪ
		$this->setParameter("sign",  "");
		
	}
	
}

?>