<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"> 
<html> 
    <head> 
  <title>JS����������</title> 
  <meta name="GENERATOR" content="Microsoft FrontPage 4.0"> 
  <meta name="ProgId" content="FrontPage.Editor.Document"> 
  <meta name="Originator" content="Microsoft Visual Studio .NET 7.1"> 
  <script language="javascript" > 
/*   
**    ========================================   
**    ������CLASS_LIANDONG_YAO   
**    ���ܣ��༶�����˵�   
**    ���ߣ�YAODAYIZI   
**    ======================================== 
**/ 
     
  function CLASS_SEARCH(array) 
  { 
   //���飬����������Դ 
      this.array=array;   
      this.indexName=''; 
      this.obj=''; 
      //������SELECT 
    // ��������ǰonchange��SELECT ID��Ҫ���õ�SELECT ID 
      this.subSelectChange=function(selectName1,selectName2) 
      { 
      //try 
      //{ 
    var obj1=document.all[selectName1]; 
    var obj2=document.all[selectName2]; 
    var objName=this.toString(); 
    var me=this; 
   
    obj1.onchange=function() 
    { 
         
        me.optionChange(this.options[this.selectedIndex].value,obj2.id) 
    } 
      } 
      //���õ�һ��SELECT 
    // ������indexNameָѡ����,selectNameָselect��ID 
      this.firstSelectChange=function(indexName,selectName)   
      { 
      this.obj=document.all[selectName]; 
      this.indexName=indexName; 
      this.optionChange(this.indexName,this.obj.id) 
      } 
   
  // indexNameָѡ����,selectNameָselect��ID 
      this.optionChange=function (indexName,selectName) 
      { 
    var obj1=document.all[selectName]; 
    var me=this; 
    obj1.length=0; 
    obj1.options[0]=new Option("��ѡ��",''); 
    for(var i=0;i<this.array.length;i++) 
    {     
     
        if(this.array[1]==indexName) 
        { 
        //alert(this.array[1]+" "+indexName); 
      obj1.options[obj1.length]=new Option(this.array[2],this.array[0]); 
        } 
    } 
      } 
       
  } 
  </script> 
    </head> 
    <body> 
    <form name="form1" method="post"> 
         
      <SELECT ID="s1" NAME="s1"  > 
    <OPTION selected></OPTION> 
      </SELECT> 
      <SELECT ID="s2" NAME="s2"  > 
    <OPTION selected></OPTION> 
      </SELECT> 
      <SELECT ID="s3" NAME="s3"> 
    <OPTION selected></OPTION> 
      </SELECT> 

      <SELECT ID="x1" NAME="x1"  > 
    <OPTION selected></OPTION> 
      </SELECT> 
      <SELECT ID="x2" NAME="x2"  > 
    <OPTION selected></OPTION> 
      </SELECT> 
      <SELECT ID="x3" NAME="x3"> 
    <OPTION selected></OPTION> 
      </SELECT> 
      <SELECT ID="x4" NAME="x4"> 
    <OPTION selected></OPTION> 
      </SELECT> 
      <SELECT ID="x5" NAME="x5"> 
    <OPTION selected></OPTION> 
      </SELECT> 
       
  </form> 
    </body>
	
	<script language="javascript"> 
    //����1------------------------------------------------------------- 
    //����Դ 
  var array=new Array(); 
  array[0]=new Array("���ϵ���","��Ŀ¼","���ϵ���"); //���ݸ�ʽ ID������ID������ 
  array[1]=new Array("��������","��Ŀ¼","��������"); 
  array[2]=new Array("�Ϻ�","���ϵ���","�Ϻ�"); 
  array[3]=new Array("�㶫","���ϵ���","�㶫"); 
  array[4]=new Array("��һ�","�Ϻ�","��һ�"); 
  array[5]=new Array("����","�Ϻ�","����");     
  array[6]=new Array("����","�㶫","����"); 
  array[7]=new Array("տ��","�㶫","տ��"); 
  //-------------------------------------------- 
  //���ǵ��ô��� 
  var liandong=new CLASS_LIANDONG_YAO(array) //��������Դ 
  liandong.firstSelectChange("��Ŀ¼","s1"); //���õ�һ��ѡ��� 
  liandong.subSelectChange("s1","s2"); //�����Ӽ�ѡ��� 
  liandong.subSelectChange("s2","s3");
  
   var liandong2=new CLASS_LIANDONG_YAO(array2); 
  //���õ�һ��ѡ��� 
  liandong2.firstSelectChange("��Ŀ¼","x1"); 
  //������ѡ��� 
  liandong2.subSelectChange("x1","x2") 
  liandong2.subSelectChange("x2","x3") 
  liandong2.subSelectChange("x3","x4") 
  liandong2.subSelectChange("x4","x5") 
    </script> 
</html>