<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"> 
<html> 
    <head> 
  <title>JS联动下拉框</title> 
  <meta name="GENERATOR" content="Microsoft FrontPage 4.0"> 
  <meta name="ProgId" content="FrontPage.Editor.Document"> 
  <meta name="Originator" content="Microsoft Visual Studio .NET 7.1"> 
  <script language="javascript" > 
/*   
**    ========================================   
**    类名：CLASS_LIANDONG_YAO   
**    功能：多级连动菜单   
**    作者：YAODAYIZI   
**    ======================================== 
**/ 
     
  function CLASS_SEARCH(array) 
  { 
   //数组，联动的数据源 
      this.array=array;   
      this.indexName=''; 
      this.obj=''; 
      //设置子SELECT 
    // 参数：当前onchange的SELECT ID，要设置的SELECT ID 
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
      //设置第一个SELECT 
    // 参数：indexName指选中项,selectName指select的ID 
      this.firstSelectChange=function(indexName,selectName)   
      { 
      this.obj=document.all[selectName]; 
      this.indexName=indexName; 
      this.optionChange(this.indexName,this.obj.id) 
      } 
   
  // indexName指选中项,selectName指select的ID 
      this.optionChange=function (indexName,selectName) 
      { 
    var obj1=document.all[selectName]; 
    var me=this; 
    obj1.length=0; 
    obj1.options[0]=new Option("请选择",''); 
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
    //例子1------------------------------------------------------------- 
    //数据源 
  var array=new Array(); 
  array[0]=new Array("华南地区","根目录","华南地区"); //数据格式 ID，父级ID，名称 
  array[1]=new Array("华北地区","根目录","华北地区"); 
  array[2]=new Array("上海","华南地区","上海"); 
  array[3]=new Array("广东","华南地区","广东"); 
  array[4]=new Array("徐家汇","上海","徐家汇"); 
  array[5]=new Array("普托","上海","普托");     
  array[6]=new Array("广州","广东","广州"); 
  array[7]=new Array("湛江","广东","湛江"); 
  //-------------------------------------------- 
  //这是调用代码 
  var liandong=new CLASS_LIANDONG_YAO(array) //设置数据源 
  liandong.firstSelectChange("根目录","s1"); //设置第一个选择框 
  liandong.subSelectChange("s1","s2"); //设置子级选择框 
  liandong.subSelectChange("s2","s3");
  
   var liandong2=new CLASS_LIANDONG_YAO(array2); 
  //设置第一个选择框 
  liandong2.firstSelectChange("根目录","x1"); 
  //设置子选择框 
  liandong2.subSelectChange("x1","x2") 
  liandong2.subSelectChange("x2","x3") 
  liandong2.subSelectChange("x3","x4") 
  liandong2.subSelectChange("x4","x5") 
    </script> 
</html>